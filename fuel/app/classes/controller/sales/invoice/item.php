<?php

class Controller_Sales_Invoice_Item extends Controller_Authenticate
{
	public function action_index()
	{
		$pos_invoice_items = Model_Cashier_Invoice_Item::find('all');
		echo json_encode($pos_invoice_items);
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
