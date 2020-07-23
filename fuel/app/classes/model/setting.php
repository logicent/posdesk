<?php

class Model_Setting extends \Orm\Model
{
    public const SETTINGS_COLUMN_RIGHT = 'rgt';
    public const SETTINGS_COLUMN_LEFT = 'lft';

	protected static $_properties = array(
		"id" => array(
			"label" => "Id",
			"data_type" => "int",
		),
		"created_at" => array(
			"label" => "Created at",
			"data_type" => "int",
		),
		"updated_at" => array(
			"label" => "Updated at",
			"data_type" => "int",
		),
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'property' => 'created_at',
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'property' => 'updated_at',
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'settings';

	protected static $_primary_key = array('id');

	protected static $_has_many = array(
	);

	protected static $_many_many = array(
	);

	protected static $_has_one = array(
	);

	protected static $_belongs_to = array(
	);

    public static function menu_list_items($business, $ugroup)
    {
        return array(
            'business' => array(
                array(
                    'id'     => 'business',
                    'label'  => 'Business',
                    'route'  => 'admin/settings/business',
                    'icon' => 'info',
                    'description' => 'Set official contact info, trading name, logo and business type',
                    'column' => self::SETTINGS_COLUMN_LEFT,
                    'visible' => true, // always TRUE
                ),
                array(
                    'id'     => 'branch',
                    'label'  => 'Branch',
                    'route'  => 'admin/settings/branch',
                    'icon' => 'road',
                    'description' => 'Create a branch or location of your business stores',
                    'column' => self::SETTINGS_COLUMN_RIGHT,
                    'visible' => true, // always TRUE
                ),
                array(
                    'id'     => 'bank_account',
                    'label'  => 'Bank account',
                    'route'  => 'admin/settings/bank/account',
                    'icon' => 'bank',
                    'description' => 'Add bank accounts used to enter payments and deposits',
                    'column' => self::SETTINGS_COLUMN_LEFT,
                    'visible' => true, // always TRUE
                ),
                array( // Invoice, Payment
                    'id'     => 'document_serial',
                    'label'  => 'Document serial',
                    'route'  => 'admin/settings/serial',
                    'icon' => 'file-o',
                    'description' => 'Set starting/next serial numbers for transaction documents',
                    'column' => self::SETTINGS_COLUMN_RIGHT,
                    'visible' => false, // always TRUE
                ),
                array( // Cashier Profile
                    'id'     => 'cashier_profile',
                    'label'  => 'Cashier profile',
                    'route'  => 'admin/settings/cashier/profile',
                    'icon' => 'book',
                    'description' => 'Set default options and assign users to POS profiles',
                    'column' => self::SETTINGS_COLUMN_RIGHT,
                    'visible' => true, // always TRUE
                ),
            ),
            'payments' => array(
                array(
                    'id'     => 'taxes',
                    'label'  => 'Taxes & charges',
                    'route'  => 'admin/settings/tax',
                    'icon' => 'percent',
                    'description' => 'Add taxes used to apply extra fees to invoices and bills',
                    'column' => self::SETTINGS_COLUMN_LEFT,
                    'visible' => true, // always TRUE
                ),
                array(
                    'id'     => 'payment_method',
                    'label'  => 'Payment method',
                    'route'  => 'admin/settings/payment/method',
                    'icon' => 'money',
                    'description' => 'Add payment options used to receive and make settlements',
                    'column' => self::SETTINGS_COLUMN_RIGHT,
                    'visible' => true, // always TRUE
                ),
            ),
            'email' => array(
                array(
                    'id'     => 'email_settings',
                    'label'  => 'Email settings',
                    'route'  => 'admin/settings/email/settings',
                    'icon' => 'envelope-o',
                    'description' => 'Set email SMTP configuration for sending mails',
                    'column' => self::SETTINGS_COLUMN_RIGHT,
                    'visible' => true, // always TRUE
                ),
                // array(
                //     'id'     => 'email_templates',
                //     'label'  => 'Email templates',
                //     'route'  => 'settings/email-templates',
                    // 'description' => '&nbsp;',
                        // 'column' => self::SETTINGS_COLUMN_LEFT,
                // ),
            ),
            // permissions
            // roles
            // language text
        );
    }
}
