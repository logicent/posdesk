<?php

class Controller_Admin extends Controller_Authenticate
{

	public function action_index()
	{
		Response::redirect('admin/dashboard');
		// settings landing page
		$this->template->title = 'Admin';
		$this->template->content = View::forge('dashboard');
	}

}
