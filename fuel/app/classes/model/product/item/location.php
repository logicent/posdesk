<?php
use Orm\Model;

class Model_Product_Item_Location extends Model
{
	protected static $_properties = array(
		'id',
		'item_id',
		'location_id',
		'quantity',
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

	protected static $_table_name = 'product_item_location';

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('item_id', 'Item', 'required|valid_string[numeric]');
		$val->add_field('location_id', 'Location', 'required|valid_string[numeric]');
		$val->add_field('quantity', 'Quantity', 'required');

		return $val;
	}

}
