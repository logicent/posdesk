<?php

class Controller_Admin_Settings_Product_Group extends Controller_Authenticate
{
	public function action_index()
	{
		$data['product_groups'] = Model_Product_Group::find('all');
		$this->template->title = "Product Group";
		$this->template->content = View::forge('product/group/index', $data);
	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('admin/settings/product/group');

		if ( ! $data['product_group'] = Model_Product_Group::find($id))
		{
			Session::set_flash('error', 'Could not find product group #'.$id);
			Response::redirect('admin/settings/product/group');
		}
		$this->template->title = "Product Group";
		$this->template->content = View::forge('product/group/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Product_Group::validate('create');

			if ($val->run())
			{
				$product_group = Model_Product_Group::forge(array(
					'name' => Input::post('name'),
					'code' => Input::post('code'),
					'enabled' => Input::post('enabled'),
					'is_default' => Input::post('is_default'),
					'parent_id' => Input::post('parent_id'),
                    'default_supplier' => Input::post('default_supplier'),
                    'fdesk_user' => Input::post('fdesk_user'),
				));

				if ($product_group and $product_group->save())
				{
					Session::set_flash('success', 'Added product group #'.$product_group->code.'.');
					Response::redirect('admin/settings/product/group');
				}
				else
				{
					Session::set_flash('error', 'Could not save product group.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}
		$this->template->title = "Product Group";
		$this->template->content = View::forge('product/group/create');
	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('admin/settings/product/group');

		if ( ! $product_group = Model_Product_Group::find($id))
		{
			Session::set_flash('error', 'Could not find product group #'.$id);
			Response::redirect('admin/settings/product/group');
		}

		$val = Model_Product_Group::validate('edit');
		if ($val->run())
		{
			$product_group->name = Input::post('name');
			$product_group->code = Input::post('code');
			$product_group->enabled = Input::post('enabled');
			$product_group->is_default = Input::post('is_default');
            $product_group->parent_id = Input::post('parent_id');
			$product_group->default_supplier = Input::post('default_supplier');
            $product_group->fdesk_user = Input::post('fdesk_user');

			if ($product_group->save())
			{
				Session::set_flash('success', 'Updated product group #' . $product_group->code);
				Response::redirect('admin/settings/product/group');
			}
			else
			{
				Session::set_flash('error', 'Could not update product group #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$product_group->name = $val->validated('name');
				$product_group->code = $val->validated('code');
				$product_group->enabled = $val->validated('enabled');
				$product_group->is_default = $val->validated('is_default');
				$product_group->parent_id = $val->validated('parent_id');
				$product_group->default_supplier = $val->validated('default_supplier');
                $product_group->fdesk_user = $val->validated('fdesk_user');

				Session::set_flash('error', $val->error());
			}
			$this->template->set_global('product_group', $product_group, false);
		}
		$this->template->title = "Product Group";
		$this->template->content = View::forge('product/group/edit');
	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('admin/settings/product/group');

        if (Input::method() == 'POST')
		{		
			if ($product_group = Model_Product_Group::find($id))
			{
				$product_group->delete();
				Session::set_flash('success', 'Deleted product group #'.$id);
			}
			else
			{
				Session::set_flash('error', 'Could not delete product group #'.$id);
			}
		}
		else
		{
			Session::set_flash('error', 'Delete is not allowed');
		}
		Response::redirect('admin/settings/product/group');
	}
}
