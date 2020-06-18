<?php

class Controller_Purchase_Invoice extends Controller_Authenticate
{
	public function action_index()
	{
		$status = Input::get('status');
		if (!$status)
			$status = Model_Purchase_Invoice::INVOICE_STATUS_OPEN;

		$data['purchases_invoices'] = Model_Purchase_Invoice::find('all', 
									array('where' => array(
										array('status', '=', $status)
									), 
									'order_by' => array('id' => 'desc'), 
									'limit' => 1000));
		$data['status'] = $status;
        
		$this->template->title = "Purchases";
		$this->template->content = View::forge('purchase/invoice/index', $data);
	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('pos');

		if ( ! $data['pos_invoice'] = Model_Purchase_Invoice::find($id))
		{
			Session::set_flash('error', 'Could not find invoice #'.$id);
			Response::redirect('pos');
		}
		$this->template->title = "Purchase";
		$this->template->content = View::forge('purchase/invoice/view', $data);
	}

	public function action_create($id = null)
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Purchase_Invoice::validate('create');

			if ($val->run())
			{
				$purchase_invoice = Model_Purchase_Invoice::forge(array(
					'id' => Input::post('id'),
					// 'po_number' => Input::post('po_number'),
					'supplier_id' => Input::post('supplier_id'),
					'supplier_name' => Input::post('supplier_name'),
					'issue_date' => Input::post('issue_date'),
					'due_date' => Input::post('due_date'),
					'status' => Input::post('status'),
					'branch_id' => Input::post('branch_id'),
					'branch_name' => Input::post('branch_name'),
					'amount_due' => Input::post('amount_due'),
					'amount_paid' => Input::post('amount_paid'),
					'subtotal' => Input::post('subtotal'),
					'disc_total' => Input::post('disc_total'),
					'tax_total' => Input::post('tax_total'),
					'amounts_tax_inc' => Input::post('amounts_tax_inc'),
					'balance_due' => Input::post('balance_due'),
					'paid_status' => Input::post('paid_status'),
					'shipping_address' => Input::post('shipping_address'),
					'notes' => Input::post('notes'),
					'fdesk_user' => Input::post('fdesk_user'),
				));

				try 
				{
					DB::start_transaction();
					
					if ($purchase_invoice and $purchase_invoice->save())
					{
						// save the line item(s)
						$item = Input::post('item');
						// re-index array starting with 1 not 0 (resolves row_id mixup in UI)
						$item = array_combine(range(1, count($item)), array_values($item));
						$item_count = count($item);						
						for ($i = 1; $i <= $item_count; $i++)
						{
							$purchase_invoice_item = Model_Purchase_Invoice_Item::forge(array(
								'item_id' => $item[$i]['item_id'],
								'qty' => $item[$i]['qty'],
								'unit_price' => $item[$i]['unit_price'],
								'amount' => $item[$i]['amount'],
								'invoice_id' => $purchase_invoice->id,
								'discount_percent' => $item[$i]['discount_percent'],
								'gl_account_id' => null, // $item[$i]['gl_account_id'],
								'description' => $item[$i]['description'],
							));
							$purchase_invoice_item->save();
						}
						DB::commit_transaction();		
						Session::set_flash('success', 'Added invoice #'.$purchase_invoice->id.'.');
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

		// prepare invoice item as global variable
		$purchase_invoice_item = Model_Purchase_Invoice_Item::forge();
		$this->template->set_global('purchase_invoice_item', $purchase_invoice_item, false);

		$this->template->title = "Purchase";
		$this->template->content = View::forge('purchase/invoice/create');
	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('purchases');

		if ( ! $purchase_invoice = Model_Purchase_Invoice::find($id))
		{
			Session::set_flash('error', 'Could not find order #'.$id);
			Response::redirect('purchases');
		}
		
		$val = Model_Purchase_Invoice::validate('edit');
		
		if ($val->run())
		{
			$purchase_invoice->po_number = Input::post('po_number');
			$purchase_invoice->amounts_tax_inc = Input::post('amounts_tax_inc');
			$purchase_invoice->issue_date = Input::post('issue_date');
			$purchase_invoice->due_date = Input::post('due_date');
			$purchase_invoice->status = Input::post('status');
			$purchase_invoice->branch_id = Input::post('branch_id');
			$purchase_invoice->branch_name = Input::post('branch_name');
			$purchase_invoice->supplier_id = Input::post('supplier_id');
			$purchase_invoice->supplier_name = Input::post('supplier_name');
			$purchase_invoice->amount_due = Input::post('amount_due');
			$purchase_invoice->subtotal = Input::post('subtotal');
			$purchase_invoice->disc_total = Input::post('disc_total');
			$purchase_invoice->tax_total = Input::post('tax_total');
			$purchase_invoice->amount_paid = Input::post('amount_paid');
			$purchase_invoice->balance_due = Input::post('balance_due');
			$purchase_invoice->advance_paid = Input::post('advance_paid');
			$purchase_invoice->paid_status = Input::post('paid_status');
			$purchase_invoice->shipping_address = Input::post('shipping_address');
			$purchase_invoice->notes = Input::post('notes');
			$purchase_invoice->fdesk_user = Input::post('fdesk_user');

			// update Order Amounts if discounted
			Model_Purchase_Invoice::applyDiscountAmount($purchase_invoice);
		
			try {
				DB::start_transaction();
			
				if ($purchase_invoice->save())
				{
					// save the line item(s)
					for ($i=1; $i < count(Input::post('item_id')); $i++)
					{
						if ( ! $purchase_invoice_item = Model_Purchase_Invoice_item::find($id) )
						{
							$purchase_invoice_item = Model_Purchase_Invoice_Item::forge(array(
								'item_id' => Input::post("item_id")[$i],
								'qty' => Input::post("qty")[$i],
								'unit_price' => Input::post("unit_price")[$i],
								'amount' => Input::post("amount")[$i],
								'order_id' => $purchase_invoice->id,
								'discount_percent' => Input::post("discount_percent")[$i],
								'gl_account_id' => null, // Input::post("gl_account_id")[$i],
								'description' => Input::post("description")[$i],
							));
						}
						else {
							$purchase_invoice_item->item_id = Input::post('item_id')[$i];
							$purchase_invoice_item->qty = Input::post('qty')[$i];
							$purchase_invoice_item->unit_price = Input::post('unit_price')[$i];
							$purchase_invoice_item->amount = Input::post('amount')[$i];
							$purchase_invoice_item->order_id = Input::post('order_id')[$i];
							$purchase_invoice_item->discount_percent = Input::post('discount_percent')[$i];
							$purchase_invoice_item->gl_account_id = null; // Input::post('gl_account_id')[$i];
							$purchase_invoice_item->description = Input::post('description')[$i];
						}

						$purchase_invoice_item->save();
					}

					DB::commit_transaction();
	
					Session::set_flash('success', 'Updated order #' . $id);
				}
				else
				{
					Session::set_flash('error', 'Could not update order #' . $id);
				}
				
				Response::redirect('purchases');
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
				$purchase_invoice->po_number = $val->validated('po_number');
				$purchase_invoice->amounts_tax_inc = $val->validated('amounts_tax_inc');
				$purchase_invoice->issue_date = $val->validated('issue_date');
				$purchase_invoice->due_date = $val->validated('due_date');
				$purchase_invoice->status = $val->validated('status');
				$purchase_invoice->branch_id = $val->validated('branch_id');
				$purchase_invoice->branch_name = $val->validated('branch_name');
                $purchase_invoice->supplier_id = $val->validated('supplier_id');
                $purchase_invoice->supplier_name = $val->validated('supplier_name');
				$purchase_invoice->amount_due = $val->validated('amount_due');
				$purchase_invoice->subtotal = $val->validated('subtotal');
				$purchase_invoice->disc_total = $val->validated('disc_total');
				$purchase_invoice->tax_total = $val->validated('tax_total');
				$purchase_invoice->amount_paid = $val->validated('amount_paid');
				$purchase_invoice->balance_due = $val->validated('balance_due');
				$purchase_invoice->advance_paid = $val->validated('advance_paid');
				$purchase_invoice->paid_status = $val->validated('paid_status');
				$purchase_invoice->shipping_address = $val->validated('shipping_address');
				$purchase_invoice->notes = $val->validated('notes');

				Session::set_flash('error', $val->error());
			}
			$this->template->set_global('purchase_invoice', $purchase_invoice, false);
		}
		
		$this->template->title = "Invoice";
		$this->template->content = View::forge('purchase/invoice/edit');
	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('pos');

		if ($purchase_invoice = Model_Purchase_Invoice::find($id))
		{
			// what about the payment entries and stock quantities
	        $result = $purchase_invoice->delete();			
	        Session::set_flash('success', 'Deleted invoice #'.$id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete invoice #'.$id);
		}
		Response::redirect('pos');
	}
}
