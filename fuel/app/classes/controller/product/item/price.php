<?php
class Controller_Product_Item_Price extends Controller_Authenticate
{

	public function action_index()
	{
		$data['item_prices'] = Model_Product_Item_Price::find('all');
		$this->template->title = "Item Prices";
		$this->template->content = View::forge('product/item/price/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('product/item/price');

		if ( ! $data['item_price'] = Model_Product_Item_Price::find($id))
		{
			Session::set_flash('error', 'Could not find item price #'.$id);
			Response::redirect('product/item/price');
		}

		$this->template->title = "Item Price";
		$this->template->content = View::forge('product/item/price/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Product_Item_Price::validate('create');

			if ($val->run())
			{
				$item_price = Model_Product_Item_Price::forge(array(
					'item_id' => Input::post('item_id'),
					'price_list_id' => Input::post('price_list_id'),
					'fdesk_user' => Input::post('fdesk_user'),
					'price_list_rate' => Input::post('price_list_rate'),
				));

				if ($item_price and $item_price->save())
				{
					Session::set_flash('success', 'Added item price #'.$item_price->id.'.');

					Response::redirect('product/item/price');
				}

				else
				{
					Session::set_flash('error', 'Could not save item price.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Item Prices";
		$this->template->content = View::forge('product/item/price/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('product/item/price');

		if ( ! $item_price = Model_Product_Item_Price::find($id))
		{
			Session::set_flash('error', 'Could not find item price #'.$id);
			Response::redirect('product/item/price');
		}

		$val = Model_Product_Item_Price::validate('edit');

		if ($val->run())
		{
			$item_price->item_id = Input::post('item_id');
			$item_price->price_list_id = Input::post('price_list_id');
			$item_price->fdesk_user = Input::post('fdesk_user');
			$item_price->price_list_rate = Input::post('price_list_rate');

			if ($item_price->save())
			{
				Session::set_flash('success', 'Updated item price #' . $id);

				Response::redirect('product/item/price');
			}

			else
			{
				Session::set_flash('error', 'Could not update item price #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$item_price->item_id = $val->validated('item_id');
				$item_price->price_list_id = $val->validated('price_list_id');
				$item_price->fdesk_user = $val->validated('fdesk_user');
				$item_price->price_list_rate = $val->validated('price_list_rate');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('item_price', $item_price, false);
		}

		$this->template->title = "Item Prices";
		$this->template->content = View::forge('product/item/price/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('product/item/price');

		if ($item_price = Model_Product_Item_Price::find($id))
		{
			$item_price->delete();

			Session::set_flash('success', 'Deleted item price #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete item price #'.$id);
		}

		Response::redirect('product/item/price');

	}

}
