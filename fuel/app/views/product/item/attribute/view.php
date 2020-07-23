<h2>Viewing <span class='muted'>#<?= $product_item_attribute->id; ?></span></h2>

<p>
	<strong>Name:</strong>
<?= $product_item_attribute->name; ?></p>
<p>
	<strong>Description:</strong>
<?= $product_item_attribute->description; ?></p>
<p>
	<strong>Item id:</strong>
<?= $product_item_attribute->item_id; ?></p>

<?= Html::anchor('product/item/attribute/edit/'.$product_item_attribute->id, 'Edit'); ?> |
<?= Html::anchor('product/item/attribute', 'Back'); ?>