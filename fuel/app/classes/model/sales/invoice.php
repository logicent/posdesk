<?php

use Orm\Model_Soft;

class Model_Sales_Invoice extends Model_Soft
{
	const INVOICE_STATUS_OPEN = 'O'; // Draft i.e. Suspended (Parked)
	const INVOICE_STATUS_CLOSED = 'C'; // Submitted (Paid or Unpaid)
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

	public $is_new_sale = true; // also id = ''
	public $has_sale_items = false;
	public $tax_type = '(Incl.)'; // will be possibly (excl.) when later supported
	public $tax_rate = 'Vat 14'; // will be set from POS profile or default Sales Tax settings
	public $change_due; // default is 0

	protected static $_properties = array(
		'id', // invoice_num e.g. SI-00001 or SR-00002 or SI-00003-D
		// 'po_number', // i.e. ref buyers Order
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
		$val->add_field('issue_date', 'Issue Date', 'required|valid_date');
		$val->add_field('due_date', 'Due Date', 'valid_date');
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
			'key_to' => 'invoice_id',
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
