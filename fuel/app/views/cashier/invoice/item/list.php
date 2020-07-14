<table id="items" class="table table-hover" style="font-size: 115%">
	<thead>
		<tr>
			<th class="col-md-1"><!-- delete btn --></th>
			<th class="col-md-<?= ((bool) $pos_profile->show_discount ? '5' : '6') ?>">ITEM</th>
			<th class="col-md-1">QTY</th>
			<th class="col-md-2 text-right">PRICE</th>
			<?php if ((bool) $pos_profile->show_discount) : ?>
			<th class="col-md-1 text-right">DISC.%</th>
			<?php endif ?>
			<th class="col-md-2 text-right">AMOUNT</th>
		</tr>
	</thead>
	<tbody id="item_detail">
<?php 
	if ($pos_invoice_items) : 
        foreach ($pos_invoice_items as $row_id => $item) :
			echo render('cashier/invoice/item/_form', array(
														'invoice_item' => $item, 
														'row_id' => $row_id
													));
        endforeach;
    else : ?>
        <tr id="no_items" style="font-size: 115%;">
			<td style="height: 41px" class="text-muted text-center" colspan="<?= (bool) $pos_profile->show_discount ? '6' : '5' ?>">No items</td>
		</tr>
<?php
    endif ?>
	</tbody>
</table>

<script>
	<?= render('cashier/invoice/item/index.js'); ?>
</script>
