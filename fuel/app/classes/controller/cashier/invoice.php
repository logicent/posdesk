<?php

class Controller_Cashier_Invoice extends Controller_Sales_Invoice
{
	public function action_index()
	{
		// get Invoice profile of current user
		$data = array(); // Model_Pos_Profile::get_current_user()

		$this->template->title = "Cashier";
		$this->template->content = View::forge('cashier/invoice/index', $data);
	}

}
