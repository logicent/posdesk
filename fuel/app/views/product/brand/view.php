<h2>Viewing <span class='muted'>#<?= $product_brand->id; ?></span></h2>

<p>
	<strong>Name:</strong>
<?= $product_brand->name; ?></p>
<p>
	<strong>Enabled:</strong>
<?= $product_brand->enabled; ?></p>
<p>
	<strong>Fdesk user:</strong>
<?= $product_brand->fdesk_user; ?></p>

<?= Html::anchor('product/brand/edit/'.$product_brand->id, 'Edit'); ?> |
<?= Html::anchor('product/brand', 'Back'); ?>