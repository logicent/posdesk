<?php

class Controller_Product_Item extends Controller_Authenticate
{
	public function action_index()
	{
		$data['product_items'] = Model_Product_Item::find('all');
		$this->template->title = "Product";
		$this->template->content = View::forge('product/item/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('product');

		if ( ! $data['product_item'] = Model_Product_Item::find($id))
		{
			Session::set_flash('error', 'Could not find product item #'.$id);
			Response::redirect('product');
		}

		$this->template->title = "Product";
		$this->template->content = View::forge('product/item/view', $data);
	}

	public function action_create($id = null)
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Product_Item::validate('create');

			if ($val->run())
			{
				$product_item = Model_Product_Item::forge(array(
					'item_code' => Input::post('item_code'),
					'item_name' => Input::post('item_name'),
                    'tax_rate' => Input::post('tax_rate'),
                    'group_id' =>  empty(Input::post('group_id')) ? Model_Product_Item::getColumnDefault('group_id') : Input::post('group_id'),
					'description' => Input::post('description'),
					'quantity' => Input::post('quantity'),
					'min_order_qty' => Input::post('min_order_qty'),
					'reorder_level' => Input::post('reorder_level'),
					'cost_price' => Input::post('cost_price'),
					'unit_price' => Input::post('unit_price'),
                    'discount_percent' => Input::post('discount_percent'),
                    'fdesk_user' => Input::post('fdesk_user'),
                    'is_sales_item' => Input::post('is_sales_item'),
                    'enabled' => Input::post('enabled'),
				));

				// upload and save the file
				$file = Filehelper::upload();

				try {
					if (!empty($file['saved_as']))
						$product_item->image_path = 'uploads'.DS.$file['name'];
					
					if ($product_item and $product_item->save())
					{
						Session::set_flash('success', 'Added product item #'.$product_item->item_code.'.');
						Response::redirect('product');
					}
					else
					{
						Session::set_flash('error', 'Could not save product item.');
					}
				}
				catch (Fuel\Core\Database_Exception $e)
				{
					Session::set_flash('error', $e->getMessage());
					// throw $e;
				}				
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

        if ($id)
        {
            $copy_item = Model_Product_Item::find($id);

            $product_item = Model_Product_Item::forge(array(
                'item_code' => $copy_item->item_code,
                'item_name' => $copy_item->item_name,
                'group_id' => $copy_item->group_id,
                'tax_rate' => $copy_item->tax_rate,
                'description' => $copy_item->description,
                'quantity' => $copy_item->quantity,
                'min_order_qty' => $copy_item->min_order_qty,
                'reorder_level' => $copy_item->reorder_level,
                'cost_price' => $copy_item->cost_price,
                'unit_price' => $copy_item->unit_price,
                'discount_percent' => $copy_item->discount_percent,
                'fdesk_user' => $copy_item->fdesk_user,
                'is_sales_item' => $copy_item->is_sales_item,
                'enabled' => $copy_item->enabled,
            ));

            Session::set_flash('info', 'Duplicate product item #' . $product_item->item_code);

			$this->template->set_global('product_item', $product_item, false);
        }

		$this->template->title = "Product Item";
		$this->template->content = View::forge('product/item/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('product');

		if ( ! $product_item = Model_Product_Item::find($id))
		{
			Session::set_flash('error', 'Could not find product item #'.$id);
			Response::redirect('product');
		}

		$val = Model_Product_Item::validate('edit');

		if ($val->run())
		{
			$product_item->item_code = Input::post('item_code');
			$product_item->item_name = Input::post('item_name');
            $product_item->group_id = empty(Input::post('group_id')) ? null : Input::post('group_id');
            $product_item->tax_rate = Input::post('tax_rate');
			$product_item->description = Input::post('description');
			$product_item->quantity = Input::post('quantity');
			$product_item->min_order_qty = empty(Input::post('min_order_qty')) ? Model_Product_Item::getColumnDefault('min_order_qty') : Input::post('min_order_qty');
			$product_item->reorder_level = Input::post('reorder_level');
			$product_item->cost_price = Input::post('cost_price');
			$product_item->unit_price = Input::post('unit_price');
			$product_item->discount_percent = Input::post('discount_percent');
            $product_item->fdesk_user = Input::post('fdesk_user');
            $product_item->is_sales_item = Input::post('is_sales_item');
            $product_item->enabled = Input::post('enabled');

			// upload and save the file
			$file = Filehelper::upload();
			if (!empty($file['saved_as']))
				$product_item->image_path = 'uploads'.DS.$file['name'];

			try {
				if ($product_item->save())
				{
					Session::set_flash('success', 'Updated product item #' . $product_item->item_code);
					Response::redirect('product');
				}
				else
				{
					Session::set_flash('error', 'Could not update product item #' . $id);
				}
            }
            catch (Fuel\Core\Database_Exception $e)
            {
                Session::set_flash('error', $e->getMessage());
                // throw $e;
            }				
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$product_item->item_code = $val->validated('item_code');
				$product_item->item_name = $val->validated('item_name');
                $product_item->group_id = $val->validated('group_id');
                $product_item->tax_rate = $val->validated('tax_rate');
				$product_item->description = $val->validated('description');
				$product_item->quantity = $val->validated('quantity');
				$product_item->min_order_qty = $val->validated('min_order_qty');
				$product_item->reorder_level = $val->validated('reorder_level');
				$product_item->cost_price = $val->validated('cost_price');
				$product_item->unit_price = $val->validated('unit_price');
				$product_item->discount_percent = $val->validated('discount_percent');
                $product_item->fdesk_user = $val->validated('fdesk_user');
                $product_item->product_type = $val->validated('product_type');
                $product_item->is_sales_item = $val->validated('is_sales_item');
                $product_item->enabled = $val->validated('enabled');
                
				Session::set_flash('error', $val->error());
			}
			$this->template->set_global('product_item', $product_item, false);
		}

		$this->template->title = "Product Item";
		$this->template->content = View::forge('product/item/edit');
	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('product');

        if (Input::method() == 'POST')
		{		
			if ($product_item = Model_Product_Item::find($id))
			{
				$product_item = Model_Product_Item::find('first', array('where' => array('item_id' => $id)));
				if ($product_item)
					Session::set_flash('error', 'Product item already linked to transactions');
				else
				{
					$product_item->delete();
					Session::set_flash('success', 'Deleted product item #'.$id);
				}
			}
			else
			{
				Session::set_flash('error', 'Could not delete product item #'.$id);
			}
		}
		else
		{
			Session::set_flash('error', 'Delete is not allowed');
		}	
		Response::redirect('product');

	}
}
