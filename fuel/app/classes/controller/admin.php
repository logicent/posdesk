<?php

class Controller_Admin extends Controller_Authenticate
{

	public function action_index()
	{
		// settings landing page
		$this->template->title = 'Admin';
		$this->template->content = View::forge('dashboard');
	}

}
