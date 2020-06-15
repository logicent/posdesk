<?php

class Controller_Purchases_Order_Item extends Controller_Authenticate
{
	public function action_index()
	{
		$purchases_order_items = Model_Purchases_Order_Item::find('all');
		echo json_encode($purchases_order_items);

	}

	public function action_create()
    {
        if (Input::is_ajax())
        {
			$data['row_id'] = Input::post('next_row_id');

            return View::forge('purchases/order/item/_form', $data);
        }
	}
	
	public function action_read()
    {
		$item = '';
		
        if (Input::is_ajax())
        {
            $item = Model_Service_Item::query()
										->where(
											array('id' => Input::post('item_id'))
										)
										->get_one()
										->to_array();
		}
		
		return json_encode($item);
	}

	// public function action_create()
	// {
	// 	if (Input::method() == 'POST')
	// 	{
	// 		$val = Model_Purchases_Order_Item::validate('create');

	// 		if ($val->run())
	// 		{
	// 			$purchases_order_item = Model_Purchases_Order_Item::forge(array(
	// 				'item_id' => Input::post('item_id'),
	// 				'order_id' => Input::post('order_id'),
	// 				'gl_account_id' => Input::post('gl_account_id'),
	// 				'description' => Input::post('description'),
	// 				'qty' => Input::post('qty'),
	// 				'unit_price' => Input::post('unit_price'),
	// 				'discount_percent' => Input::post('discount_percent'),
	// 				'amount' => Input::post('amount'),
	// 			));

	// 			if ($purchases_order_item and $purchases_order_item->save())
	// 			{
	// 				Session::set_flash('success', 'Added purchases order item #'.$purchases_order_item->id.'.');

	// 				Response::redirect('purchases/order/item');
	// 			}

	// 			else
	// 			{
	// 				Session::set_flash('error', 'Could not save purchases order item.');
	// 			}
	// 		}
	// 		else
	// 		{
	// 			Session::set_flash('error', $val->error());
	// 		}
	// 	}

	// 	echo json_encode($purchases_order_item);

	// }

	// public function action_edit($id = null)
	// {
	// 	is_null($id) and Response::redirect('purchases/order/item');

	// 	if ( ! $purchases_order_item = Model_Purchases_Order_Item::find($id))
	// 	{
	// 		Session::set_flash('error', 'Could not find purchases order item #'.$id);
	// 		Response::redirect('purchases/order/item');
	// 	}

	// 	$val = Model_Purchases_Order_Item::validate('edit');

	// 	if ($val->run())
	// 	{
	// 		$purchases_order_item->item_id = Input::post('item_id');
	// 		$purchases_order_item->order_id = Input::post('order_id');
	// 		$purchases_order_item->gl_account_id = Input::post('gl_account_id');
	// 		$purchases_order_item->description = Input::post('description');
	// 		$purchases_order_item->qty = Input::post('qty');
	// 		$purchases_order_item->unit_price = Input::post('unit_price');
	// 		$purchases_order_item->discount_percent = Input::post('discount_percent');
	// 		$purchases_order_item->amount = Input::post('amount');

	// 		if ($purchases_order_item->save())
	// 		{
	// 			Session::set_flash('success', 'Updated purchases order item #' . $id);

	// 			Response::redirect('purchases/order/item');
	// 		}

	// 		else
	// 		{
	// 			Session::set_flash('error', 'Could not update purchases order item #' . $id);
	// 		}
	// 	}

	// 	else
	// 	{
	// 		if (Input::method() == 'POST')
	// 		{
	// 			$purchases_order_item->item_id = $val->validated('item_id');
	// 			$purchases_order_item->order_id = $val->validated('order_id');
	// 			$purchases_order_item->gl_account_id = $val->validated('gl_account_id');
	// 			$purchases_order_item->description = $val->validated('description');
	// 			$purchases_order_item->qty = $val->validated('qty');
	// 			$purchases_order_item->unit_price = $val->validated('unit_price');
	// 			$purchases_order_item->discount_percent = $val->validated('discount_percent');
	// 			$purchases_order_item->amount = $val->validated('amount');

	// 			Session::set_flash('error', $val->error());
	// 		}

	// 		$this->template->set_global('purchases_order_item', $purchases_order_item, false);
	// 	}

	// 	echo json_encode($purchases_order_item);

	// }

	public function action_delete()
	{
        if (Input::is_ajax())
        {
			$id = Input::post('id');

			if ($purchases_order_item = Model_Purchases_Order_Item::find($id)) 
			{
				try {
					$purchases_order_item->delete();
				}
				catch (Exception $e) {
					return $e->getMessage();
				}

				$msg = 'Deleted purchases order item #'.$id;
			}
			else
			{
				$msg = 'Could not delete purchases order item #'.$id;
			}
			
			return json_encode($msg);
		}
	}

}
