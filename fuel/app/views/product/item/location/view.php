<h2>Viewing <span class='muted'>#<?= $product_item_location->id; ?></span></h2>

<p>
	<strong>Item id:</strong>
<?= $product_item_location->item_id; ?></p>
<p>
	<strong>Location id:</strong>
<?= $product_item_location->location_id; ?></p>
<p>
	<strong>Quantity:</strong>
<?= $product_item_location->quantity; ?></p>

<?= Html::anchor('product/item/location/edit/'.$product_item_location->id, 'Edit'); ?> |
<?= Html::anchor('product/item/location', 'Back'); ?>