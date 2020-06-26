<?php

class Model_Cashier_Invoice extends Model_Sales_Invoice
{
    public static $sale_type = array(
		'Cash' => 'Cash Sale',
		'Credit' => 'Credit Sale',
    );
    
}
