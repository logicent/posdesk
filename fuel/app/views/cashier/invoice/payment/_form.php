<tr id="item_<?= $row_id ?>">
	<td class="text-right">
		<?= Form::hidden("payment[$row_id][id]", Input::post('id', isset($sales_payment) ? $sales_payment->id : '')) ?>
		<?= Form::hidden("payment[$row_id][receipt_number]", Input::post('receipt_number', isset($sales_payment) ? $sales_payment->receipt_number : '')) ?>
		<?= Form::input("payment[$row_id][amount_paid]", Input::post('amount_paid', isset($sales_payment) ? $sales_payment->amount_paid : 0),
						array('class' => 'col-md-4 form-control')) ?>
	</td>
</tr>
