<?php

class Controller_Pos_Invoice extends Controller_Authenticate
{
	public function action_index()
	{
		$status = Input::get('status');
		if (!$status)
			$status = Model_Pos_Invoice::INVOICE_STATUS_OPEN;

		$data['sales_invoices'] = Model_Pos_Invoice::find('all', 
									array('where' => array(
										array('status', '=', $status)
									), 
									'order_by' => array('id' => 'desc'), 
									'limit' => 1000));
		$data['status'] = $status;
        
		$this->template->title = "Invoices";
		$this->template->content = View::forge('sales/invoice/index', $data);
	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('pos');

		if ( ! $data['pos_invoice'] = Model_Pos_Invoice::find($id))
		{
			Session::set_flash('error', 'Could not find invoice #'.$id);
			Response::redirect('pos');
		}
		$this->template->title = "Invoice";
		$this->template->content = View::forge('pos/invoice/view', $data);
	}

	public function action_save($id = null)
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Pos_Invoice::validate('create');

			if ($val->run())
			{
				$pos_invoice = Model_Pos_Invoice::forge(array(
					'id' => Input::post('id'),
					// 'po_number' => Input::post('po_number'),
					'customer_id' => Input::post('customer_id'),
					'customer_name' => Input::post('customer_name'),
					'issue_date' => Input::post('issue_date'),
					'due_date' => Input::post('due_date'),
					'status' => Input::post('status'),
					// 'source' => Input::post('source'),
					// 'source_id' => Input::post('source_id'),
					'branch_id' => Input::post('branch_id'),
					'branch_name' => Input::post('branch_name'),
					'amount_due' => Input::post('amount_due'),
					'amount_paid' => Input::post('amount_paid'),
					'disc_total' => Input::post('disc_total'),
					'tax_total' => Input::post('tax_total'),
					'amounts_tax_inc' => Input::post('amounts_tax_inc'),
					'balance_due' => Input::post('balance_due'),
					'paid_status' => Input::post('paid_status'),
					'notes' => Input::post('notes'),
					'fdesk_user' => Input::post('fdesk_user'),
				));

				try 
				{
					DB::start_transaction();
					
					if ($pos_invoice and $pos_invoice->save())
					{
						// save the line item(s)
						$item = Input::post('item');
						// re-index array starting with 1 not 0 (resolves row_id mixup in UI)
						$item = array_combine(range(1, count($item)), array_values($item));
						$item_count = count($item);						
						for ($i = 1; $i <= $item_count; $i++)
						{
							$pos_invoice_item = Model_Pos_Invoice_Item::forge(array(
								'item_id' => $item[$i]['item_id'],
								'qty' => $item[$i]['qty'],
								'unit_price' => $item[$i]['unit_price'],
								'amount' => $item[$i]['amount'],
								'invoice_id' => $pos_invoice->id,
								'discount_percent' => $item[$i]['discount_percent'],
								'gl_account_id' => null, // $item[$i]['gl_account_id'],
								'description' => $item[$i]['description'],
							));
							$pos_invoice_item->save();
						}
						DB::commit_transaction();		
						Session::set_flash('success', 'Added invoice #'.$pos_invoice->id.'.');
						Response::redirect('pos');
					}
					else
					{
						Session::set_flash('error', 'Could not save invoice.');
					}
				}
				catch (Fuel\Core\Database_Exception $e)
				{
					DB::rollback_transaction();
					Session::set_flash('error', $e->getMessage());
					// throw $e;
				}				
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}
        // !!! check the source and load correct model ref
		// $booking = Model_Facility_Booking::find($id);
		// $lease = Model_Lease::find($id);
		// $this->template->set_global('order', $booking, false);

		// prepare invoice item as global variable
		$pos_invoice_item = Model_Pos_Invoice_Item::forge();
		$this->template->set_global('pos_invoice_item', $pos_invoice_item, false);

		// get default billable and enabled item
        $services = DB::select('id','code')
                        ->from('service_item')
                        ->where(array('billable' => true, 'enabled' => true))
                        ->execute()
						->as_array();

		$this->template->set_global('service_item', json_encode($services), false);

		$this->template->title = "Invoice";
		$this->template->content = View::forge('pos/invoice/create');
	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('pos');

		if ($pos_invoice = Model_Pos_Invoice::find($id))
		{
			// what about the payment entries and stock quantities
	        $result = $pos_invoice->delete();			
	        Session::set_flash('success', 'Deleted invoice #'.$id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete invoice #'.$id);
		}
		Response::redirect('pos');
	}
}
