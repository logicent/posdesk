<?php
use Orm\Model;

class Model_Product_Item_Attribute extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'description',
		'item_id',
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

	protected static $_table_name = 'product_item_attribute';

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[140]');
		$val->add_field('description', 'Description', 'required|max_length[140]');
		$val->add_field('item_id', 'Item', 'required|valid_string[numeric]');

		return $val;
	}

}
