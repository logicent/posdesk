<table id="payments" class="table table-hover" style="margin-bottom: 0">
	<!-- <thead>
		<tr style="font-size: 90%">
			<th class="col-md-6">REFERENCE</th>
			<th class="col-md-6 text-right">AMOUNT PAID</th>
		</tr>
	</thead> -->
	<tbody id="payment_detail">
	<!-- Payment methods -->
<?php 
	if ($pos_invoice_payments) : 
		foreach ($pos_invoice_payments as $row_id => $pos_invoice_payment) :
			echo render('cashier/invoice/payment/_form', 
						array(
							'pos_invoice_payment' => $pos_invoice_payment,
							'row_id' => $row_id
						));
        endforeach;
    endif ?>
	</tbody>
</table>

<script>
	<?= render('cashier/invoice/payment/index.js'); ?>
</script>
