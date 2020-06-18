<?php

class Controller_Admin_Settings extends Controller_Authenticate
{

	public function action_index()
	{
		// settings landing page
		$this->template->title = 'Settings';
		$this->template->content = View::forge('settings/index');
	}

}
