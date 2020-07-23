<?php

class Model_Menu extends \Orm\Model
{
    public const MENU_TOP_NAV = 'top';
    public const MENU_SIDE_NAV = 'side';

    public static function menu_list_items($ugroup)
    {
        return array(
            array(
                'id'     => 'cashier',
                'label'  => 'Cashier',
                'route'  => 'cashier',
                'icon' => 'fa-shopping-cart',
                'description' => 'POS order entry and billing',
                'visible' => true, // Uri::segment(1) == 'pos' or $ugroup->id == 3 i.e. user with role Cashier
                'submenu' => array()
            ),
            array(
                'id'     => 'sales',
                'label'  => 'Sales',
                'route'  => 'sales',
                'icon' => 'fa-line-chart',
                'description' => '',
                'visible' => true,
                'submenu' => array(
                    array(
                        'id'     => 'order',
                        'label'  => 'Order',
                        'route'  => 'sales/order',
                        'icon' => 'fa-file-o',
                        'description' => '',
                        'visible' => true,
                    ),
                )
            ),
            array(
                'id'     => 'customer',
                'label'  => 'Customer',
                'route'  => 'customer',
                'icon' => 'fa-users',
                'description' => '',
                'visible' => true,
                'submenu' => array()
            ),
            array(
                'id'     => 'product',
                'label'  => 'Product',
                'route'  => 'product',
                'icon' => 'fa-cubes',
                'description' => '',
                'visible' => true,
                'submenu' => array(
                    array(
                        'id'     => 'group',
                        'label'  => 'Group',
                        'route'  => 'product/group',
                        'icon' => 'fa-cubes',
                        'description' => '',
                        'visible' => true,
                    ),
                    array(
                        'id'     => 'price',
                        'label'  => 'Price list',
                        'route'  => 'product/price/list',
                        'icon' => 'fa-money',
                        'description' => '',
                        'visible' => true,
                    ),
                    array(
                        'id'     => 'location',
                        'label'  => 'Location',
                        'route'  => 'product/location',
                        'icon' => 'fa-map-o',
                        'description' => '',
                        'visible' => true,
                    ),
                    array(
                        'id'     => 'brand',
                        'label'  => 'Brand',
                        'route'  => 'product/brand',
                        'icon' => 'fa-tags',
                        'description' => '',
                        'visible' => true,
                    ),
                )
            ),
            array(
                'id'     => 'reports',
                'label'  => 'Reports',
                'route'  => 'report',
                'icon' => 'fa-bar-chart',
                'description' => '',
                'visible' => true,
                'submenu' => array()
            ),
            array(
                'id'     => 'purchases',
                'label'  => 'Purchases',
                'route'  => 'purchases',
                'icon' => 'fa-truck',
                'description' => '',
                'visible' => false,
                'submenu' => array(
                    array(
                        'id'     => 'order',
                        'label'  => 'Order',
                        'route'  => 'purchase/order',
                        'icon' => 'fa-file-o',
                        'description' => '',
                        'visible' => true,
                    ),
                )
            ),            
        );
    }
}
