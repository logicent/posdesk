<?php

class Controller_Pos_Settings extends Controller_Authenticate
{

	public function action_index()
	{
		// settings landing page
		$this->template->title = 'Settings';
		$this->template->content = View::forge('settings/index');
	}

}
