<?php
class Controller_Product_Location extends Controller_Authenticate
{

	public function action_index()
	{
		$data['locations'] = Model_Product_Location::find('all');
		$this->template->title = "Locations";
		$this->template->content = View::forge('product/location/index', $data);
	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('product/location');

		if ( ! $data['location'] = Model_Product_Location::find($id))
		{
			Session::set_flash('error', 'Could not find product location #'.$id);
			Response::redirect('product/location');
		}

		$this->template->title = "Location";
		$this->template->content = View::forge('product/location/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Product_Location::validate('create');

			if ($val->run())
			{
				$product_location = Model_Product_Location::forge(array(
					'name' => Input::post('name'),
					'description' => Input::post('description'),
					'enabled' => Input::post('enabled'),
					'branch_id' => Input::post('branch_id'),
					'fdesk_user' => Input::post('fdesk_user'),
				));

				if ($product_location and $product_location->save())
				{
					Session::set_flash('success', 'Added product location #'.$product_location->id.'.');

					Response::redirect('product/location');
				}

				else
				{
					Session::set_flash('error', 'Could not save product_location.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Product_Locations";
		$this->template->content = View::forge('product/location/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('product/location');

		if ( ! $product_location = Model_Product_Location::find($id))
		{
			Session::set_flash('error', 'Could not find product location #'.$id);
			Response::redirect('product/location');
		}

		$val = Model_Product_Location::validate('edit');

		if ($val->run())
		{
			$product_location->name = Input::post('name');
			$product_location->description = Input::post('description');
			$product_location->enabled = Input::post('enabled');
			$product_location->branch_id = Input::post('branch_id');
			$product_location->fdesk_user = Input::post('fdesk_user');

			if ($product_location->save())
			{
				Session::set_flash('success', 'Updated product location #' . $id);

				Response::redirect('product/location');
			}

			else
			{
				Session::set_flash('error', 'Could not update product location #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$product_location->name = $val->validated('name');
				$product_location->description = $val->validated('description');
				$product_location->enabled = $val->validated('enabled');
				$product_location->branch_id = $val->validated('branch_id');
				$product_location->fdesk_user = $val->validated('fdesk_user');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('location', $product_location, false);
		}

		$this->template->title = "Locations";
		$this->template->content = View::forge('product/location/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('product/location');

		if ($product_location = Model_Product_Location::find($id))
		{
			$product_location->delete();

			Session::set_flash('success', 'Deleted product location #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete product location #'.$id);
		}

		Response::redirect('product/location');

	}

}
