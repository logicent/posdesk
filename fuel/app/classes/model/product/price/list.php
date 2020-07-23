<?php
use Orm\Model;

class Model_Product_Price_List extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'description',
		'enabled',
		'currency',
		'module',
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

	protected static $_has_many = array(
		'item_prices' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Product_Item_Price',
			'key_to' => 'price_list_id',
			'cascade_save' => true,
			'cascade_delete' => true,
		),
    );

	protected static $_table_name = 'product_price_list';

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[140]');
		$val->add_field('description', 'Description', 'max_length[140]');
		$val->add_field('enabled', 'Enabled', 'valid_string[]');
		$val->add_field('currency', 'Currency', 'required|max_length[140]');
		$val->add_field('module', 'Module', 'required|max_length[140]');

		return $val;
	}

	public static function listOptions()
    {
		$query = DB::select('id', 'name')
                    ->from(self::$_table_name)
                    ->where([
                        'enabled' => true,
					]);
		$items = $query->order_by('name', 'ASC')
					->execute()
					->as_array();
        
		$list_options = array('' => '&nbsp;');
		$separator = '&ensp;&ndash;&ensp;';

		foreach($items as $item)
			$list_options[$item['id']] = $item['name'];
        
		return $list_options;
    }
}
