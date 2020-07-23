<?php
class Controller_Product_Price_List extends Controller_Authenticate
{

	public function action_index()
	{
		$data['price_lists'] = Model_Product_Price_List::find('all');
		$this->template->title = "Price Lists";
		$this->template->content = View::forge('product/pricelist/index', $data);
	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('product/price/list');

		if ( ! $data['price_list'] = Model_Product_Price_List::find($id))
		{
			Session::set_flash('error', 'Could not find price list #'.$id);
			Response::redirect('product/price/list');
		}

		$this->template->title = "Price List";
		$this->template->content = View::forge('product/pricelist/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Product_Price_List::validate('create');

			if ($val->run())
			{
				$price_list = Model_Product_Price_List::forge(array(
					'name' => Input::post('name'),
					'description' => Input::post('description'),
					'enabled' => Input::post('enabled'),
					'module' => Input::post('module'),
					'currency' => Input::post('currency'),
					'fdesk_user' => Input::post('fdesk_user'),
				));

				if ($price_list and $price_list->save())
				{
					Session::set_flash('success', 'Added price list #'.$price_list->id.'.');

					Response::redirect('product/price/list');
				}
				else
				{
					Session::set_flash('error', 'Could not save price list.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Price Lists";
		$this->template->content = View::forge('product/pricelist/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('product/price/list');

		if ( ! $price_list = Model_Product_Price_List::find($id))
		{
			Session::set_flash('error', 'Could not find price list #'.$id);
			Response::redirect('product/price/list');
		}

		$val = Model_Product_Price_List::validate('edit');

		if ($val->run())
		{
			$price_list->name = Input::post('name');
			$price_list->description = Input::post('description');
			$price_list->enabled = Input::post('enabled');
			$price_list->module = Input::post('module');
			$price_list->currency = Input::post('currency');
			$price_list->fdesk_user = Input::post('fdesk_user');

			if ($price_list->save())
			{
				Session::set_flash('success', 'Updated price list #' . $id);

				Response::redirect('product/price/list');
			}
			else
			{
				Session::set_flash('error', 'Could not update price list #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$price_list->name = $val->validated('name');
				$price_list->description = $val->validated('description');
				$price_list->enabled = $val->validated('enabled');
				$price_list->module = $val->validated('module');
				$price_list->currency = $val->validated('currency');
				$price_list->fdesk_user = $val->validated('fdesk_user');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('price_list', $price_list, false);
		}
		$this->template->title = "Price Lists";
		$this->template->content = View::forge('product/pricelist/edit');
	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('product/price/list');

		if ($price_list = Model_Product_Price_List::find($id))
		{
			$price_list->delete();
			Session::set_flash('success', 'Deleted price list #'.$id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete price list #'.$id);
		}

		Response::redirect('product/price/list');
	}
}
