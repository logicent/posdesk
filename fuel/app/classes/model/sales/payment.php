<?php

use Orm\Model_Soft;

// Paid Amount (Validation and Processing)
// - must be a number input only
// - must equal or be greater than amount due in Cash Sale mode (How to validate tendered amount limit)
// - must equal or be greater than zero but not exceeding the amount due in Credit Sale mode
// - must make a payment entry for each payment method and amount while saving the total amount_paid in Invoice
// - must capture the payment reference for non-Cash payment methods
// - TODO: integrate some payment options like mobile money and bank cards
// Status
// - Cash Sale should set as Closed (can be Cancelled later by User with permission)
// - Credit Sale should be set as Open (until fully paid)
// Paid Status
// - Cash Sale should be set as Fully Paid as validated above
// - Credit Sale should be set as Not Paid or Partially Paid as the case may be
// Credit Sale
// - must not exceed credit_limit of Customer (requires DB query to check all outstanding Credit Sale by Customer)
// - or just read that once when fetching the Customer and validate accordingly
// - must set the due_date in POS Profile or Sales Settings

class Model_Sales_Payment extends Model_Soft
{
	// payment_type
	const PAYMENT_TYPE_ADVANCE = 'Advance'; // against Sales Order
	const PAYMENT_TYPE_ON_DEMAND = 'On-demand'; // against Invoice amount due (whole amount)
	const PAYMENT_TYPE_OUTSTANDING = 'Outstanding'; // against Invoice amount due (partial or whole amount)

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
