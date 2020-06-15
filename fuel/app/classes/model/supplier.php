<?php
use Orm\Model;

class Model_Supplier extends Model
{
	const TOC_MR = 'Mr.';
    const TOC_MS = 'Ms.';
    const TOC_DR = 'Dr.';
    
	public static $toc = array(
        '' => '',
		self::TOC_MR => self::TOC_MR,
		self::TOC_MS => self::TOC_MS,
		self::TOC_DR => self::TOC_DR
    );
    
	const SEX_MALE = 'M';
    const SEX_FEMALE = 'F';
    
	public static $sex = array(
        '' => '',
		self::SEX_MALE => 'Male',
		self::SEX_FEMALE => 'Female'
	);
	
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

}
