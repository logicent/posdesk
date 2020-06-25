<table id="items" class="table table-hover">
	<thead>
		<tr style="font-size: 90%">
			<!-- TODO: hide this column if view mode -->
			<th class="col-md-1 text-center">
				<?= Form::checkbox('select_all_rows', false, array('id' => 'select_all_rows')) ?>
			</th>
			<th class="col-md-5">ITEM</th>
			<th class="col-md-2">QTY.</th>
			<th class="col-md-2 text-right">PRICE</th>
			<!-- show discount if allowed for user -->
			<th class="col-md-1" style="display: none">DISC. %</th>
			<th class="col-md-2 text-right">AMOUNT</th>
		</tr>
	</thead>
	<tbody id="item_detail">
<?php 
	if ($pos_invoice_items) : 
        foreach ($pos_invoice_items as $row_id => $item) :
			echo render('cashier/invoice/item/_form', array('invoice_item' => $item, 'row_id' => $row_id));
        endforeach;
    else : ?>
        <tr id="no_items" style="font-size: 115%;">
			<td style="height: 41px" class="text-muted text-center" colspan="5">No items</td>
		</tr>
<?php
    endif ?>
	</tbody>
</table>

<!-- TODO: hide buttons if view mode -->
<div class="form-group">
    <div class="col-md-6">
        <button id="del_item" data-url="/sales/invoice/item/delete" class="btn btn-sm btn-danger" style="display: none;"><i class="fa fa-fw fa-lg fa-trash-o"></i></button>
        <!-- <button id="add_item" data-url="/sales/invoice/item/create" class="btn btn-sm btn-default text-muted"><i class="fa fa-fw fa-lg fa-plus"></i></button> -->
    </div>
	<!--
    <div class="col-md-6 text-right">
        <?php Form::hidden('amounts_tax_inc', Input::post('amounts_tax_inc', isset($pos_invoice) ? $pos_invoice->amounts_tax_inc : '0')); ?>
        <?php Form::checkbox('cb_amounts_tax_inc', null, array('class' => 'cb-checked', 'data-input' => 'amounts_tax_inc')); ?>
        <?php Form::label('Amount is VAT incl.', 'cb_amounts_tax_inc', array('class'=>'control-label')); ?>		
    </div>-->
</div>

<script>
	<?= render('cashier/invoice/item/index.js'); ?>
</script>
