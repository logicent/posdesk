<div class="row">
	<div class="col-md-6">
        <h2>Listing <span class='text-muted'>Sales</span>&ensp;
        <span class="btn-group list-filters">
            <?= Html::anchor('sales/invoice', 
                            'All', array('class' => "btn btn-sm btn-default", 'data-status' => '')); ?>
            <?= Html::anchor('sales/invoice/?status=' . Model_Cashier_Invoice::INVOICE_STATUS_OPEN, 'Open', 
                            array('class' => 'btn btn-sm btn-default', 'data-status' => Model_Cashier_Invoice::INVOICE_STATUS_OPEN)); ?>
            <?= Html::anchor('sales/invoice/?status=' . Model_Cashier_Invoice::INVOICE_STATUS_CLOSED, 'Closed', 
                            array('class' => 'btn btn-sm btn-default', 'data-status' => Model_Cashier_Invoice::INVOICE_STATUS_CLOSED)); ?>
            <?= Html::anchor('sales/invoice/?status=' . Model_Cashier_Invoice::INVOICE_STATUS_CANCELED, 'Canceled', 
                            array('class' => 'btn btn-sm btn-default', 'data-status' => Model_Cashier_Invoice::INVOICE_STATUS_CANCELED)); ?>
		</span>
    </h2>
	</div>

	<div class="col-md-6 text-right">
        <br>
		<?= Html::anchor('sales/invoice/create', 'New', array('class' => 'btn btn-primary')); ?>
	</div>
</div>
<hr>

<?php if ($sales_invoices): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>Customer name</th>
			<th>Invoice no.</th>
			<th>Due date</th>
			<th class="text-right">Amount due</th>
			<th class="text-right">Balance due</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($sales_invoices as $item): ?>
		<tr>
            <td>
			<?php 
				if ($item->status != Model_Sales_Invoice::INVOICE_STATUS_OPEN) :
					$route = 'view/';
				else :
					$route = 'edit/';
				endif;
				echo Html::anchor('sales/invoice/' . $route. $item->id, ucwords($item->customer->customer_name), ['class' => 'clickable']) ?>
			</td>
			<td><?= $item->id; ?></td>
			<td><?= date('d-M-Y', strtotime($item->due_date)); ?></td>
			<td class="text-right"><?= number_format($item->amount_due, 2); ?></td>
			<td class="text-right"><span class="<?= $item->balance_due > 0 ? 'text-red' : '' ?>"><?= number_format($item->balance_due, 2); ?></span></td>
			<td class="text-center">
				<?php if ($ugroup->id == 5) : ?>
				<?= Html::anchor('sales/invoice/delete/'.$item->id, '<i class="fa fa-trash-o fa-fw"></i>', array('class' => 'del-btn', 'onclick' => "return confirm('Are you sure?')")); ?>
				<?php endif ?>
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<?php else: ?>
	<p>No Sales.</p>
<?php endif; ?>
