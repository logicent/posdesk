<?php
class Controller_Product_Brand extends Controller_Authenticate
{

	public function action_index()
	{
		$data['product_brands'] = Model_Product_Brand::find('all');
		$this->template->title = "Brands";
		$this->template->content = View::forge('product/brand/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('product/brand');

		if ( ! $data['product_brand'] = Model_Product_Brand::find($id))
		{
			Session::set_flash('error', 'Could not find brand #'.$id);
			Response::redirect('product/brand');
		}

		$this->template->title = "Brand";
		$this->template->content = View::forge('product/brand/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Product_Brand::validate('create');

			if ($val->run())
			{
				$product_brand = Model_Product_Brand::forge(array(
					'name' => Input::post('name'),
					'enabled' => Input::post('enabled'),
					'fdesk_user' => Input::post('fdesk_user'),
				));

				if ($product_brand and $product_brand->save())
				{
					Session::set_flash('success', 'Added brand #'.$product_brand->name.'.');
					Response::redirect('product/brand');
				}
				else
				{
					Session::set_flash('error', 'Could not save brand.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Brands";
		$this->template->content = View::forge('product/brand/create');
	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('product/brand');

		if ( ! $product_brand = Model_Product_Brand::find($id))
		{
			Session::set_flash('error', 'Could not find brand #'.$id);
			Response::redirect('product/brand');
		}

		$val = Model_Product_Brand::validate('edit');

		if ($val->run())
		{
			$product_brand->name = Input::post('name');
			$product_brand->enabled = Input::post('enabled');
			$product_brand->fdesk_user = Input::post('fdesk_user');

			if ($product_brand->save())
			{
				Session::set_flash('success', 'Updated brand #' . $product_brand->name);
				Response::redirect('product/brand');
			}
			else
			{
				Session::set_flash('error', 'Could not update brand #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$product_brand->name = $val->validated('name');
				$product_brand->enabled = $val->validated('enabled');
				$product_brand->fdesk_user = $val->validated('fdesk_user');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('product_brand', $product_brand, false);
		}

		$this->template->title = "Brands";
		$this->template->content = View::forge('product/brand/edit');
	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('product/brand');

		if ($product_brand = Model_Product_Brand::find($id))
		{
			$product_brand->delete();
			Session::set_flash('success', 'Deleted brand #'.$id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete brand #'.$id);
		}

		Response::redirect('product/brand');
	}

}
