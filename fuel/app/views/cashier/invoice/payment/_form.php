<tr id="payment_<?= $row_id ?>">
	<td class="text-right" width="50%">
		<?= Form::label($pos_invoice_payment->payment_method, 'amount_paid', 
						array('class'=>'control-label small')); ?>
		&emsp;
		<?= Form::hidden("payment[$row_id][reference]", Input::post('reference', $pos_invoice_payment->reference)); ?>
		<?= Form::hidden("payment[$row_id][id]", Input::post('id', $pos_invoice_payment->id)) ?>
		<?= Form::hidden("payment[$row_id][receipt_number]", Input::post('receipt_number', $pos_invoice_payment->receipt_number)) ?>
		<?= Form::hidden("payment[$row_id][payment_method]", Input::post('payment_method', $pos_invoice_payment->payment_method)) ?>
		<?= Form::hidden("payment[$row_id][status]", Input::post('status', Model_Sales_Invoice::INVOICE_PAID_STATUS_NOT_PAID)); ?>
		<?= Form::hidden("payment[$row_id][date_paid]", Input::post('date_paid', date('Y-m-d'))); ?>
		<?= Form::hidden("payment[$row_id][amount_due]", Input::post('amount_due', $pos_invoice_payment->amount_due)); ?>
		<?= Form::hidden("payment[$row_id][fdesk_user]", Input::post('fdesk_user', $uid)); ?>
	</td>
	<td class="text-right amount-paid">
		<?= Form::input("payment[$row_id][amount_paid]", Input::post('amount_paid', $pos_invoice_payment->amount_paid),
						array(
							'class' => 'col-md-4 form-control text-right payment-entry',
							'readonly' => true
						)) ?>
	</td>
</tr>
