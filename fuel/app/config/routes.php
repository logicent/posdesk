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
	'_root_'  => 'cashier/index',  // The default route
	'_404_'   => 'cashier/404',    // The main 404 route

	'login' 				=> 'login/login',
	'login/forgot-password' => 'login/lostpassword',
	'logout' 				=> 'login/logout',
	
	'product'				=> 'product/item', // items
	
	'sales'					=> 'sales/invoice',
	'purchases'				=> 'purchase/invoice',
	'cashier'				=> 'cashier/invoice',
	'cashier/save'			=> 'cashier/invoice/save', // as draft i.e. Open can edited and submitted later
	'cashier/submit'  		=> 'cashier/invoice/submit', // as submitted i.e. Unpaid & Open or Paid & Closed
	'cashier/cancel'  		=> 'cashier/invoice/cancel', // as removed i.e. Cancelled e.g. if Open is discarded

    'cashier/print-receipt/:id' => 'cashier/payment/print/$1',

	'cashier/reports'			=> 'cashier/report',
	'cashier/sales-register' 	=> 'cashier/report/sales_register', // sales register
	'cashier/item-wise-sales' 	=> 'cashier/report/item_wise_sales', // view by items sold
	'cashier/daily-sales' 		=> 'cashier/report/daily_sales_summary',

	'admin'  					=> 'admin', // or admin redirects to dashboard
	'admin/reports'				=> 'reports',
	'admin/purchase-register' 		=> 'reports/purchase_register', // purchase register
	'admin/item-wise-purchases' 	=> 'reports/item_wise_purchase', // view by items bought
	'admin/periodic-sales-summary'	=> 'reports/periodic_sales_summary',

);
