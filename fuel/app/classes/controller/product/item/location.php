<?php
class Controller_Product_Item_Location extends Controller_Authenticate
{

	public function action_index()
	{
		$data['item_locations'] = Model_Product_Item_Location::find('all');
		$this->template->title = "Item Locations";
		$this->template->content = View::forge('product/item/location/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('product/item/location');

		if ( ! $data['item_location'] = Model_Product_Item_Location::find($id))
		{
			Session::set_flash('error', 'Could not find Item Location #'.$id);
			Response::redirect('product/item/location');
		}

		$this->template->title = "Item Location";
		$this->template->content = View::forge('product/item/location/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Product_Item_Location::validate('create');

			if ($val->run())
			{
				$item_location = Model_Product_Item_Location::forge(array(
					'item_id' => Input::post('item_id'),
					'location_id' => Input::post('location_id'),
					'quantity' => Input::post('quantity'),
				));

				if ($item_location and $item_location->save())
				{
					Session::set_flash('success', 'Added Item Location #'.$item_location->id.'.');

					Response::redirect('product/item/location');
				}

				else
				{
					Session::set_flash('error', 'Could not save Item Location.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Item Locations";
		$this->template->content = View::forge('product/item/location/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('product/item/location');

		if ( ! $item_location = Model_Product_Item_Location::find($id))
		{
			Session::set_flash('error', 'Could not find Item Location #'.$id);
			Response::redirect('product/item/location');
		}

		$val = Model_Product_Item_Location::validate('edit');

		if ($val->run())
		{
			$item_location->item_id = Input::post('item_id');
			$item_location->location_id = Input::post('location_id');
			$item_location->quantity = Input::post('quantity');

			if ($item_location->save())
			{
				Session::set_flash('success', 'Updated Item Location #' . $id);

				Response::redirect('product/item/location');
			}

			else
			{
				Session::set_flash('error', 'Could not update Item Location #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$item_location->item_id = $val->validated('item_id');
				$item_location->location_id = $val->validated('location_id');
				$item_location->quantity = $val->validated('quantity');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('item_location', $item_location, false);
		}

		$this->template->title = "Item Locations";
		$this->template->content = View::forge('product/item/location/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('product/item/location');

		if ($item_location = Model_Product_Item_Location::find($id))
		{
			$item_location->delete();

			Session::set_flash('success', 'Deleted Item Location #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete Item Location #'.$id);
		}

		Response::redirect('product/item/location');

	}

}
