<?php

use Orm\Model_Soft;

class Model_Sales_Invoice extends Model_Soft
{
	const SALE_TYPE_CASH_SALE = 'Cash Sale';
	const SALE_TYPE_CREDIT_SALE = 'Credit Sale';
	const SALE_TYPE_SALES_RETURN = 'Sales Return';

	const INVOICE_STATUS_OPEN = 'O'; // Draft i.e. Suspended (Parked) or not Fully Paid i.e. Credit Sale
	const INVOICE_STATUS_CLOSED = 'C'; // Submitted (Paid)
	const INVOICE_STATUS_CANCELED = 'X';

	public static $invoice_status = array(
		self::INVOICE_STATUS_OPEN => 'Open',
		self::INVOICE_STATUS_CLOSED => 'Closed',
		self::INVOICE_STATUS_CANCELED => 'Canceled'
	);

	const INVOICE_PAID_STATUS_NOT_PAID = 'NP';
	const INVOICE_PAID_STATUS_PART_PAID = 'PP';
	const INVOICE_PAID_STATUS_FULL_PAID = 'FP';
	const INVOICE_PAID_STATUS_PLUS_PAID = 'AP';

	public static $invoice_paid_status = array(
		self::INVOICE_PAID_STATUS_NOT_PAID => 'Not paid',
		self::INVOICE_PAID_STATUS_PART_PAID => 'Partly paid',
		self::INVOICE_PAID_STATUS_FULL_PAID => 'Fully paid',
		self::INVOICE_PAID_STATUS_PLUS_PAID => 'Advance paid'
	);

	public $tax_type = '(Incl.)'; // can be (excl.) when that is supported later
	public $tax_rate = 'Vat 14'; // should be set from POS profile or default Sales Tax settings
	public $change_due; // default is 0 should be linked to Sales Payment in Cash Sale mode only

	protected static $_properties = array(
		'id', // invoice_num e.g. SI-00001 or SR-00002 or SI-00003-D
		'invoice_no',
		'po_number', // i.e. ref buyers Purchase Order
		'sale_type', // 'Cash Sale' (default) or 'Credit Sale' or 'Sales Return' set in POS Profile or Sale Settings
		// Sales Return should delink payment(s) from Invoice but save as Customer's unallocated payment
		// 'is_return', // default 0. Require user with permission to return/cancel
		'customer_id',
		'customer_name',
		'issue_date',
		'due_date',
		'status',
		'branch_id',
		'branch_name',
		'source', // e.g. Quotation
		'source_id', // e.g. Quotation id
		'amount_due',
		'amount_paid',
		'paid_status',
		'subtotal',
		'discount_rate',
		'discount_total',
		'amounts_tax_inclusive',
		'tax_total',
		'balance_due',
		'sales_person',
		'notes',
		'shipping_fee',
		'shipping_tax',
		'shipping_address',
		'fdesk_user',
		'created_at',
		'updated_at',
		'deleted_at'
	);

	protected static $_soft_delete = array(
        //'deleted_field' => 'deleted',
        'mysql_timestamp' => true,
    );

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('id', 'Invoice No.', 'max_length[20]');
		$val->add_field('amounts_tax_inclusive', 'Amounts Tax Inclusive', 'valid_string[numeric]');
		// $val->add_field('sale_type', 'Sale Type', 'valid_sale_type');
		$val->add_field('issue_date', 'Issue Date', 'required|valid_date'); // should TODAY date never future except if later posting is allowed
		$val->add_field('due_date', 'Due Date', 'valid_date'); // should equal or exceed issue_date but within accounting period (1-3 months)
		$val->add_field('status', 'Status', 'required|valid_string[alpha]');
		$val->add_field('branch_name', 'Branch Name', 'valid_string[]');
		$val->add_field('branch_id', 'Branch', 'required');
		$val->add_field('source_id', 'Source ID', 'valid_string[numeric]');
		$val->add_field('source', 'Source', 'valid_string[]|max_length[140]');		
		$val->add_field('customer_id', 'Customer', 'required');
		$val->add_field('customer_name', 'Customer Name', 'valid_string[]|max_length[140]');
		$val->add_field('amount_due', 'Amount Due', 'required|valid_string[]');
		$val->add_field('amount_paid', 'Amount Paid', 'required|valid_string[]');
		$val->add_field('balance_due', 'Balance Due', 'required|valid_string[]');
		$val->add_field('subtotal', 'Subtotal', 'required|valid_string[]');
		$val->add_field('discount_rate', 'Discount Rate', 'valid_string[]');
		$val->add_field('discount_total', 'Discount Total', 'valid_string[]');
		$val->add_field('tax_total', 'Tax', 'valid_string[]');
		$val->add_field('shipping_fee', 'Shipping Fee', 'valid_string[]');
		$val->add_field('shipping_tax', 'Shipping Tax', 'valid_string[]');
		$val->add_field('shipping_address', 'Shipping Address', 'max_length[140]');
		$val->add_field('notes', 'Notes', 'max_length[140]');
		$val->add_field('fdesk_user', 'User', 'required|valid_string[numeric]');

		return $val;
	}

	protected static $_table_name = 'sales_invoice';

	protected static $_defaults = array(
		'status' => self::INVOICE_STATUS_OPEN,
		'paid_status' => self::INVOICE_PAID_STATUS_NOT_PAID,
		'amount_due' => 0,
		'amount_paid' => 0,
		'subtotal' => 0,
		// 'discount_rate' => 0,
		// 'discount_total' => 0,
		'tax_total' => 0,
		'amounts_tax_inclusive' => 1,
		'balance_due' => 0,
		'shipping_fee' => 0,
		'shipping_tax' => 0,
	);

	protected static $_belongs_to = array(
		'customer' => array(
			'key_from' => 'customer_id',
			'model_to' => 'Model_Customer',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
        ),
	);

	protected static $_has_many = array(
		'items' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Sales_Invoice_Item',
			'key_to' => 'invoice_id',
			'cascade_save' => true,
			'cascade_delete' => true,
		),
		'payments' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Sales_Payment',
			'key_to' => 'source_id',
			'cascade_save' => true,
			'cascade_delete' => true,
		),
	);

	public static function listOptions()
	{
		$items = DB::select('id','customer_name')
							->from(self::$_table_name)
							->where(array('deleted_at' => null))
							->execute()
							->as_array();
		
		$list_options = array();
		foreach($items as $item)
			$list_options[$item['id']] = $item['customer_name'];

		return $list_options;
	}

	public static function applyDiscountAmount(&$sales_invoice)
	{
		$sales_invoice->amount_due -= $sales_invoice->discount_total;
		$sales_invoice->balance_due = $sales_invoice->amount_due - $sales_invoice->amount_paid;

		if ($sales_invoice->balance_due == 0)
			$sales_invoice->paid_status = self::INVOICE_PAID_STATUS_FULL_PAID;
	}

	public static function getNextSerialNumber()
	{
		$last_entry = self::find('last');
		if ($last_entry)
			return $last_entry->invoice_no + 1; // increment by one
		else 
			return 00001; // initial POS Invoice document serial in settings
    }
    
    public static function getBranchName($invoice)
    {
        return 'Not set';
	}

	public static function getSourceListOptions($source)
	{
		if (empty($source))
			return array();
		return;		
	}

}
