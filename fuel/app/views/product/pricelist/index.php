<div class="row">
	<div class="col-md-6">
		<h2>Listing <span class='text-muted'>Price List</span></h2>
	</div>
	<div class="col-md-6">
		<br>
		<?= Html::anchor('product/price/list/create', 'New', array('class' => 'pull-right btn btn-primary')); ?>
	</div>
</div>
<hr>

<?php if ($price_lists): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>Name</th>
			<th>Status</th>
			<th>Type</th>
			<th>Currency</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($price_lists as $item): ?>		
		<tr>
			<td>
				<?= Html::anchor('product/price/list/edit/'.$item->id, $item->name, ['class' => 'clickable']); ?>
			</td>
            <td><?= (bool) $item->enabled ? 
				'<i class="fa fa-circle-o fa-fw text-success"></i>Enabled' : 
				'<i class="fa fa-circle-o fa-fw text-danger"></i>Disabled' ?>
            </td>
			<td><?= $item->module; ?></td>
			<td><?= $item->currency; ?></td>
			<td>
				<?= Html::anchor('product/price/list/delete/'.$item->id, '<i class="fa fa-trash-o fa-fw"></i>',
                                array('class' => 'text-muted del-btn', 'onclick' => "return confirm('Are you sure?')")); ?>
			</td>
		</tr>
<?php endforeach; ?>	
	</tbody>
</table>

<?php else: ?>
<p>No Price list.</p>
<?php endif; ?>