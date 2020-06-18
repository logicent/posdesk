<?php

class Controller_Purchase_Order_Item extends Controller_Authenticate
{
	public function action_index()
	{
		$purchase_order_items = Model_Purchase_Order_Item::find('all');
		echo json_encode($purchase_order_items);

	}

	public function action_create()
    {
        if (Input::is_ajax())
        {
			$data['row_id'] = Input::post('next_row_id');

            return View::forge('purchase/order/item/_form', $data);
        }
	}
	
	public function action_read()
    {
		$item = '';
		
        if (Input::is_ajax())
        {
            $item = Model_Product_Item::query()
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
	// 		$val = Model_Purchase_Order_Item::validate('create');

	// 		if ($val->run())
	// 		{
	// 			$purchase_order_item = Model_Purchase_Order_Item::forge(array(
	// 				'item_id' => Input::post('item_id'),
	// 				'order_id' => Input::post('order_id'),
	// 				'gl_account_id' => Input::post('gl_account_id'),
	// 				'description' => Input::post('description'),
	// 				'qty' => Input::post('qty'),
	// 				'unit_price' => Input::post('unit_price'),
	// 				'discount_percent' => Input::post('discount_percent'),
	// 				'amount' => Input::post('amount'),
	// 			));

	// 			if ($purchase_order_item and $purchase_order_item->save())
	// 			{
	// 				Session::set_flash('success', 'Added purchase order item #'.$purchase_order_item->id.'.');

	// 				Response::redirect('purchase/order/item');
	// 			}

	// 			else
	// 			{
	// 				Session::set_flash('error', 'Could not save purchase order item.');
	// 			}
	// 		}
	// 		else
	// 		{
	// 			Session::set_flash('error', $val->error());
	// 		}
	// 	}

	// 	echo json_encode($purchase_order_item);

	// }

	// public function action_edit($id = null)
	// {
	// 	is_null($id) and Response::redirect('purchase/order/item');

	// 	if ( ! $purchase_order_item = Model_Purchase_Order_Item::find($id))
	// 	{
	// 		Session::set_flash('error', 'Could not find purchase order item #'.$id);
	// 		Response::redirect('purchase/order/item');
	// 	}

	// 	$val = Model_Purchase_Order_Item::validate('edit');

	// 	if ($val->run())
	// 	{
	// 		$purchase_order_item->item_id = Input::post('item_id');
	// 		$purchase_order_item->order_id = Input::post('order_id');
	// 		$purchase_order_item->gl_account_id = Input::post('gl_account_id');
	// 		$purchase_order_item->description = Input::post('description');
	// 		$purchase_order_item->qty = Input::post('qty');
	// 		$purchase_order_item->unit_price = Input::post('unit_price');
	// 		$purchase_order_item->discount_percent = Input::post('discount_percent');
	// 		$purchase_order_item->amount = Input::post('amount');

	// 		if ($purchase_order_item->save())
	// 		{
	// 			Session::set_flash('success', 'Updated purchase order item #' . $id);

	// 			Response::redirect('purchase/order/item');
	// 		}

	// 		else
	// 		{
	// 			Session::set_flash('error', 'Could not update purchase order item #' . $id);
	// 		}
	// 	}

	// 	else
	// 	{
	// 		if (Input::method() == 'POST')
	// 		{
	// 			$purchase_order_item->item_id = $val->validated('item_id');
	// 			$purchase_order_item->order_id = $val->validated('order_id');
	// 			$purchase_order_item->gl_account_id = $val->validated('gl_account_id');
	// 			$purchase_order_item->description = $val->validated('description');
	// 			$purchase_order_item->qty = $val->validated('qty');
	// 			$purchase_order_item->unit_price = $val->validated('unit_price');
	// 			$purchase_order_item->discount_percent = $val->validated('discount_percent');
	// 			$purchase_order_item->amount = $val->validated('amount');

	// 			Session::set_flash('error', $val->error());
	// 		}

	// 		$this->template->set_global('purchase_order_item', $purchase_order_item, false);
	// 	}

	// 	echo json_encode($purchase_order_item);

	// }

	public function action_delete()
	{
        if (Input::is_ajax())
        {
			$id = Input::post('id');

			if ($purchase_order_item = Model_Purchase_Order_Item::find($id)) 
			{
				try {
					$purchase_order_item->delete();
				}
				catch (Exception $e) {
					return $e->getMessage();
				}

				$msg = 'Deleted purchase order item #'.$id;
			}
			else
			{
				$msg = 'Could not delete purchase order item #'.$id;
			}
			
			return json_encode($msg);
		}
	}

}
