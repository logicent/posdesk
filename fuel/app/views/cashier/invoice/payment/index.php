<table id="items" class="table table-hover">
	<thead>
		<tr style="font-size: 90%">
			<th class="col-md-6">REFERENCE</th>
			<th class="col-md-6 text-right">AMOUNT PAID</th>
		</tr>
	</thead>
	<tbody id="item_detail">
<?php 
	if ($pos_invoice_payments) : 
        foreach ($pos_invoice_payments as $row_id => $item) :
			echo render('cashier/invoice/payment/_form', array('invoice_payment' => $item, 'row_id' => $row_id));
        endforeach;
    else : ?>
        <tr id="no_payments" style="font-size: 115%;">
			<td style="height: 41px" class="text-muted text-center" colspan="5">No payments</td>
		</tr>
<?php
    endif ?>
	</tbody>
</table>

<!-- TODO: hide buttons if view mode -->
<div class="form-group">
    <div class="col-md-6">
        <button id="del_item" data-url="/sales/invoice/item/delete" class="btn btn-sm btn-danger" style="display: none;"><i class="fa fa-fw fa-lg fa-trash-o"></i></button>
    </div>
</div>

<script>
	<?= render('cashier/invoice/payment/index.js'); ?>
</script>
