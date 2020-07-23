<h2>Viewing <span class='muted'>#<?= $product_item_price->id; ?></span></h2>

<p>
	<strong>Item id:</strong>
<?= $product_item_price->item_id; ?></p>
<p>
	<strong>Price list id:</strong>
<?= $product_item_price->price_list_id; ?></p>
<p>
	<strong>Fdesk user:</strong>
<?= $product_item_price->fdesk_user; ?></p>
<p>
	<strong>Price list rate:</strong>
<?= $product_item_price->price_list_rate; ?></p>

<?= Html::anchor('product/item/price/edit/'.$product_item_price->id, 'Edit'); ?> |
<?= Html::anchor('product/item/price', 'Back'); ?>