<h2>Viewing <span class='muted'>#<?= $product_item->id; ?></span></h2>

<p>
	<strong>Item:</strong>
	<?= $product_item->item; ?></p>
<p>
	<strong>Gl account id:</strong>
	<?= $product_item->gl_account_id; ?></p>
<p>
	<strong>Description:</strong>
	<?= $product_item->description; ?></p>
<p>
	<strong>Qty:</strong>
	<?= $product_item->qty; ?></p>
<p>
	<strong>Unit price:</strong>
	<?= $product_item->unit_price; ?></p>
<p>
	<strong>Discount percent:</strong>
	<?= $product_item->discount_percent; ?></p>

<?= Html::anchor('service/item/edit/'.$product_item->id, 'Edit'); ?> |
<?= Html::anchor('service/item', 'Back'); ?>