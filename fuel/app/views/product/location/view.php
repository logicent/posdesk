<h2>Viewing <span class='muted'>#<?= $product_location->id; ?></span></h2>

<p>
	<strong>Name:</strong>
<?= $product_location->name; ?></p>
<p>
	<strong>Description:</strong>
<?= $product_location->description; ?></p>
<p>
	<strong>Enabled:</strong>
<?= $product_location->enabled; ?></p>
<p>
	<strong>Branch id:</strong>
<?= $product_location->branch_id; ?></p>
<p>
	<strong>Fdesk user:</strong>
<?= $product_location->fdesk_user; ?></p>

<?= Html::anchor('product/location/edit/'.$product_location->id, 'Edit'); ?> |
<?= Html::anchor('product/location', 'Back'); ?>