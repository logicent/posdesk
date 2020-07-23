<h2>Viewing <span class='muted'>#<?= $product_price_list->id; ?></span></h2>

<p>
	<strong>Name:</strong>
<?= $product_price_list->name; ?></p>
<p>
	<strong>Description:</strong>
<?= $product_price_list->description; ?></p>
<p>
	<strong>Enabled:</strong>
<?= $product_price_list->enabled; ?></p>
<p>
	<strong>Currency:</strong>
<?= $product_price_list->currency; ?></p>
<p>
	<strong>Fdesk user:</strong>
<?= $product_price_list->fdesk_user; ?></p>

<?= Html::anchor('product/price/list/edit/'.$product_price_list->id, 'Edit'); ?> |
<?= Html::anchor('product/price/list', 'Back'); ?>