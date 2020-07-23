<div class="row">
	<div class="col-md-6">
		<h2>Listing <span class='text-muted'>Item Price</span></h2>
	</div>
	<div class="col-md-6">
		<br>
		<?= Html::anchor('product/item/price/create', 'New', array('class' => 'pull-right btn btn-primary')); ?>
	</div>
</div>
<hr>

<?php if ($item_prices): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>Item</th>
			<th>Price list</th>
			<th>Rate</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($item_prices as $item): ?>		
		<tr>
			<td><?= $item->item->name; ?></td>
			<td><?= $item->price_list->name; ?></td>
			<td><?= $item->price_list_rate; ?></td>
			<td>
				<?= Html::anchor('product/item/price/delete/'.$item->id, '<i class="fa fa-trash-o fa-fw"></i>',
                                array('class' => 'text-muted del-btn', 'onclick' => "return confirm('Are you sure?')")); ?>
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<?php else: ?>
<p>No Item Price.</p>

<?php endif; ?>