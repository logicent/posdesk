<tr id="payment_<?= $row_id ?>">
	<td class="text-right" width="50%">
		<?= Form::label($pos_invoice_payment->payment_method, 'amount_paid', 
						array('class'=>'control-label small')); ?>
		&emsp;
		<?= Form::hidden("payment[$row_id][id]", Input::post('id', $pos_invoice_payment->id)) ?>
		<?= Form::hidden("payment[$row_id][receipt_number]", Input::post('receipt_number', $pos_invoice_payment->receipt_number)) ?>
		<?= Form::hidden("payment[$row_id][payment_method]", Input::post('payment_method', $pos_invoice_payment->payment_method)) ?>
	</td>
	<td class="text-right">
		<?= Form::input("payment[$row_id][amount_paid]", Input::post('amount_paid', $pos_invoice_payment->amount_paid),
						array('class' => 'col-md-4 form-control text-right')) ?>
	</td>
</tr>
