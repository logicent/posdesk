<div class="row">
	<div class="col-md-6">
		<h2>Listing <span class='text-muted'>Cashier Profile</span></h2>
	</div>

	<div class="col-md-6">
        <br>
		<?= Html::anchor('admin/settings/cashier/profile/create', 'New', array('class' => 'btn btn-primary pull-right')); ?>    
	</div>
</div>
<hr>

<?php if ($cashier_profiles): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<!-- <th>Name</th> -->
			<th>Customer</th>
			<th>Enabled</th>
			<th>Branch</th>
			<th>Location</th>
			<!-- <th>Price list</th> -->
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($cashier_profiles as $item): ?>		
		<tr>
		<td><?= Html::anchor('admin/settings/cashier/profile/edit/'.$item->id, $item->customer->customer_name, array('class' => 'clickable')) ?></td>
            <td><?= (bool) $item->enabled ? 
                '<i class="fa fa-circle-o fa-fw text-success"></i>Enabled' : 
                '<i class="fa fa-circle-o fa-fw text-danger"></i>Disabled' ?>
            </td>
			<td><?= $item->business->trading_name; ?></td>
			<td><?= $item->location; ?></td>
			<!-- <td><?= $item->price_list; ?></td> -->
			<td class="text-center">
            <?php if ($ugroup->id == 5) : ?>
				<?= Html::anchor('admin/settings/cashier/profile/delete/'.$item->id, '<i class="fa fa-trash-o fa-fw fa-fw"></i>',
                                array('class' => 'text-muted del-btn', 'onclick' => "return confirm('Are you sure?')")); ?>
            <?php endif ?>
			</td>
		</tr>
<?php endforeach; ?>	
	</tbody>
</table>

<?php else: ?>
<p>No Cashier Profile.</p>

<?php endif; ?>
