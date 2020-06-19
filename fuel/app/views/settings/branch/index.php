<div class="row">
	<div class="col-md-6">
		<h2>Listing <span class='text-muted'>Branch</span></h2>
	</div>
	<div class="col-md-6">
		<br>
		<?= Html::anchor('admin/settings/branch/create', 'New', array('class' => 'pull-right btn btn-primary')); ?>
	</div>
</div>
<hr>

<?php if ($branches): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>Trading Name</th>
			<th>Status</th>
			<th>Phone Numbers</th>
			<th>Email Address</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
    <?php foreach ($branches as $item): ?>	
        <tr>
            <td><?= Html::anchor('admin/settings/branch/edit/'.$item->id, $item->trading_name, ['class' => 'clickable']) ?></td>
            <td><?= (bool) $item->enabled ? 
                '<i class="fa fa-circle-o fa-fw text-success"></i>Enabled' : 
                '<i class="fa fa-circle-o fa-fw text-danger"></i>Disabled' ?>
            </td>
            <td class="text-muted"><?= $item->phone_number ?></td>
            <td class="text-muted"><?= $item->email_address ?></td>
			<td class="text-center">
				<?= Html::anchor('admin/settings/branch/delete/'.$item->id, '<i class="fa fa-trash-o fa-fw"></i>', array('class' => 'text-muted del-btn', 'onclick' => "return confirm('Are you sure?')")); ?>
			</td>
        </tr>
    <?php endforeach; ?>	
    </tbody>
</table>

<?php else: ?>
<p>No Branch.</p>

<?php endif; ?><p>
