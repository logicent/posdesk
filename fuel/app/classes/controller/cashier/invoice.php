<?php

class Controller_Cashier_Invoice extends Controller_Sales_Invoice
{
	public $pos_invoice;
	public $pos_invoice_item;
	public $save_passed = false;

	public function action_index()
	{
		if (Input::method() == 'POST')
		{
			// get the POS Invoice in POST
			$this->pos_invoice = Model_Cashier_Invoice::forge(array(
				'sale_type' => Input::post('sale_type'),
				'customer_id' => Input::post('customer_id'),
				'customer_name' => Input::post('customer_name'),
				'po_number' => Input::post('po_number'),
				'invoice_no' => Model_Cashier_Invoice::getNextSerialNumber(),
				'issue_date' => Input::post('issue_date'),
				'due_date' => Input::post('due_date'),
				'status' => Input::post('status'),
				'fdesk_user' => Input::post('fdesk_user'),
				'branch_id' => Input::post('branch_id'),
				'branch_name' => Input::post('branch_name'),
				'source' => Input::post('source'),
				'source_id' => Input::post('source_id'),
				'amount_due' => Input::post('amount_due'),
				'amount_paid' => Input::post('amount_paid'),
				'subtotal' => Input::post('subtotal'),
				'discount_rate' => Input::post('discount_rate'),
				'discount_total' => Input::post('discount_total'),
				'tax_total' => Input::post('tax_total'),
				'amounts_tax_inc' => Input::post('amounts_tax_inc'),
				'balance_due' => Input::post('balance_due'),
				'shipping_fee' => Input::post('shipping_fee'),
				'shipping_tax' => Input::post('shipping_tax'),
				'shipping_address' => Input::post('shipping_address'),
				'paid_status' => Input::post('paid_status'),
				'notes' => Input::post('notes'),
			));

			// get the line item(s) in POST
			$pos_invoice_item = Input::post('item');
			if ($pos_invoice_item)
			{
				// re-index array starting with 1 not 0 (resolves row_id mixup in UI)
				$items_count = count($pos_invoice_item);
				$items = array_combine(range(1, $items_count), array_values($pos_invoice_item));
				for ($i = 1; $i <= $items_count; $i++)
				{
					$this->pos_invoice_item[$i] = Model_Sales_Invoice_Item::forge(array(
						'item_id' => $items[$i]['item_id'],
						'quantity' => $items[$i]['quantity'],
						'unit_price' => $items[$i]['unit_price'],
						'amount' => $items[$i]['amount'],
						'tax_rate' => $items[$i]['tax_rate'],
						'discount_rate' => $items[$i]['discount_rate'],
						'discount_amount' => $items[$i]['discount_amount'],
						'description' => $items[$i]['description'],
					));
				}
				// save the posted Cashier Invoice
				$this->submit_sale();
				// prepare New Sale entry defaults
				if ($this->save_passed)
					$this->new_sale();
			}
			else {
				Session::set_flash('error', 'Must have Sales Items.');
			}
		}
		else {
			$this->new_sale();
		}

		// get POS profile of current user
		// $data['pos_profile] = Model_Pos_Profile::get_for_current_user()
		// $this->template->set_global('pos_profile', $pos_profile, false);

		$this->template->set_global('pos_invoice', $this->pos_invoice, false);
		$this->template->set_global('pos_invoice_item', $this->pos_invoice_item, false);

		$this->template->title = "Cashier";
		$this->template->content = View::forge('cashier/invoice/index');
	}

	public function submit_sale()
	{
		$val = Model_Cashier_Invoice::validate('create');

		if ($val->run())
		{
			try
			{
				DB::start_transaction();
				if ($this->pos_invoice and $this->pos_invoice->save())
				{
					foreach ($this->pos_invoice_item as $i => $item)
					{
						$item->invoice_id = $this->pos_invoice->id;
						$item->save();
					}
					DB::commit_transaction();
					// trigger direct print if supported
					Session::set_flash('success', 'Added POS Invoice #'.$this->pos_invoice->id.'.');
					// show printable receipt if no DP support
					return $this->save_passed = true;
				}
				else
				{
					Session::set_flash('error', 'Could not save POS Invoice.');
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

	public function new_sale()
	{
		$this->pos_invoice = Model_Cashier_Invoice::forge();
		// load the default column values in DB
		foreach ($this->pos_invoice->properties() as $property => $value)
		{
			$col_def = DB::list_columns('sales_invoice', "$property");
			$this->pos_invoice->$property = $col_def["$property"]['default'];
		}
		$this->pos_invoice_item = []; // use empty array for new sale
	}

	public function action_search()
    {
		$data = [];
        if (Input::is_ajax())
        {
            $item = Model_Product_Item::query()
										// ->where(array(
										// 	'group_id' => Input::post('group_id'),
										// ))
										->or_where(array(
											array('item_code', 'LIKE', Input::post('q'),)
										))
										->or_where(array(
											array('item_name', 'LIKE', Input::post('q'),)
										))
										->get();
										// ->to_array();
			$data['items'] = $item;
		}
		return json_encode($data);
	}
}
