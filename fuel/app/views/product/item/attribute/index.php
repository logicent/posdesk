<div class="row">
	<div class="col-md-6">
		<h2>Listing <span class='text-muted'>Item Attributes</span></h2>
	</div>

	<div class="col-md-6">
		<br>
		<?= Html::anchor('product/item/attribute/create', 'New', array('class' => 'pull-right btn btn-primary')); ?>
	</div>
</div>
<hr>

<?php if ($item_attributes): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Item</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($item_attributes as $item): ?>		
		<tr>
			<td><?= $item->name; ?></td>
			<td><?= $item->description; ?></td>
			<td><?= $item->item_id; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
					<?= Html::anchor('product/item/attribute/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>					<?= Html::anchor('product/item/attribute/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-default btn-sm')); ?>					<?= Html::anchor('product/item/attribute/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>					</div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	
	</tbody>
</table>

<?php else: ?>
<p>No Item Attributes.</p>

<?php endif; ?>