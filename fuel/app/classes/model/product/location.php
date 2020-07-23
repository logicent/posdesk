<?php
use Orm\Model;

class Model_Product_Location extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'description',
		'enabled',
		'branch_id',
		'fdesk_user',
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

	protected static $_belongs_to = array(
		'branch' => array(
			'key_from' => 'branch_id',
			'model_to' => 'Model_Business',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
        ),
    );

	protected static $_has_many = array(
		'item_locations' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Product_Item_Location',
			'key_to' => 'location_id',
			'cascade_save' => true,
			'cascade_delete' => true,
		),
	);
	
	protected static $_table_name = 'product_location';

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[140]');
		$val->add_field('description', 'Description', 'max_length[140]');
		$val->add_field('enabled', 'Enabled', 'valid_string[]');
		$val->add_field('branch_id', 'Branch', 'required|valid_string[numeric]');

		return $val;
	}

}
