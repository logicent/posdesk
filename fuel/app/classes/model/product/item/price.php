<?php
use Orm\Model;

class Model_Product_Item_Price extends Model
{
	protected static $_properties = array(
		'id',
		'item_id',
		'price_list_id',
		'fdesk_user',
		'price_list_rate',
		'created_at',
		'updated_at',
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

	protected static $_table_name = 'product_item_price';

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('item_id', 'Item', 'required|valid_string[numeric]');
		$val->add_field('price_list_id', 'Price List', 'required|valid_string[numeric]');
		$val->add_field('price_list_rate', 'Rate', 'required');

		return $val;
	}

}
