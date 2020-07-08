<?php
class Controller_Admin_Settings_Cashier_Profile extends Controller_Authenticate
{

	public function action_index()
	{
		$data['cashier_profiles'] = Model_Cashier_Profile::find('all');
		$this->template->title = "Cashier Profile";
		$this->template->content = View::forge('cashier/profile/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('admin/settings/cashier/profile');

		if ( ! $data['cashier_profile'] = Model_Cashier_Profile::find($id))
		{
			Session::set_flash('error', 'Could not find cashier_profile #'.$id);
			Response::redirect('admin/settings/cashier/profile');
		}

		$this->template->title = "Cashier Profile";
		$this->template->content = View::forge('cashier/profile/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Cashier_Profile::validate('create');

			if ($val->run())
			{
				$cashier_profile = Model_Cashier_Profile::forge(array(
					'enabled' => Input::post('enabled'),
					'document_type' => Input::post('document_type'),
					'customer_id' => Input::post('customer_id'),
					'branch' => Input::post('branch'),
					'location' => Input::post('location'),
					'update_stock' => Input::post('update_stock'),
					'allow_user_item_delete' => Input::post('allow_user_item_delete'),
					'allow_user_price_edit' => Input::post('allow_user_price_edit'),
					'allow_user_discount_edit' => Input::post('allow_user_discount_edit'),
					'show_qty_in_stock' => Input::post('show_qty_in_stock'),
					'item_group' => Input::post('item_group'),
					'customer_group' => Input::post('customer_group'),
					'price_list' => Input::post('price_list'),
					'currency' => Input::post('currency'),
					'show_currency_symbol' => Input::post('show_currency_symbol'),
                    'fdesk_user' => Input::post('fdesk_user'),
				));

				if ($cashier_profile and $cashier_profile->save())
				{
					Session::set_flash('success', 'Added cashier_profile #'.$cashier_profile->id.'.');
					Response::redirect('admin/settings/cashier/profile');
				}
				else
				{
					Session::set_flash('error', 'Could not save cashier_profile.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Cashier_Profiles";
		$this->template->content = View::forge('cashier/profile/create');
	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('admin/settings/cashier/profile');

		if ( ! $cashier_profile = Model_Cashier_Profile::find($id))
		{
			Session::set_flash('error', 'Could not find cashier_profile #'.$id);
			Response::redirect('admin/settings/cashier/profile');
		}

		$val = Model_Cashier_Profile::validate('edit');

		if ($val->run())
		{
			$cashier_profile->enabled = Input::post('enabled');
			$cashier_profile->document_type = Input::post('document_type');
			$cashier_profile->customer = Input::post('customer_id');
			$cashier_profile->branch = Input::post('branch');
			$cashier_profile->location = Input::post('location');
			$cashier_profile->update_stock = Input::post('update_stock');
			$cashier_profile->allow_user_item_delete = Input::post('allow_user_item_delete');
			$cashier_profile->allow_user_price_edit = Input::post('allow_user_price_edit');
			$cashier_profile->allow_user_discount_edit = Input::post('allow_user_discount_edit');
			$cashier_profile->show_qty_in_stock = Input::post('show_qty_in_stock');
			$cashier_profile->item_group = Input::post('item_group');
			$cashier_profile->customer_group = Input::post('customer_group');
			$cashier_profile->price_list = Input::post('price_list');
			$cashier_profile->currency = Input::post('currency');
			$cashier_profile->show_currency_symbol = Input::post('show_currency_symbol');
            $cashier_profile->fdesk_user = Input::post('fdesk_user');

			if ($cashier_profile->save())
			{
				Session::set_flash('success', 'Updated cashier_profile #' . $id);

				Response::redirect('admin/settings/cashier/profile');
			}
			else
			{
				Session::set_flash('error', 'Could not update cashier_profile #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$cashier_profile->enabled = $val->validated('enabled');
				$cashier_profile->document_type = $val->validated('document_type');
				$cashier_profile->customer = $val->validated('customer_id');
				$cashier_profile->branch = $val->validated('branch');
				$cashier_profile->location = $val->validated('location');
				$cashier_profile->update_stock = $val->validated('update_stock');
				$cashier_profile->allow_user_item_delete = $val->validated('allow_user_item_delete');
				$cashier_profile->allow_user_price_edit = $val->validated('allow_user_price_edit');
				$cashier_profile->allow_user_discount_edit = $val->validated('allow_user_discount_edit');
				$cashier_profile->show_qty_in_stock = $val->validated('show_qty_in_stock');
				$cashier_profile->item_group = $val->validated('item_group');
				$cashier_profile->customer_group = $val->validated('customer_group');
				$cashier_profile->price_list = $val->validated('price_list');
				$cashier_profile->currency = $val->validated('currency');
				$cashier_profile->show_currency_symbol = $val->validated('show_currency_symbol');
                $cashier_profile->fdesk_user = $val->validated('fdesk_user');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('cashier_profile', $cashier_profile, false);
		}

		$this->template->title = "Cashier Profile";
		$this->template->content = View::forge('cashier/profile/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('admin/settings/cashier/profile');

		if ($cashier_profile = Model_Cashier_Profile::find($id))
		{
			$cashier_profile->delete();
			Session::set_flash('success', 'Deleted cashier_profile #'.$id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete cashier_profile #'.$id);
		}

		Response::redirect('admin/settings/cashier/profile');
	}

}
