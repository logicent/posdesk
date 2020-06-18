<?php

class Controller_Sales_Order_Item extends Controller_Authenticate
{
	public function action_index()
	{
		$sales_order_items = Model_Sales_Order_Item::find('all');
		echo json_encode($sales_order_items);

	}

	public function action_create()
    {
        if (Input::is_ajax())
        {
			$data['row_id'] = Input::post('next_row_id');

            return View::forge('sales/order/item/_form', $data);
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

	public function action_delete()
	{
        if (Input::is_ajax())
        {
			$id = Input::post('id');

			if ($sales_order_item = Model_Sales_Order_Item::find($id)) 
			{
				try {
					$sales_order_item->delete();
				}
				catch (Exception $e) {
					return $e->getMessage();
				}

				$msg = 'Deleted sales order item #'.$id;
			}
			else
			{
				$msg = 'Could not delete sales order item #'.$id;
			}
			
			return json_encode($msg);
		}
	}

}
