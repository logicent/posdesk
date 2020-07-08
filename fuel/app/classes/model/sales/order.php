<?php
use Orm\Model_Soft;

class Model_Sales_Order extends Model_Soft
{
	const ORDER_STATUS_OPEN = 'O';
	const ORDER_STATUS_CLOSED = 'C';
	const ORDER_STATUS_CANCELED = 'X';

	public static $order_status = array(
		self::ORDER_STATUS_OPEN => 'Open',
		self::ORDER_STATUS_CLOSED => 'Closed',
		self::ORDER_STATUS_CANCELED => 'Canceled'
	);

	const ORDER_PAID_STATUS_NOT_PAID = 'NP';
	const ORDER_PAID_STATUS_PART_PAID = 'PP';
	const ORDER_PAID_STATUS_FULL_PAID = 'FP';
	const ORDER_PAID_STATUS_PLUS_PAID = 'AP';

	public static $order_paid_status = array(
		self::ORDER_PAID_STATUS_NOT_PAID => 'Not paid',
		self::ORDER_PAID_STATUS_PART_PAID => 'Partly paid',
		self::ORDER_PAID_STATUS_FULL_PAID => 'Fully paid',
		self::ORDER_PAID_STATUS_PLUS_PAID => 'Advance paid'
	);

	// public $customer_id;

	protected static $_properties = array(
		'id',
		'amounts_tax_inc',
		'issue_date',
		'due_date',
		'status',
		// 'source',
		// 'source_id',
		'customer_name',
		'amount_due',
		'disc_total',
		'tax_total',
		'amount_paid',
		'balance_due',
		'advance_paid',
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
		$val->add_field('amounts_tax_inc', 'Amounts Tax Incl.', 'valid_string[numeric]');
		$val->add_field('issue_date', 'Issue Date', 'required|valid_date');
		$val->add_field('due_date', 'Due Date', 'valid_date');
		$val->add_field('status', 'Status', 'required|valid_string[alpha]');
		// $val->add_field('source', 'Source', 'required');
		// $val->add_field('source_id', 'Source Order Ref', 'required');
		$val->add_field('customer_name', 'Customer Name', 'required|max_length[140]');
		$val->add_field('amount_due', 'Amount Due', 'valid_string[]');
		$val->add_field('amount_paid', 'Amount Paid', 'valid_string[]');
		$val->add_field('balance_due', 'Balance Due', 'required|valid_string[]');
		$val->add_field('advance_paid', 'Advance Paid', 'valid_string[]');
		$val->add_field('disc_total', 'Discount', 'required|valid_string[]');
		$val->add_field('tax_total', 'Tax', 'valid_string[]');
		$val->add_field('shipping_address', 'Billing Address', 'max_length[255]');
		$val->add_field('notes', 'Notes', 'max_length[255]');
		$val->add_field('fdesk_user', 'Frontdesk User', 'required|valid_string[numeric]');

		return $val;
	}

	protected static $_table_name = 'sales_order';

	protected static $_has_one = array(
		'invoice' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Sales_Invoice',
			'key_to' => 'source_id',
			'cascade_save' => false,
			'cascade_delete' => false,
        ),
	);

	protected static $_has_many = array(
		'items' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Sales_Order_Item',
			'key_to' => 'order_id',
			'cascade_save' => true,
			'cascade_delete' => true,
		),
		'receipts' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Accounts_Payment_Receipt',
			'key_to' => 'source_id',
			'cascade_save' => true,
			'cascade_delete' => true,
		),
	);

	public static function listOptions()
	{
		$items = DB::select('id','order_num')->from(self::$_table_name)->execute()->as_array();

		$list_options = array();
		foreach($items as $item)
			$list_options[$item['id']] = $item['order_num'];

		return $list_options;
	}

	public static function getNextSerialNumber()
	{
		if (self::find('last'))
			return self::find('last')->order_num + 1; // reference
		else return 1001; // initial record
    }
    
}
