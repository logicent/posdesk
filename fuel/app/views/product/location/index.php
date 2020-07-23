<div class="row">
	<div class="col-md-6">
		<h2>Listing <span class='text-muted'>Location</span></h2>
	</div>

	<div class="col-md-6">
		<br>
	<?= Html::anchor('product/location/create', 'New', array('class' => 'pull-right btn btn-primary')); ?>
	</div>
</div>
<hr>

<?php if ($locations): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>Name</th>
			<th>Enabled</th>
			<!-- <th>Description</th> -->
			<th>Branch</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($locations as $item): ?>		
		<tr>
			<td>
                <?= Html::anchor('product/location/edit/'.$item->id, $item->name, ['class' => 'clickable']); ?>
            </td>
            <td><?= (bool) $item->enabled ? 
                '<i class="fa fa-circle-o fa-fw text-success"></i>Enabled' :
                '<i class="fa fa-circle-o fa-fw text-danger"></i>Disabled' ?> 
            </td>
			<!-- <td><?= $item->description; ?></td> -->
			<td><?= !empty($item->branch_id) ? $item->branch->trading_name : ''; ?></td>
			<td class="text-center">
				<?= Html::anchor('product/location/delete/'.$item->id, '<i class="fa fa-trash-o fa-fw"></i>',
                                array('class' => 'text-muted del-btn', 'onclick' => "return confirm('Are you sure?')")); ?>
			</td>
		</tr>
<?php endforeach; ?>	
	</tbody>
</table>

<?php else: ?>
<p>No Location.</p>

<?php endif; ?>
