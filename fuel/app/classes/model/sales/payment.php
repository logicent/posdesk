<?php

use Orm\Model_Soft;

class Model_Sales_Payment extends Model_Soft
{
	// payment_type
	// card_type
	protected static $_properties = array(
		'id',
		'receipt_number',
		'type',
		'source',
		'source_id',
		'date_paid',
        'payer',
        'payment_method',
        'reference',
        'status',
        'attachment',
		'amount_due',
		'amount_paid',
		'change_due',
		'description',
		'fdesk_user',
		'created_at',
		'updated_at',
		'deleted_at'
	);

	protected static $_table_name = 'sales_payment';

	protected static $_soft_delete = array(
		//'deleted_field' => 'deleted_at',
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
		$val->add_field('receipt_number', 'Reference', 'required|valid_string[numeric]');
		$val->add_field('type', 'Type', 'required');
		$val->add_field('source', 'Source', 'required');
		$val->add_field('source_id', 'Source ref.', 'required|valid_string[numeric]');
		$val->add_field('date_paid', 'Date Paid', 'required|valid_date');
		$val->add_field('payer', 'Payer', 'max_length[140]');
		$val->add_field('amount_due', 'Amount Due', 'required|valid_string[]');
		$val->add_field('amount_paid', 'Amount Paid', 'required|valid_string[]');
		$val->add_field('change_due', 'Change Due', 'required|valid_string[]');
		$val->add_field('payment_method', 'Payment Method', 'required');
		$val->add_field('reference', 'Payment Reference', 'valid_string[alphanumeric]');
		$val->add_field('status', 'Status', 'required');
		$val->add_field('description', 'Description', 'max_length[140]');
		$val->add_field('attachment', 'Attachment', 'max_length[140]');

		$val->set_message('numeric_min', 'Amount must be 0 or greater'); // preferrably greater than 0 in create mode

		return $val;
	}

	// protected static $_table_name = 'cash_receipt';

	protected static $_belongs_to = array(
		'invoice' => array(
			'key_from' => 'source_id',
			'model_to' => 'Model_Sales_Invoice',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	public static function getNextSerialNumber()
	{
		$last_entry = self::find('last');
		if ($last_entry)
			return $last_entry->receipt_number + 1; // increment by one
		else 
			return 00001; // initial POS Receipt serial in settings
	}

}
