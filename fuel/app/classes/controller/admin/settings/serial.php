<?php

class Controller_Admin_Settings_Serial extends Controller_Authenticate
{
	public function action_index()
	{
		$data['serial'] = Model_Accounts_Serial::find('all');
		$this->template->title = "Document Serial";
		$this->template->content = View::forge('settings/doc_serial/index', $data);
	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('admin/settings/serial');

		if ( ! $data['doc_serial'] = Model_Accounts_Serial::find($id))
		{
			Session::set_flash('error', 'Could not find tax #'.$id);
			Response::redirect('admin/settings/serial');
		}

		$this->template->title = "Document Serial";
		$this->template->content = View::forge('settings/doc_serial/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Accounts_Serial::validate('create');

			if ($val->run())
			{
				$tax = Model_Accounts_Serial::forge(array(
					'code' => Input::post('code'),
					'name' => Input::post('name'),
					'start' => Input::post('start'),
					'next' => Input::post('next'),
                    'enabled' => Input::post('enabled'),
					'fdesk_user' => Input::post('fdesk_user'),
				));

				if ($tax and $tax->save())
				{
					Session::set_flash('success', 'Added document serial #'.$tax->name.'.');
					Response::redirect('admin/settings/serial');
				}
				else
				{
					Session::set_flash('error', 'Could not save document serial.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Document Serial";
		$this->template->content = View::forge('settings/doc_serial/create');
	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('admin/settings/serial');

		if ( ! $doc_serial = Model_Accounts_Serial::find($id))
		{
			Session::set_flash('error', 'Could not find document serial #'.$id);
			Response::redirect('admin/settings/serial');
		}

		$val = Model_Accounts_Serial::validate('edit');

		if ($val->run())
		{
            $doc_serial->code = Input::post('code');
            $doc_serial->name = Input::post('name');
            $doc_serial->start = Input::post('start');
            $doc_serial->next = Input::post('next');
            $doc_serial->enabled = Input::post('enabled');
            $doc_serial->fdesk_user = Input::post('fdesk_user');

			if ($doc_serial->save())
			{
				Session::set_flash('success', 'Updated document serial #' . $doc_serial->name);
				Response::redirect('admin/settings/serial');
			}
			else
			{
				Session::set_flash('error', 'Could not update document serial #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$doc_serial->code = $val->validated('code');
                $doc_serial->name = $val->validated('name');
                $doc_serial->start = $val->validated('start');
                $doc_serial->next = $val->validated('next');
                $doc_serial->enabled = $val->validated('enabled');
                $doc_serial->fdesk_user = $val->validated('fdesk_user');

				Session::set_flash('error', $val->error());
			}
			$this->template->set_global('doc_serial', $doc_serial, false);
		}

		$this->template->title = "Document Serial";
		$this->template->content = View::forge('settings/doc_serial/edit');
	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('admin/settings/serial');

		if (Input::method() == 'POST')
		{
			if ($tax = Model_Accounts_Serial::find($id))
			{
				$tax->delete();
				Session::set_flash('success', 'Deleted document serial #'.$id);
			}
			else
			{
				Session::set_flash('error', 'Could not delete document serial #'.$id);
			}
		}
		else
		{
			Session::set_flash('error', 'Delete is not allowed');
		}

		Response::redirect('admin/settings/serial');
	}

}
