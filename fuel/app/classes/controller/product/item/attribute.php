<?php
class Controller_Product_Item_Attribute extends Controller_Authenticate
{

	public function action_index()
	{
		$data['product_item_attributes'] = Model_Product_Item_Attribute::find('all');
		$this->template->title = "Item Attributes";
		$this->template->content = View::forge('product/item/attribute/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('product/item/attribute');

		if ( ! $data['product_item_attribute'] = Model_Product_Item_Attribute::find($id))
		{
			Session::set_flash('error', 'Could not find Item Attribute #'.$id);
			Response::redirect('product/item/attribute');
		}

		$this->template->title = "Item Attribute";
		$this->template->content = View::forge('product/item/attribute/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Product_Item_Attribute::validate('create');

			if ($val->run())
			{
				$item_attribute = Model_Product_Item_Attribute::forge(array(
					'name' => Input::post('name'),
					'description' => Input::post('description'),
					'item_id' => Input::post('item_id'),
				));

				if ($item_attribute and $item_attribute->save())
				{
					Session::set_flash('success', 'Added Item Attribute #'.$item_attribute->id.'.');

					Response::redirect('product/item/attribute');
				}

				else
				{
					Session::set_flash('error', 'Could not save Item Attribute.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Item Attributes";
		$this->template->content = View::forge('product/item/attribute/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('product/item/attribute');

		if ( ! $item_attribute = Model_Product_Item_Attribute::find($id))
		{
			Session::set_flash('error', 'Could not find Item Attribute #'.$id);
			Response::redirect('product/item/attribute');
		}

		$val = Model_Product_Item_Attribute::validate('edit');

		if ($val->run())
		{
			$item_attribute->name = Input::post('name');
			$item_attribute->description = Input::post('description');
			$item_attribute->item_id = Input::post('item_id');

			if ($item_attribute->save())
			{
				Session::set_flash('success', 'Updated Item Attribute #' . $id);

				Response::redirect('product/item/attribute');
			}

			else
			{
				Session::set_flash('error', 'Could not update Item Attribute #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$item_attribute->name = $val->validated('name');
				$item_attribute->description = $val->validated('description');
				$item_attribute->item_id = $val->validated('item_id');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('product_item_attribute', $item_attribute, false);
		}

		$this->template->title = "Item Attributes";
		$this->template->content = View::forge('product/item/attribute/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('product/item/attribute');

		if ($item_attribute = Model_Product_Item_Attribute::find($id))
		{
			$item_attribute->delete();

			Session::set_flash('success', 'Deleted Item Attribute #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete Item Attribute #'.$id);
		}

		Response::redirect('product/item/attribute');

	}

}
