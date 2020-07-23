<h2>Listing <span class='muted'>Item Locations</span></h2>
<br>
<?php if ($item_locations): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>Item</th>
			<th>Location</th>
			<th>Quantity</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($item_locations as $item): ?>		
		<tr>
			<td><?= $item->item_id; ?></td>
			<td><?= $item->location_id; ?></td>
			<td><?= $item->quantity; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
					<?= Html::anchor('product/item/location/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>					<?= Html::anchor('product/item/location/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-default btn-sm')); ?>					<?= Html::anchor('product/item/location/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>					</div>
				</div>
			</td>
		</tr>
<?php endforeach; ?>	
	</tbody>
</table>

<?php else: ?>
<p>No Item Location.</p>

<?php endif; ?>