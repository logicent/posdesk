<h2>Editing <span class='text-muted'>Purchases invoice item</span></h2>
<br>

<?= render('purchases/invoice/item/_form'); ?>
<p>
	<?= Html::anchor('purchases/invoice/item/view/'.$purchases_invoice_item->id, 'View'); ?> |
	<?= Html::anchor('purchases/invoice/item', 'Back'); ?></p>
