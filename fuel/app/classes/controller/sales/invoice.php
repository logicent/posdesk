<?php

class Controller_Sales_Invoice extends Controller_Authenticate
{
    public function action_index()
	{
		$status = Input::get('status');
		if (!$status)
			$status = Model_Sales_Invoice::INVOICE_STATUS_OPEN;

		$data['sales_invoices'] = Model_Sales_Invoice::find('all', 
									array('where' => array(
										array('status', '=', $status)
									), 
									'order_by' => array('id' => 'desc'), 
									'limit' => 1000));
		$data['status'] = $status;
        
		$this->template->title = "Sales";
		$this->template->content = View::forge('sales/invoice/index', $data);
	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('sales');

		if ( ! $data['sales_invoice'] = Model_Sales_Invoice::find($id))
		{
			Session::set_flash('error', 'Could not find invoice #'.$id);
			Response::redirect('sales');
		}
		$this->template->title = "Sale";
		$this->template->content = View::forge('sales/invoice/view', $data);
	}
	
	public function action_create($id = null)
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Sales_Invoice::validate('create');

			if ($val->run())
			{
				$sales_invoice = Model_Sales_Invoice::forge(array(
					'id' => Input::post('id'),
					'invoice_no' => Input::post('invoice_no'),
					'po_number' => Input::post('po_number'),
					'customer_id' => Input::post('customer_id'),
					'customer_name' => Input::post('customer_name'),
					'issue_date' => Input::post('issue_date'),
					'due_date' => Input::post('due_date'),
					'status' => Input::post('status'),
					'source' => Input::post('source'),
					'source_id' => Input::post('source_id'),
					'branch_id' => Input::post('branch_id'),
					'branch_name' => Input::post('branch_name'),
					'amount_due' => Input::post('amount_due'),
					'amount_paid' => Input::post('amount_paid'),
					'subtotal' => Input::post('subtotal'),
					'discount_rate' => Input::post('discount_rate'),
					'discount_total' => Input::post('discount_total'),
					'tax_total' => Input::post('tax_total'),
					'amounts_tax_inclusive' => Input::post('amounts_tax_inclusive'),
					'balance_due' => Input::post('balance_due'),
					'shipping_fee' => Input::post('shipping_fee'),
					'shipping_tax' => Input::post('shipping_tax'),
					'shipping_address' => Input::post('shipping_address'),
					'paid_status' => Input::post('paid_status'),
					'notes' => Input::post('notes'),
					'fdesk_user' => Input::post('fdesk_user'),
				));

				try 
				{
					DB::start_transaction();
					
					if ($sales_invoice and $sales_invoice->save())
					{
						// save the line item(s)
						$item = Input::post('item');
						// re-index array starting with 1 not 0 (resolves row_id mixup in UI)
						$item = array_combine(range(1, count($item)), array_values($item));
						$item_count = count($item);						
						for ($i = 1; $i <= $item_count; $i++)
						{
							$sales_invoice_item = Model_Sales_Invoice_Item::forge(array(
								'item_id' => $item[$i]['item_id'],
								'quantity' => $item[$i]['quantity'],
								'unit_price' => $item[$i]['unit_price'],
								'amount' => $item[$i]['amount'],
								'invoice_id' => $sales_invoice->id,
								'tax_rate' => $item[$i]['tax_rate'],
								'discount_rate' => $item[$i]['discount_rate'],
								'discount_amount' => $item[$i]['discount_amount'],
								'description' => $item[$i]['description'],
							));
							$sales_invoice_item->save();
						}
						DB::commit_transaction();		
						Session::set_flash('success', 'Added invoice #'.$sales_invoice->id.'.');
						Response::redirect('sales');
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

		// prepare invoice item as global variable
		$sales_invoice_item = Model_Sales_Invoice_Item::forge();
		$this->template->set_global('sales_invoice_item', $sales_invoice_item, false);

		$this->template->title = "Sale";
		$this->template->content = View::forge('sales/invoice/create');
	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('sales');

		if ( ! $sales_invoice = Model_Sales_Invoice::find($id))
		{
			Session::set_flash('error', 'Could not find invoice #'.$id);
			Response::redirect('sales');
		}
		
		$val = Model_Sales_Invoice::validate('edit');
		
		if ($val->run())
		{
			$sales_invoice->po_number = Input::post('po_number');
			$sales_invoice->amounts_tax_inclusive = Input::post('amounts_tax_inclusive');
			$sales_invoice->issue_date = Input::post('issue_date');
			$sales_invoice->due_date = Input::post('due_date');
			$sales_invoice->status = Input::post('status');
			$sales_invoice->branch_id = Input::post('branch_id');
			$sales_invoice->branch_name = Input::post('branch_name');
			$sales_invoice->source_id = Input::post('source_id');
			$sales_invoice->source = Input::post('source');
			$sales_invoice->customer_id = Input::post('customer_id');
			$sales_invoice->customer_name = Input::post('customer_name');
			$sales_invoice->amount_due = Input::post('amount_due');
			$sales_invoice->subtotal = Input::post('subtotal');
			$sales_invoice->discount_rate = Input::post('discount_rate');
			$sales_invoice->discount_total = Input::post('discount_total');
			$sales_invoice->tax_total = Input::post('tax_total');
			$sales_invoice->amount_paid = Input::post('amount_paid');
			$sales_invoice->balance_due = Input::post('balance_due');
			$sales_invoice->paid_status = Input::post('paid_status');
			$sales_invoice->shipping_fee = Input::post('shipping_fee');
			$sales_invoice->shipping_tax = Input::post('shipping_tax');
			$sales_invoice->shipping_address = Input::post('shipping_address');
			$sales_invoice->notes = Input::post('notes');
			$sales_invoice->fdesk_user = Input::post('fdesk_user');

			// update Invoice Amounts if discounted
			Model_Sales_Invoice::applyDiscountAmount($sales_invoice);
		
			try {
				DB::start_transaction();
				if ($sales_invoice->save())
				{
					// save the line item(s)
					$item = Input::post('item');
					// re-index array starting with 1 not 0 (resolves row_id mixup in UI)
					$item = array_combine(range(1, count($item)), array_values($item));
					$item_count = count($item);
					for ($i = 1; $i <= $item_count; $i++)
					{
						if ( ! $sales_invoice_item = Model_Sales_Invoice_item::find($item[$i]['id']) )
						{
							$sales_invoice_item = Model_Sales_Invoice_Item::forge(array(
								'item_id' => $item[$i]['item_id'],
								'quantity' => $item[$i]['quantity'],
								'unit_price' => $item[$i]['unit_price'],
								'amount' => $item[$i]['amount'],
								'invoice_id' => $sales_invoice->id,
								'tax_rate' => $item[$i]['tax_rate'],
								'discount_rate' => $item[$i]['discount_rate'],
								'discount_amount' => $item[$i]['discount_amount'],
								'description' => $item[$i]['description'],
							));
						}
						else {
							$sales_invoice_item->item_id = $item[$i]['item_id'];
							$sales_invoice_item->quantity = $item[$i]['quantity'];
							$sales_invoice_item->unit_price = $item[$i]['unit_price'];
							$sales_invoice_item->amount = $item[$i]['amount'];
							$sales_invoice_item->invoice_id = $sales_invoice->id;
							$sales_invoice_item->discount_rate = $item[$i]['discount_rate'];
							$sales_invoice_item->discount_amount = $item[$i]['discount_amount'];
							$sales_invoice_item->tax_rate = $item[$i]['tax_rate'];
							$sales_invoice_item->description = $item[$i]['description'];
						}
						$sales_invoice_item->save();
					}
					DB::commit_transaction();
					Session::set_flash('success', 'Updated invoice #' . $id);
				}
				else
				{
					Session::set_flash('error', 'Could not update invoice #' . $id);
				}
				Response::redirect('sales');
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
			if (Input::method() == 'POST')
			{
				$sales_invoice->id = $val->validated('id');
				$sales_invoice->invoice_no = $val->validated('invoice_no');
				$sales_invoice->po_number = $val->validated('po_number');
				$sales_invoice->issue_date = $val->validated('issue_date');
				$sales_invoice->due_date = $val->validated('due_date');
				$sales_invoice->status = $val->validated('status');
				$sales_invoice->amounts_tax_inclusive = $val->validated('amounts_tax_inclusive');
				$sales_invoice->branch_id = $val->validated('branch_id');
				$sales_invoice->branch_name = $val->validated('branch_name');
				$sales_invoice->source_id = $val->validated('source_id');
				$sales_invoice->source = $val->validated('source');
                $sales_invoice->customer_id = $val->validated('customer_id');
                $sales_invoice->customer_name = $val->validated('customer_name');
				$sales_invoice->amount_due = $val->validated('amount_due');
				$sales_invoice->subtotal = $val->validated('subtotal');
				$sales_invoice->discount_rate = $val->validated('discount_rate');
				$sales_invoice->discount_total = $val->validated('discount_total');
				$sales_invoice->tax_total = $val->validated('tax_total');
				$sales_invoice->amount_paid = $val->validated('amount_paid');
				$sales_invoice->balance_due = $val->validated('balance_due');
				$sales_invoice->paid_status = $val->validated('paid_status');
				$sales_invoice->shipping_fee = $val->validated('shipping_fee');
				$sales_invoice->shipping_tax = $val->validated('shipping_tax');
				$sales_invoice->shipping_address = $val->validated('shipping_address');
				$sales_invoice->notes = $val->validated('notes');

				Session::set_flash('error', $val->error());
			}
			$this->template->set_global('sales_invoice', $sales_invoice, false);
		}
		$this->template->title = "Sales";
		$this->template->content = View::forge('sales/invoice/edit');
	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('sales');

		if ($sales_invoice = Model_Sales_Invoice::find($id))
		{
	        $result = $sales_invoice->delete();			
	        Session::set_flash('success', 'Deleted invoice #'.$id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete invoice #'.$id);
		}
		Response::redirect('sales');
	}
}
