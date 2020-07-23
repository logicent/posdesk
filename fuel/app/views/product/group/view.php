<h2>Viewing <span class='muted'>#<?= $product_group->id; ?></span></h2>

<p>
	<strong>Name:</strong>
<?= $product_group->name; ?></p>
<p>
	<strong>Code:</strong>
<?= $product_group->code; ?></p>
<p>
	<strong>Enabled:</strong>
<?= $product_group->enabled; ?></p>

<?= Html::anchor('product/group/edit/'.$product_group->id, 'Edit'); ?> |
<?= Html::anchor('product/group/', 'Back'); ?>