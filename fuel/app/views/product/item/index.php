<div class="row">
	<div class="col-md-6">
		<h2>Listing <span class='text-muted'>Product</span></h2>
	</div>

	<div class="col-md-6">
		<br>
		<?= Html::anchor('product/item/create', 'New', array('class' => 'pull-right btn btn-primary')); ?>
	</div>
</div>
<hr>

<?php if ($product_items): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>Item name</th>
			<th>Status</th>
			<th>Qty</th>
			<th>Cost price</th>
			<th>Unit price</th>
			<th>Code</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($product_items as $item): ?>
		<tr>
			<td>
                <?= Html::anchor('product/item/edit/'.$item->id, $item->item_name, ['class' => 'clickable']); ?>
            </td>
            <td><?= (bool) $item->enabled ? 
                '<i class="fa fa-circle-o fa-fw text-success"></i>Enabled' :
                '<i class="fa fa-circle-o fa-fw text-danger"></i>Disabled' ?> 
            </td>
			<td><?= $item->quantity; ?></td>
			<td class="text-right"><?= number_format($item->cost_price); ?></td>
			<td class="text-right"><?= number_format($item->unit_price); ?></td>
			<td class="text-muted"><?= $item->item_code; ?></td>
			<td class="text-center">
				<?= Html::anchor('product/item/delete/'.$item->id, '<i class="fa fa-trash-o fa-fw"></i>',
                                array('class' => 'text-muted del-btn', 'onclick' => "return confirm('Are you sure?')")); ?>
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<?php else: ?>
<p>No Product.</p>
<?php endif; ?>
