<?php

class Controller_Dashboard extends Controller_Authenticate{

	public function action_index()
	{
		// check if business info is defined
		$business = Model_Business::find('first');
		if (!$business) {
			Session::set_flash('warning', 'Add your business information to complete setup.');
			Response::redirect('admin/settings/business/create');
		}

		// check if install is done and default values are set
		$data = array();
		
		$this->template->title = "Dashboard";
		$this->template->content = View::forge('dashboard', $data);

	}

}
