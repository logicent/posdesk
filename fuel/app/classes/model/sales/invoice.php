<?php
use Orm\Model_Soft;

class Model_Sales_Invoice extends Model_Soft
{
	const INVOICE_STATUS_OPEN = 'O';
	const INVOICE_STATUS_CLOSED = 'C';
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

	// public $customer_id;

	protected static $_properties = array(
		'id',
		'amounts_tax_inc',
		'issue_date',
		'due_date',
		'status',
		'branch_id',
		'branch_name',
		'customer_name',
		'amount_due',
		'subtotal',
		'disc_total',
		'tax_total',
		'amount_paid',
		'balance_due',
		'paid_status',
		'shipping_address',
		'notes',
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
		$val->add_field('amounts_tax_inc', 'Amounts Tax Incl.', 'valid_string[numeric]');
		$val->add_field('issue_date', 'Issue Date', 'required|valid_date');
		$val->add_field('due_date', 'Due Date', 'valid_date');
		$val->add_field('status', 'Status', 'required|valid_string[alpha]');
		$val->add_field('branch_name', 'Branch Name', 'required');
		$val->add_field('branch_id', 'Branch', 'required');
		$val->add_field('customer_id', 'Customer', 'required');
		$val->add_field('customer_name', 'Customer Name', 'max_length[140]');
		$val->add_field('amount_due', 'Amount Due', 'valid_string[]');
		$val->add_field('amount_paid', 'Amount Paid', 'valid_string[]');
		$val->add_field('balance_due', 'Balance Due', 'required|valid_string[]');
		$val->add_field('subtotal', 'Subtotal', 'required|valid_string[]');
		$val->add_field('disc_total', 'Discount', 'required|valid_string[]');
		$val->add_field('tax_total', 'Tax', 'valid_string[]');
		$val->add_field('shipping_address', 'Shipping Address', 'max_length[255]');
		$val->add_field('notes', 'Notes', 'max_length[255]');
		$val->add_field('fdesk_user', 'User', 'required|valid_string[numeric]');

		return $val;
	}

	protected static $_table_name = 'sales_invoice';

	protected static $_belongs_to = array(
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
		$sales_invoice->amount_due -= $sales_invoice->disc_total;
		$sales_invoice->balance_due = $sales_invoice->amount_due - $sales_invoice->amount_paid;

		if ($sales_invoice->balance_due == 0)
			$sales_invoice->paid_status = self::INVOICE_PAID_STATUS_FULL_PAID;
	}

	public static function getNextSerialNumber()
	{
		if (self::find('last'))
			return self::find('last')->invoice_num + 1; // reference
		else return 1001; // initial record
    }
    
    public static function getBranchName($invoice)
    {
        return '';
	}

}
