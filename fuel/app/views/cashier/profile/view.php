<h2>Viewing <span class='muted'>#<?php echo $cashier_profile->id; ?></span></h2>

<p>
	<strong>Enabled:</strong>
	<?php echo $cashier_profile->enabled; ?></p>
<p>
	<strong>Document type:</strong>
	<?php echo $cashier_profile->document_type; ?></p>
<p>
	<strong>Customer:</strong>
	<?php echo $cashier_profile->customer; ?></p>
<p>
	<strong>Branch:</strong>
	<?php echo $cashier_profile->branch; ?></p>
<p>
	<strong>Location:</strong>
	<?php echo $cashier_profile->location; ?></p>
<p>
	<strong>Update stock:</strong>
	<?php echo $cashier_profile->update_stock; ?></p>
<p>
	<strong>Allow user item delete:</strong>
	<?php echo $cashier_profile->allow_user_item_delete; ?></p>
<p>
	<strong>Allow user price edit:</strong>
	<?php echo $cashier_profile->allow_user_price_edit; ?></p>
<p>
	<strong>Allow user discount edit:</strong>
	<?php echo $cashier_profile->allow_user_discount_edit; ?></p>
<p>
	<strong>Display items in stock:</strong>
	<?php echo $cashier_profile->display_items_in_stock; ?></p>
<p>
	<strong>Item group:</strong>
	<?php echo $cashier_profile->item_group; ?></p>
<p>
	<strong>Customer group:</strong>
	<?php echo $cashier_profile->customer_group; ?></p>
<p>
	<strong>Price list:</strong>
	<?php echo $cashier_profile->price_list; ?></p>
<p>
	<strong>Currency:</strong>
	<?php echo $cashier_profile->currency; ?></p>
<p>
	<strong>Show currency symbol:</strong>
	<?php echo $cashier_profile->show_currency_symbol; ?></p>

<?php echo Html::anchor('cashier/profile/edit/'.$cashier_profile->id, 'Edit'); ?> |
<?php echo Html::anchor('cashier/profile', 'Back'); ?>