<h2>Viewing <span class='muted'>#<?php echo $product_group->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $product_group->name; ?></p>
<p>
	<strong>Code:</strong>
	<?php echo $product_group->code; ?></p>
<p>
	<strong>Enabled:</strong>
	<?php echo $product_group->enabled; ?></p>

<?php echo Html::anchor('product/group/edit/'.$product_group->id, 'Edit'); ?> |
<?php echo Html::anchor('product/group/', 'Back'); ?>