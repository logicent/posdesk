<tr id="item_<?= $row_id ?>">
	<td class="col-md-1 text-center select-row">
		<?= Form::checkbox($row_id, false, array('value' => isset($invoice_item) ? $invoice_item->item_id : '')) ?>
		<?= Form::hidden("item[$row_id][id]", Input::post('id', isset($invoice_item) ? $invoice_item->id : ''),
						array('class' => 'item-id')); ?>
	</td>
	<td class="col-md-5 item">
		<?= Form::select("item[$row_id][item_id]", Input::post('item_id', isset($invoice_item) ? $invoice_item->item_id : ''),
						Model_Product_Item::listOptions(isset($invoice_item) ? $invoice_item->item_id : ''), 
						array('class' => 'input-sm form-control select-from-list')); ?>
		<?= Form::hidden("item[$row_id][description]", Input::post('description', isset($invoice_item) ? $invoice_item->description : ''),
						array('class' => 'item-description')); ?>
	</td>
	<td class="col-md-2 qty">
		<?= Form::input("item[$row_id][quantity]", Input::post('quantity', isset($invoice_item) ? 
						number_format($invoice_item->quantity, 0, '.', '') : ''),
						array('class' => 'input-sm form-control')); ?>
	</td>
	<td class='col-md-2 price'>
		<?= Form::input("item[$row_id][unit_price]", Input::post('unit_price', isset($invoice_item) ? 
						number_format($invoice_item->unit_price, 0, '.', '') : ''),
						array('class' => 'input-sm form-control text-right')); ?>
		<?= Form::hidden("item[$row_id][discount_rate]", Input::post('discount_rate', isset($invoice_item) ? 
						number_format($invoice_item->discount_rate, 0, '.', '') : '0'),
						array('class' => 'input-sm form-control')); ?>
		<?= Form::hidden("item[$row_id][discount_amount]", Input::post('discount_amount', isset($invoice_item) ? 
						number_format($invoice_item->discount_amount, 0, '.', '') : '0'),
						array('class' => 'input-sm form-control')); ?>						
	</td>
	<td class='col-md-2 item-total text-number'>
		<span><?= number_format(isset($invoice_item) ? $invoice_item->amount : '0', 0) ?></span>
		<?= Form::hidden("item[$row_id][amount]", Input::post('amount', isset($invoice_item) ? $invoice_item->amount : '')); ?>						
	</td>
</tr>
