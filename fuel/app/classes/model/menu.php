<?php

class Model_Menu extends \Orm\Model
{
    public const MENU_TOP_NAV = 'top';
    public const MENU_SIDE_NAV = 'side';

    public static function menu_list_items($ugroup)
    {
        return array(
            // 'billing' => array(
            //     'id' => 1,
            //     'name' => 'Billing &amp; Payments',
            //     'icon' => 'fa-money',
            //     'column' => self::MENU_SIDE_NAV,
            //     'visible' => true,
            //     'hide_menu_group_label' => true, // TODO: use general settings for user preferences
            //     'items' => array(
                    array(
                        'id'     => 'cashier',
                        'label'  => 'Cashier',
                        'route'  => 'cashier',
                        'icon' => 'fa-shopping-cart',
                        'description' => 'POS order entry and billing',
                        'visible' => true, // Uri::segment(1) == 'pos' or $ugroup->id == 3 i.e. user with role Cashier
                    ),
            //     ),
            // ),
        );
    }
}
