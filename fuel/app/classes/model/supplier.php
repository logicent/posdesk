<?php
use Orm\Model;

class Model_Supplier extends Model
{
	protected static $_properties = array(
        'id',
        'supplier_name',
        'supplier_type',
        'supplier_group',
        'bank_account',
        'billing_currency',
        'tax_ID', //
        'mobile_phone',
        'email_address',
        'sex',
        'title_of_courtesy',
        'first_billed',
        'last_billed',
        'credit_limit',
        'is_internal_supplier',
        'inactive',
        'on_hold',
        'on_hold_from',
        'on_hold_to',
        'remarks',
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

	protected static $_table_name = 'supplier';

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('supplier_name', 'Supplier Name', 'required|max_length[140]');
		$val->add_field('supplier_type', 'Supplier Type', 'required|max_length[140]');
		$val->add_field('email_address', 'Email Address', 'valid_email|max_length[140]');
		$val->add_field('mobile_phone', 'Mobile Phone', 'required|max_length[140]');

		return $val;
	}

	public static function listOptionsSupplierGroup()
	{
		return array(
        );
    }
    
    public static function listOptionsSupplierType()
	{
		return array(
            'Individual' => 'Individual',
            'Company' => 'Company',
        );
    }

    public static function listOptions($type = null)
	{
		$items = DB::select('id','supplier_name')
						->from(self::$_table_name)
						->where([
                            'inactive' => false,
                            // 'supplier_type' => $type
                        ])
						->execute()
						->as_array();
        
		$list_options = array('' => '&nbsp;');

		foreach($items as $item) {
			$list_options[$item['id']] = $item['supplier_name'];
        }
        
		return $list_options;
	}
}
