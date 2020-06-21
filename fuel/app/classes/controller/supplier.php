<?php
class Controller_Supplier extends Controller_Authenticate
{

	public function action_index()
	{
		$data['suppliers'] = Model_Supplier::find('all');
		$this->template->title = "Supplier";
		$this->template->content = View::forge('supplier/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('supplier');

		if ( ! $data['supplier'] = Model_Supplier::find($id))
		{
			Session::set_flash('error', 'Could not find supplier #'.$id);
			Response::redirect('supplier');
		}

		$this->template->title = "Supplier";
		$this->template->content = View::forge('supplier/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Supplier::validate('create');

			if ($val->run())
			{
				$supplier = Model_Supplier::forge(array(
					'supplier_name' => Input::post('supplier_name'),
                    'supplier_type' => Input::post('supplier_type'),
                    'supplier_group' => Input::post('supplier_group'),
                    'fdesk_user' => Input::post('fdesk_user'),
                    'inactive' => Input::post('inactive'),
                    'bank_account' => Input::post('bank_account'),
                    'billing_currency' => Input::post('billing_currency'),
                    'tax_ID' => Input::post('tax_ID'),
                    'email_address' => Input::post('email_address'),
                    'mobile_phone' => Input::post('mobile_phone'),
                    'sex' => Input::post('sex'),
                    'title_of_courtesy' => Input::post('title_of_courtesy'),
                    'first_billed' => Input::post('first_billed'),
                    'last_billed' => Input::post('last_billed'),
                    'credit_limit' => Input::post('credit_limit'),
                    'is_internal_supplier' => Input::post('is_internal_supplier'),
                    'on_hold' => Input::post('on_hold'),
                    'on_hold_from' => Input::post('on_hold_from'),
                    'on_hold_to' => Input::post('on_hold_to'),
                    'remarks' => Input::post('remarks'),
				));

				if ($supplier and $supplier->save())
				{
					Session::set_flash('success', 'Added supplier #'.$supplier->id.'.');

					Response::redirect('supplier');
				}

				else
				{
					Session::set_flash('error', 'Could not save supplier.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Supplier";
		$this->template->content = View::forge('supplier/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('supplier');

		if ( ! $supplier = Model_Supplier::find($id))
		{
			Session::set_flash('error', 'Could not find supplier #'.$id);
			Response::redirect('supplier');
		}

		$val = Model_Supplier::validate('edit');

		if ($val->run())
		{
            $supplier->supplier_name = Input::post('supplier_name');
            $supplier->supplier_type = Input::post('supplier_type');
            $supplier->supplier_group = Input::post('supplier_group');
            $supplier->fdesk_user = Input::post('fdesk_user');
            $supplier->inactive = Input::post('inactive');
            $supplier->account_manager = Input::post('account_manager');
            $supplier->bank_account = Input::post('bank_account');
            $supplier->billing_currency = Input::post('billing_currency');
            $supplier->tax_ID = Input::post('tax_ID');
            $supplier->email_address = Input::post('email_address');
            $supplier->mobile_phone = Input::post('mobile_phone');
            $supplier->sex = Input::post('sex');
            $supplier->title_of_courtesy = Input::post('title_of_courtesy');
            $supplier->first_billed = Input::post('first_billed');
            $supplier->last_billed = Input::post('last_billed');
            $supplier->credit_limit = Input::post('credit_limit');
            $supplier->is_internal_supplier = Input::post('is_internal_supplier');
            $supplier->on_hold = Input::post('on_hold');
            $supplier->on_hold_from = Input::post('on_hold_from');
            $supplier->on_hold_to = Input::post('on_hold_to');
            $supplier->remarks = Input::post('remarks');

			if ($supplier->save())
			{
				Session::set_flash('success', 'Updated supplier #' . $id);

				Response::redirect('supplier');
			}

			else
			{
				Session::set_flash('error', 'Could not update supplier #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
                $supplier->supplier_name = $val->validated('supplier_name');
                $supplier->supplier_type = $val->validated('supplier_type');
                $supplier->supplier_group = $val->validated('supplier_group');
                $supplier->fdesk_user = $val->validated('fdesk_user');
                $supplier->inactive = $val->validated('inactive');
                $supplier->account_manager = $val->validated('account_manager');
                $supplier->bank_account = $val->validated('bank_account');
                $supplier->billing_currency = $val->validated('billing_currency');
                $supplier->tax_ID = $val->validated('tax_ID');
                $supplier->email_address = $val->validated('email_address');
                $supplier->mobile_phone = $val->validated('mobile_phone');
                $supplier->sex = $val->validated('sex');
                $supplier->title_of_courtesy = $val->validated('title_of_courtesy');
                $supplier->first_billed = $val->validated('first_billed');
                $supplier->last_billed = $val->validated('last_billed');
                $supplier->credit_limit = $val->validated('credit_limit');
                $supplier->is_internal_supplier = $val->validated('is_internal_supplier');
                $supplier->on_hold = $val->validated('on_hold');
                $supplier->on_hold_from = $val->validated('on_hold_from');
                $supplier->on_hold_to = $val->validated('on_hold_to');
                $supplier->remarks = $val->validated('remarks');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('supplier', $supplier, false);
		}

		$this->template->title = "Supplier";
		$this->template->content = View::forge('supplier/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('supplier');

		if ($supplier = Model_Supplier::find($id))
		{
			$supplier->delete();

			Session::set_flash('success', 'Deleted supplier #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete supplier #'.$id);
		}

		Response::redirect('supplier');

	}

}
