<div class="row">
	<div class="col-md-6">
		<h2>Listing <span class='text-muted'>Product Group</span></h2>
	</div>

	<div class="col-md-6">
		<br>
		<?= Html::anchor('product/group/create', 'New', array('class' => 'pull-right btn btn-primary')); ?>
	</div>
</div>
<hr>

<?php if ($product_groups): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>Description</th>
			<th>Status</th>
			<th>Parent</th>
			<th>Code</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($product_groups as $item): ?>
		<tr>
			<td>
                <?= Html::anchor('product/group/edit/'.$item->id, $item->name, ['class' => 'clickable']); ?>
            </td>
            <td><?= (bool) $item->enabled ? 
                '<i class="fa fa-circle-o fa-fw text-success"></i>Enabled' :
                '<i class="fa fa-circle-o fa-fw text-danger"></i>Disabled' ?> 
            </td>
			<td class="text-muted"><?= $item->parent ? $item->parent->name : ''; ?></td>
			<td class="text-muted"><?= $item->code; ?></td>
			<td class="text-center">
				<?= Html::anchor('product/group/delete/'.$item->id, '<i class="fa fa-trash-o fa-fw"></i>',
                                array('class' => 'text-muted del-btn', 'onclick' => "return confirm('Are you sure?')")); ?>
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<?php else: ?>
<p>No Product Group.</p>
<?php endif; ?>
