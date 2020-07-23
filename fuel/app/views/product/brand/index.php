<div class="row">
	<div class="col-md-6">
		<h2>Listing <span class='text-muted'>Brand</span></h2>
	</div>

	<div class="col-md-6">
		<br>
		<?= Html::anchor('product/brand/create', 'New', array('class' => 'pull-right btn btn-primary')); ?>
	</div>
</div>
<hr>

<?php if ($product_brands): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>Name</th>
			<th>Status</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($product_brands as $item): ?>		
		<tr>
			<td>
                <?= Html::anchor('product/brand/edit/'.$item->id, $item->name, ['class' => 'clickable']); ?>
            </td>
            <td><?= (bool) $item->enabled ? 
                '<i class="fa fa-circle-o fa-fw text-success"></i>Enabled' :
                '<i class="fa fa-circle-o fa-fw text-danger"></i>Disabled' ?> 
            </td>
			<td class="text-center">
				<?= Html::anchor('product/brand/delete/'.$item->id, '<i class="fa fa-trash-o fa-fw"></i>',
                                array('class' => 'text-muted del-btn', 'onclick' => "return confirm('Are you sure?')")); ?>
			</td>
		</tr>
<?php endforeach; ?>	
	</tbody>
</table>

<?php else: ?>
<p>No Brand.</p>

<?php endif; ?>