<?php

class Controller_Cashier_Profile extends Controller_Authenticate
{
	public function action_index()
	{
		// $data['pos_profiles] = Model_Pos_Profile::get_for_all_users();

		$this->template->title = 'Profiles';
		$this->template->content = View::forge('cashier/profile/index');
	}

}