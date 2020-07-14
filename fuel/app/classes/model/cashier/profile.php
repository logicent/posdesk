<?php
use Orm\Model;

class Model_Cashier_Profile extends Model
{
	protected static $_properties = array(
		'id',
		'enabled',
		'document_type',
		'hide_credit_sale',
		// 'ignore_customer_credit_limit',
		// 'hide_sales_return',
		'require_sales_return_reason',
		// 'hide_hold_sale',
		// 'require_approval_to_cancel_sale',
		'default_sale_type',
		'customer_id', // is default NOT restriction
		// 'restrict_sale_to_customer', // if customer_id is NOT default
		'show_sales_person',
		'require_sales_person',
		'branch',
		'location',
		'update_stock',
		'allow_user_item_delete',
		// 'require_item_delete_approval',
		'allow_user_price_edit',
		'show_discount',
		'allow_user_discount_edit',
		'show_shipping',
		'require_shipping', // false
		'show_qty_in_stock',
		'item_group', // is restriction
		'customer_group',
		'price_list',
		'currency',
		'show_currency_symbol',
		'fdesk_user',
		'created_at',
		'updated_at'
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'cashier_profile';

	// protected static $_has_many = array(
	// 	'users' => array(
	// 		'key_from' => 'id',
	// 		'model_to' => 'Model_Cashier_Profile_User',
	// 		'key_to' => 'cashier_profile_id',
	// 		'cascade_save' => false,
	// 		'cascade_delete' => false,
	// 	),
	// 	'payment_methods' => array(
	// 		'key_from' => 'id',
	// 		'model_to' => 'Model_Cashier_Profile_Payment_Method',
	// 		'key_to' => 'cashier_profile_id',
	// 		'cascade_save' => false,
	// 		'cascade_delete' => false,
	// 	),
	// );

	protected static $_has_one = array(
		'customer' => array(
			'key_from' => 'customer_id',
			'model_to' => 'Model_Customer',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'business' => array(
			'key_from' => 'branch',
			'model_to' => 'Model_Business',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'itemgroup' => array(
			'key_from' => 'item_group',
			'model_to' => 'Model_Product_Group',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		// $val->add_field('enabled', 'Enabled', '');
		$val->add_field('document_type', 'Document Type', 'required|max_length[140]');
		$val->add_field('customer_id', 'Customer', 'required|valid_string[numeric]');
		$val->add_field('branch', 'Branch', 'required|valid_string[numeric]');
		$val->add_field('location', 'Location', 'valid_string[numeric]');
		// $val->add_field('update_stock', 'Update Stock', 'required');
		// $val->add_field('allow_user_item_delete', 'Allow User Item Delete', 'required');
		// $val->add_field('allow_user_price_edit', 'Allow User Price Edit', 'required');
		// $val->add_field('allow_user_discount_edit', 'Allow User Discount Edit', 'required');
		// $val->add_field('show_qty_in_stock', 'Display Items In Stock', 'required');
		$val->add_field('item_group', 'Item Group', 'required|valid_string[numeric]');
		$val->add_field('customer_group', 'Customer Group', 'valid_string[numeric]');
		$val->add_field('price_list', 'Price List', 'valid_string[numeric]');
		$val->add_field('currency', 'Currency', 'max_length[140]');
		// $val->add_field('show_currency_symbol', 'Show Currency Symbol', 'required');

		return $val;
	}

}
