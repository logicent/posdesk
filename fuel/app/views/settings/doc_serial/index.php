<div class="row">
	<div class="col-md-6">
		<h2>Listing <span class='text-muted'>Document Serial</span></h2>
	</div>
	<div class="col-md-6">
		<br>
		<?= Html::anchor('admin/settings/serial/create', 'New', array('class' => 'pull-right btn btn-primary')); ?>
	</div>
</div>
<hr>

<?php if ($serial): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
            <th>Description</th>
            <th>Status</th>
            <th>Start</th>
            <th>Next</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($serial as $item): ?>		
        <tr>
            <td><?= Html::anchor('admin/settings/serial/edit/'.$item->id, $item->name, ['class' => 'clickable']); ?></td>
            <td><?= (bool) $item->enabled ? 
                '<i class="fa fa-circle-o fa-fw text-success"></i>Enabled' : 
                '<i class="fa fa-circle-o fa-fw text-danger"></i>Disabled' ?>
            </td>
            <td><?= $item->start ?></td>
            <td><?= $item->next ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
                        <?= Html::anchor('admin/settings/serial/delete/'.$item->id, '<i class="fa fa-trash-o fa-fw"></i>', 
                                array('class' => 'text-muted del-btn', 'onclick' => "return confirm('Are you sure?')")); ?>
                    </div>
				</div>
			</td>
		</tr>
<?php endforeach; ?>	
    </tbody>
</table>

<?php else: ?>
<p>No Serial.</p>

<?php endif; ?><p>
