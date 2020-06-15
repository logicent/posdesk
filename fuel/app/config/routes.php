<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

return array(
	// '_root_'  => 'dashboard/index',  // The default route
	// '_404_'   => 'dashboard/404',    // The main 404 route
	'_root_'  => 'cashier/index',  // The default route
	'_404_'   => 'cashier/404',    // The main 404 route

	'login' 				=> 'login/login',
	'login/forgot-password' => 'login/lostpassword',
	'logout' 				=> 'login/logout',
	
	'users/change-pwd' => 'users/change_password',

	// 'pos'					=> 'pos', // redirects to cashier
	'cashier'				=> 'cashier', // pos/invoice
	'sales'					=> 'sales/invoice',
	'customers'				=> 'customer',
	'products'				=> 'product/item', // items
	'invoice/save'  		=> 'pos/invoice/save', // as draft i.e. Open can edited and submitted later
	'invoice/submit'  		=> 'pos/invoice/submit', // as submitted i.e. Unpaid & Open or Paid & Closed
	'invoice/cancel'  		=> 'pos/invoice/cancel', // as removed i.e. Cancelled e.g. if Open is discarded
	'invoice/item/search'  		=> 'pos/invoice/item/search',
	'invoice/item/add-to-bill'  => 'pos/invoice/item/add',

	'pos/reports'  				=> 'pos/report',
	'report/sales-register' 	=> 'report/sales-register', // sales register
	'report/item-wise-sales' 	=> 'report/item-wise-sales', // view by items sold

	'reports'  						=> 'reports',
	'report/purchase-register' 		=> 'admin/report/purchase-register', // purchase register
	'report/item-wise-purchases' 	=> 'admin/report/item-wise-purchase', // view by items bought
	// 'reports/show-daily-report' 	=> 'reports/show_daily',
	// 'reports/show-monthly-report'	=> 'reports/show_monthly',

	'admin'  					=> 'admin', // redirects to dashboard
	'admin/dashboard'  			=> 'dashboard',
	'admin/purchases'			=> 'purchases/invoice',
	'admin/suppliers'			=> 'supplier',
	'admin/users'  			=> 'users',
	'admin/settings'  			=> 'settings',
);
