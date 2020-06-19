<?php

class Controller_Admin_Settings_Branch extends Controller_Authenticate
{
	public function action_index()
	{
		$data['branches'] = Model_Business::find('all');
		$this->template->title = "Branch";
		$this->template->content = View::forge('settings/branch/index', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Business::validate('create');

			if ($val->run())
			{                                    
				$branch = Model_Business::forge(array(
					'business_name' => Input::post('business_name'),
					'trading_name' => Input::post('trading_name'),
					'address' => Input::post('address'),
					'tax_identifier' => Input::post('tax_identifier'),
					'business_type' => Input::post('business_type'),
					'currency_symbol' => Input::post('currency_symbol'),
                    'email_address' => Input::post('email_address'),
                    'phone_number' => Input::post('phone_number'),
				));
                // upload and save the file
				$file = Filehelper::upload();

                if (!empty($file['saved_as']))
                    $branch->business_logo = 'uploads'.DS.$file['name'];

				if ($branch and $branch->save())
				{
					Session::set_flash('success', 'Saved branch information.');
					Response::redirect('admin/settings/branch');
				}
				else
				{
					Session::set_flash('error', 'Could not save branch information.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}
		
		$this->template->title = "Branch";
		$this->template->content = View::forge('settings/branch/create');
	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('admin/settings/branch');

		if ( ! $branch = Model_Business::find($id))
		{
			Session::set_flash('error', 'Could not find product group #'.$id);
			Response::redirect('admin/settings/branch');
		}

		$val = Model_Business::validate('edit');

		if ($val->run())
		{
			$branch->business_name = Input::post('business_name');
			$branch->trading_name = Input::post('trading_name');
			$branch->address = Input::post('address');
			$branch->tax_identifier = Input::post('tax_identifier');
			$branch->business_type = Input::post('business_type');
			$branch->currency_symbol = Input::post('currency_symbol');
			$branch->email_address = Input::post('email_address');
			$branch->phone_number = Input::post('phone_number');

			try {
				// upload and save the file
				$file = Filehelper::upload();

                if (!empty($file['saved_as']))
				    $branch->business_logo = 'uploads'.DS.$file['name'];

				if ($branch->save())
				{
					Session::set_flash('success', 'Updated branch information.');
					Response::redirect('admin/settings/branch/view');
				}
				else
				{
					Session::set_flash('error', 'Could not update branch information.');
				}
			}
	        catch (Fuel\Upload\NoFilesException $e) {
	            Session::set_flash('error', $e->getMessage());
	        }
			catch (DomainException $e) {
				Session::set_flash('error', $e->getMessage());
			}
			catch (Fuel\Core\PhpErrorException $e) {
				Session::set_flash('error', $e->getMessage());
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				// upload and save the file
				$file = Filehelper::upload();

                if (!empty($file['saved_as']))
				    $branch->business_logo = 'uploads'.DS.$file['name'];
                else 
                    $branch->business_logo = $val->validated('business_logo');

				$branch->business_name = $val->validated('business_name');
				$branch->trading_name = $val->validated('trading_name');
				$branch->address = $val->validated('address');
				$branch->tax_identifier = $val->validated('tax_identifier');
				$branch->business_type = $val->validated('business_type');
				$branch->currency_symbol = $val->validated('currency_symbol');
				$branch->email_address = $val->validated('email_address');
				$branch->phone_number = $val->validated('phone_number');

				Session::set_flash('error', $val->error());
			}
			$this->template->set_global('branch', $branch, false);
		}
		$this->template->title = "Branch";
		$this->template->content = View::forge('settings/branch/edit');
	}	
}
