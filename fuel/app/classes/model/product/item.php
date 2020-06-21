<?php
use Orm\Model_Soft;

class Model_Product_Item extends Model_Soft
{
	protected static $_properties = array(
		'id',
		'item_code',
		'item_name',
		'description',
		'quantity',
		'reorder_level',
		'receiving_qty',
		'min_sale_qty',
		'cost_price',
		'unit_price',
        'discount_percent',
		'gl_account_id',
        'fdesk_user',
        'tax_id',
        'group_id',
        'enabled',
        'billable',
        'image_path',
		'created_at',
        'updated_at',
        'deleted_at',
	);

	protected static $_soft_delete = array(
        //'deleted_field' => 'deleted',
        'mysql_timestamp' => false,
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

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('item_code', 'Code', 'required|max_length[20]');
		$val->add_field('item_name', 'Item Name', 'required|max_length[140]');
		$val->add_field('group_id', 'Group', 'valid_string[numeric]');
		$val->add_field('tax_id', 'Tax', 'valid_string[numeric]');
		$val->add_field('gl_account_id', 'GL Account', 'valid_string[numeric]');
		$val->add_field('description', 'Description', 'max_length[140]');
		$val->add_field('quantity', 'Quantity', 'valid_string[numeric]');
		$val->add_field('reorder_level', 'Reorder Level', 'valid_string[numeric]');
		$val->add_field('receiving_qty', 'Receiving Qty', 'valid_string[numeric]');
		$val->add_field('min_sale_qty', 'Min Sales Qty', 'valid_string[numeric]');
		$val->add_field('cost_price', 'Cost Price', 'valid_string[]');
		$val->add_field('unit_price', 'Unit Price', 'valid_string[]');
		$val->add_field('discount_percent', 'Discount %', 'valid_string[]');

		return $val;
	}

	protected static $_table_name = 'product_item';

	public static function getColumnDefault( $name )
	{
		$col_def = DB::list_columns(self::$_table_name, "$name");
		return $col_def["$name"]['default'];
	}

    public static function listOptions($selected, $billable = true)
    {
		$query = DB::select('id', 'item_code', 'item_name')
                    ->from(self::$_table_name)
                    ->where([
                        'enabled' => true,
                        'billable' => $billable
					]);
		if (!empty($selected))
			$query->or_where(['id' => $selected]);
		$items = $query->order_by('item_name', 'ASC')
					->execute()
					->as_array();
        
		$list_options = array('' => '&nbsp;');

		foreach($items as $item) {
			$list_options[$item['id']] = $item['item_code'] .'&ndash;'. $item['item_name'];
        }
        
		return $list_options;
    }

}
