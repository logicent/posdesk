<?php

class Controller_Product_Item extends Controller_Authenticate
{
	public function action_index()
	{
		$data['product_items'] = Model_Product_Item::find('all');
		$this->template->title = "Products";
		$this->template->content = View::forge('product/item/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('products');

		if ( ! $data['product_item'] = Model_Product_Item::find($id))
		{
			Session::set_flash('error', 'Could not find product item #'.$id);
			Response::redirect('products');
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
					'code' => Input::post('code'),
					'gl_account_id' => Input::post('gl_account_id'),
					'description' => Input::post('description'),
					'qty' => Input::post('qty'),
					'unit_price' => Input::post('unit_price'),
                    'discount_percent' => Input::post('discount_percent'),
                    'fdesk_user' => Input::post('fdesk_user'),
                    'product_type' => Input::post('product_type'),
                    'billable' => Input::post('billable'),
                    'enabled' => Input::post('enabled'),
				));

				try {
					if ($product_item and $product_item->save())
					{
						Session::set_flash('success', 'Added product item #'.$product_item->code.'.');

						Response::redirect('products');
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
                'code' => $copy_item->code,
                'gl_account_id' => $copy_item->gl_account_id,
                'description' => $copy_item->description,
                'qty' => $copy_item->qty,
                'unit_price' => $copy_item->unit_price,
                'discount_percent' => $copy_item->discount_percent,
                'fdesk_user' => $copy_item->fdesk_user,
                'product_type' => $copy_item->product_type,
                'billable' => $copy_item->billable,
                'enabled' => $copy_item->enabled,
            ));

            Session::set_flash('info', 'Duplicate product item #' . $product_item->code);

			$this->template->set_global('product_item', $product_item, false);
        }

		$this->template->title = "Product Item";
		$this->template->content = View::forge('product/item/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('products');

		if ( ! $product_item = Model_Product_Item::find($id))
		{
			Session::set_flash('error', 'Could not find product item #'.$id);
			Response::redirect('products');
		}

		$val = Model_Product_Item::validate('edit');

		if ($val->run())
		{
			$product_item->code = Input::post('code');
			$product_item->gl_account_id = Input::post('gl_account_id');
			$product_item->description = Input::post('description');
			$product_item->qty = Input::post('qty');
			$product_item->unit_price = Input::post('unit_price');
			$product_item->discount_percent = Input::post('discount_percent');
            $product_item->fdesk_user = Input::post('fdesk_user');
            $product_item->product_type = Input::post('product_type');
            $product_item->billable = Input::post('billable');
            $product_item->enabled = Input::post('enabled');

			try {
				if ($product_item->save())
				{
					Session::set_flash('success', 'Updated product item #' . $product_item->code);

					Response::redirect('products');
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
				$product_item->code = $val->validated('code');
				$product_item->gl_account_id = $val->validated('gl_account_id');
				$product_item->description = $val->validated('description');
				$product_item->qty = $val->validated('qty');
				$product_item->unit_price = $val->validated('unit_price');
				$product_item->discount_percent = $val->validated('discount_percent');
                $product_item->fdesk_user = $val->validated('fdesk_user');
                $product_item->product_type = $val->validated('product_type');
                $product_item->billable = $val->validated('billable');
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
		is_null($id) and Response::redirect('products');

        if (Input::method() == 'POST')
		{		
			if ($product_item = Model_Product_Item::find($id))
			{
				$sales_invoice_item = Model_Sales_Invoice_Item::find('first', array('where' => array('item_id' => $id)));
				if ($sales_invoice_item)
					Session::set_flash('error', 'Product item already in use by Invoice(s).');
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
		
		Response::redirect('products');

	}


}
