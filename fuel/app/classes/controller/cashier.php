<?php

class Controller_Cashier extends Controller_Authenticate{

	public function action_index()
	{
		// get Invoice profile of current user
		$data = array(); // Model_Pos_Profile::get_current_user()

		$this->template->title = "Cashier";
		$this->template->content = View::forge('pos/invoice/index', $data);
	}

}
