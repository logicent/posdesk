<?php

class Controller_Sales_Invoice_Item extends Controller_Authenticate
{
	public function action_index()
	{
		$pos_invoice_items = Model_Cashier_Invoice_Item::find('all');
		echo json_encode($pos_invoice_items);
	}

	public function action_search()
    {
		$data = [];

        if (Input::is_ajax())
        {
            $item = Model_Product_Item::query()
										->where(array('id' => Input::post('item_id')))
										->get_one();
			$data['invoice_item'] = Model_Sales_Invoice_Item::forge(
				array(
					'item_id' => $item->id,
					'quantity' => 1, // default is 1
					'unit_price' => $item->unit_price,
					'amount' => $item->unit_price, // initial total is equal to unit_price
					'invoice_id' => null,
					'tax_rate' => $item->tax_rate,
					'discount_percent' => $item->discount_percent,
					'description' => $item->item_name,
				));
			
			$data['item'] = $item;
			$data['row_id'] = Input::post('next_row_id');
			// TODO: Model_Cashier_Profile::get_current_user()
			$data['pos_profile'] = Model_Cashier_Profile::find('first');
            return View::forge('cashier/invoice/item/_form', $data);
        }
	}

	public function action_create()
    {
        if (Input::is_ajax())
        {
			$data['row_id'] = Input::post('next_row_id');
            return View::forge('cashier/invoice/item/_form', $data);
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

	public function action_list_options()
    {
		$item = '';
		$list_options = '';

        if (Input::is_ajax())
			$item = Model_Product_Item::listSaleItems(Input::post('group_id'));
		
		if (!empty($item))
			foreach ($item as $id => $list_item)
				$list_options .= "<option value='{$id}'>{$list_item}</option>";
		
		return $list_options;
	}

	public function action_get_images()
    {
		$data = $items = [];
        if (Input::is_ajax())
			$items = Model_Product_Item::find('all', array(
				'where' => array(
					array('id', 'in', explode(',', (Input::post('item_ids'))))
				)));
		
		$data['items'] = $items;
		return View::forge('cashier/invoice/item/_thumb', $data);
	}

	public function action_no_item()
	{
        if (Input::is_ajax())
        {
			$data['pos_profile'] = Model_Cashier_Profile::find('first');
            return View::forge('cashier/invoice/item/_no_item', $data);
		}
	}

	public function action_delete()
	{
        if (Input::is_ajax())
        {
			$id = Input::post('id');

			if ($pos_invoice_item = Model_Cashier_Invoice_Item::find($id)) 
			{
				try {
					$pos_invoice_item->delete();
				}
				catch (Exception $e) {
					return $e->getMessage();
				}

				$msg = 'Deleted sales item #'.$id;
			}
			else
			{
				$msg = 'Could not delete sales item #'.$id;
			}
			
			return json_encode($msg);
		}
	}

}
