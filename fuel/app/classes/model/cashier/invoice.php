<?php
use Orm\Model_Soft;

class Model_Cashier_Invoice extends Model_Soft
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

	public static $invoice_paid_status = array(
		self::INVOICE_PAID_STATUS_NOT_PAID => 'Not paid',
		self::INVOICE_PAID_STATUS_PART_PAID => 'Partly paid',
		self::INVOICE_PAID_STATUS_FULL_PAID => 'Fully paid',
	);

	// public $customer_id;

	protected static $_properties = array(
		'id', // invoice_num e.g. SI-00001 or SR-00002 or SI-00003-D
		// 'po_number', // i.e. ref buyers Order
		'customer_id',
		'customer_name',
		'issue_date',
		'due_date',
		'status',
		// 'source', // e.g. Quotation
		// 'source_id', // e.g. Quotation id
		'amount_due',
		'amount_paid',
		'paid_status',
		'subtotal',
		'disc_total',
		'amounts_tax_inc',
		'tax_total',
		'balance_due',
		'notes',
		'branch_id',
		'branch_name',
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
		$val->add_field('id', 'POS #', 'required|valid_string[alphanumeric]');
		$val->add_field('customer_name', 'Customer Name', 'required|max_length[140]');
		$val->add_field('po_number', 'PO Number', 'max_length[10]');
		$val->add_field('issue_date', 'Issue Date', 'required|valid_date');
		$val->add_field('due_date', 'Due Date', 'valid_date');
		$val->add_field('status', 'Status', 'required|valid_string[alpha]');
		// $val->add_field('source', 'Source', 'required');
		// $val->add_field('source_id', 'Source Order Ref', 'required');
		$val->add_field('amount_due', 'Amount Due', 'valid_string[]');
		$val->add_field('amount_paid', 'Amount Paid', 'valid_string[]');
		$val->add_field('advance_paid', 'Advance Paid', 'valid_string[]');
		$val->add_field('disc_total', 'Discount', 'required|valid_string[]');
		$val->add_field('amounts_tax_inc', 'Amounts Tax Incl.', 'valid_string[numeric]');
		$val->add_field('tax_total', 'Tax', 'valid_string[]');
		$val->add_field('balance_due', 'Balance Due', 'required|valid_string[]');
		$val->add_field('notes', 'Notes', 'max_length[255]');
		$val->add_field('fdesk_user', 'Frontdesk User', 'required|valid_string[numeric]');

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
			'model_to' => 'Model_Cashier_Invoice_Item',
			'key_to' => 'invoice_id',
			'cascade_save' => true,
			'cascade_delete' => true,
		),
		'payments' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Cashier_Payment',
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

	public static function applyDiscountAmount(&$pos_invoice)
	{
		$pos_invoice->amount_due -= $pos_invoice->disc_total;
		$pos_invoice->balance_due = $pos_invoice->amount_due - $pos_invoice->amount_paid;

		if ($pos_invoice->balance_due == 0)
			$pos_invoice->paid_status = self::INVOICE_PAID_STATUS_FULL_PAID;
	}

	public static function getNextSerialNumber()
	{
		$last_entry = self::find('last');
		if ($last_entry)
			return $last_entry->id + 1; // increment by one
		else 
			return 00001; // initial POS Invoice document serial in settings
    }
    
    public static function getBranchName()
    {
        return 'Location or Branch name';
	}

	public static function getSourceListOptions($source)
	{
		if (empty($source))
			return array();
		
		if ($source == self::INVOICE_SOURCE_LEASE)
			return Model_Lease::listOptions();
	
		if ($source == self::INVOICE_SOURCE_BOOKING)
			return Model_Facility_Booking::listOptions();
	}

	public static function getSourceName($business)
	{
		$source= array('' => '&nbsp;');
		if ($business->service_accommodation || $business->service_hire)
			$source[self::INVOICE_SOURCE_BOOKING] = self::INVOICE_SOURCE_BOOKING;
		
		if ($business->service_rental || $business->service_sale)
			$source[self::INVOICE_SOURCE_LEASE] = self::INVOICE_SOURCE_LEASE;
		
		return $source;
	}
}
