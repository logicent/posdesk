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
			Session::set_flash('error', 'Could not find Cashier Profile #'.$id);
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
					'hide_credit_sale' => Input::post('hide_credit_sale'),
					// 'ignore_customer_credit_limit' => Input::post('ignore_customer_credit_limit'),
					// 'hide_sales_return' => Input::post('hide_sales_return'),
					'require_sales_return_reason' => Input::post('require_sales_return_reason'),
					// 'hide_hold_sale' => Input::post('hide_hold_sale'),
					// 'require_approval_to_cancel_sale' => Input::post('require_approval_to_cancel_sale'),
					'default_sale_type' => Input::post('default_sale_type'),
					'customer_id' => Input::post('customer_id'),
					// 'restrict_sale_to_customer' => Input::post('restrict_sale_to_customer'),
					'show_sales_person' => Input::post('show_sales_person'),
					'require_sales_person' => Input::post('require_sales_person'),
					'branch' => Input::post('branch'),
					'location' => Input::post('location'),
					'update_stock' => Input::post('update_stock'),
					'allow_user_item_delete' => Input::post('allow_user_item_delete'),
					// 'require_item_delete_approval' => Input::post('require_item_delete_approval'),
					'allow_user_price_edit' => Input::post('allow_user_price_edit'),
					'show_discount' => Input::post('show_discount'),
					'allow_user_discount_edit' => Input::post('allow_user_discount_edit'),
					'show_shipping' => Input::post('show_shipping'),
					'require_shipping' => Input::post('require_shipping'),
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
					Session::set_flash('success', 'Added cashier profile #'.$cashier_profile->id.'.');
					Response::redirect('admin/settings/cashier/profile');
				}
				else
				{
					Session::set_flash('error', 'Could not save cashier profile.');
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
			Session::set_flash('error', 'Could not find cashier profile #'.$id);
			Response::redirect('admin/settings/cashier/profile');
		}

		$val = Model_Cashier_Profile::validate('edit');

		if ($val->run())
		{
			$cashier_profile->enabled = Input::post('enabled');
			$cashier_profile->document_type = Input::post('document_type');
			$cashier_profile->hide_credit_sale = Input::post('hide_credit_sale');
			// $cashier_profile->ignore_customer_credit_limit = Input::post('ignore_customer_credit_limit');
			// $cashier_profile->hide_sales_return = Input::post('hide_sales_return');
			$cashier_profile->require_sales_return_reason = Input::post('require_sales_return_reason');
			// $cashier_profile->hide_hold_sale = Input::post('hide_hold_sale');
			// $cashier_profile->require_approval_to_cancel_sale = Input::post('require_approval_to_cancel_sale');
			$cashier_profile->default_sale_type = Input::post('default_sale_type');
			$cashier_profile->customer_id = Input::post('customer_id');
			// $cashier_profile->restrict_sale_to_customer = Input::post('restrict_sale_to_customer');
			$cashier_profile->show_sales_person = Input::post('show_sales_person');
			$cashier_profile->require_sales_person = Input::post('require_sales_person');
			$cashier_profile->branch = Input::post('branch');
			$cashier_profile->location = Input::post('location');
			$cashier_profile->update_stock = Input::post('update_stock');
			$cashier_profile->allow_user_item_delete = Input::post('allow_user_item_delete');
			// $cashier_profile->require_item_delete_approval = Input::post('require_item_delete_approval');
			$cashier_profile->allow_user_price_edit = Input::post('allow_user_price_edit');
			$cashier_profile->show_discount = Input::post('show_discount');
			$cashier_profile->allow_user_discount_edit = Input::post('allow_user_discount_edit');
			$cashier_profile->show_shipping = Input::post('show_shipping');
			$cashier_profile->require_shipping = Input::post('require_shipping');
			$cashier_profile->show_qty_in_stock = Input::post('show_qty_in_stock');
			$cashier_profile->item_group = Input::post('item_group');
			$cashier_profile->customer_group = Input::post('customer_group');
			$cashier_profile->price_list = Input::post('price_list');
			$cashier_profile->currency = Input::post('currency');
			$cashier_profile->show_currency_symbol = Input::post('show_currency_symbol');
            $cashier_profile->fdesk_user = Input::post('fdesk_user');

			if ($cashier_profile->save())
			{
				Session::set_flash('success', 'Updated cashier profile #' . $id);

				Response::redirect('admin/settings/cashier/profile');
			}
			else
			{
				Session::set_flash('error', 'Could not update cashier profile #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$cashier_profile->enabled = $val->validated('enabled');
				$cashier_profile->document_type = $val->validated('document_type');
				$cashier_profile->hide_credit_sale = $val->validated('hide_credit_sale');
				// $cashier_profile->ignore_customer_credit_limit = $val->validated('ignore_customer_credit_limit');
				// $cashier_profile->hide_sales_return = $val->validated('hide_sales_return');
				$cashier_profile->require_sales_return_reason = $val->validated('require_sales_return_reason');
				// $cashier_profile->hide_hold_sale = $val->validated('hide_hold_sale');
				// $cashier_profile->require_approval_to_cancel_sale = $val->validated('require_approval_to_cancel_sale');
				$cashier_profile->default_sale_type = $val->validated('default_sale_type');
				$cashier_profile->customer = $val->validated('customer_id');
				// $cashier_profile->restrict_sale_to_customer = $val->validated('restrict_sale_to_customer');
				$cashier_profile->show_sales_person = $val->validated('show_sales_person');
				$cashier_profile->require_sales_person = $val->validated('require_sales_person');
				$cashier_profile->branch = $val->validated('branch');
				$cashier_profile->location = $val->validated('location');
				$cashier_profile->update_stock = $val->validated('update_stock');
				$cashier_profile->allow_user_item_delete = $val->validated('allow_user_item_delete');
				// $cashier_profile->require_item_delete_approval = $val->validated('require_item_delete_approval');
				$cashier_profile->allow_user_price_edit = $val->validated('allow_user_price_edit');
				$cashier_profile->show_discount = $val->validated('show_discount');
				$cashier_profile->allow_user_discount_edit = $val->validated('allow_user_discount_edit');
				$cashier_profile->show_shipping = $val->validated('show_shipping');
				$cashier_profile->require_shipping = $val->validated('require_shipping');
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
			Session::set_flash('success', 'Deleted cashier profile #'.$id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete cashier profile #'.$id);
		}

		Response::redirect('admin/settings/cashier/profile');
	}

}
