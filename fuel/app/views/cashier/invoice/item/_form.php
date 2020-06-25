<tr id="item_<?= $row_id ?>">
	<td style="padding: 8px" class="text-center select-row">
		<?= Form::checkbox($row_id, false, array('value' => $invoice_item->id)) ?>
		<?= Form::hidden("item[$row_id][id]", Input::post('id', $invoice_item->id), array('class' => 'item-id')); ?>
	</td>
	<td class="item" style="vertical-align: middle">
		<div id="item_name">
			<?= strtoupper($item->item_code) .'&ensp;&ndash;&ensp;'. strtoupper($item->item_name) ?>&ensp;
			<span class="text-muted" id="qty_in_stock">(<?= $item->quantity ?>)</span>
		</div>
		<?= Form::hidden("item[$row_id][item_id]", Input::post('item_id', $invoice_item->item_id)); ?>						
		<?= Form::hidden("item[$row_id][description]", Input::post('description', $invoice_item->description),
						array('class' => 'item-description')); ?>
	</td>
	<td class="qty">
		<?= Form::input("item[$row_id][quantity]", Input::post('quantity', 
						number_format($invoice_item->quantity, 0, '.', '')),
						array('class' => 'input-sm form-control')); ?>
	</td>
	<td class='price'>
		<?= Form::input("item[$row_id][unit_price]", Input::post('unit_price', 
						number_format($invoice_item->unit_price, 2, '.', '')),
						array('class' => 'input-sm form-control text-right', 'id' => 'unit_price')); ?>
		<?= Form::hidden("item[$row_id][tax_rate]", Input::post('tax_rate', $invoice_item->tax_rate),
						array('id' => 'tax_rate')); ?>
	</td>
	<td class='discount' style="display: none">
		<?= Form::input("item[$row_id][discount_percent]", Input::post('discount_percent', 
						number_format($invoice_item->discount_percent, 0, '.', '')),
						array('class' => 'input-sm form-control')); ?>						
	</td>
	<td class='item-total text-right' style="vertical-align: middle; padding-right: 10px; font-size: 105%;">
		<span><?= number_format($invoice_item->amount, 2) ?></span>
		<?= Form::hidden("item[$row_id][amount]", Input::post('amount', $invoice_item->amount)); ?>						
	</td>
</tr>
