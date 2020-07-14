<?= Form::open(array("class"=>"form-horizontal")); ?>

<?= Form::hidden('document_type', Input::post('document_type', isset($cashier_profile) ? $cashier_profile->document_type : 'Cashier Invoice')) ?>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<div class="col-md-12">
				<?= Form::hidden('enabled', Input::post('enabled', isset($cashier_profile) ? $cashier_profile->enabled : '1')); ?>
                <?= Form::checkbox('cb_enabled', null, array('class' => 'cb-checked', 'data-input' => 'enabled')); ?>
				&nbsp;
                <?= Form::label('Enabled', 'cb_enabled', array('class'=>'control-label')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<!-- <div class="form-group">
			<div class="col-md-12">
			<?= Form::label('Customer group', 'customer_group', array('class'=>'control-label')); ?>
				<?= Form::select('customer_group', Input::post('customer_group', isset($cashier_profile) ? $cashier_profile->customer_group : ''),
								Model_Customer::listOptionsCustomerGroup(),
								array('class' => 'col-md-4 form-control')); ?>
			</div>
		</div> -->
		<div class="form-group">
			<div class="col-md-12">
				<?= Form::label('Customer', 'customer_id', array('class'=>'control-label')); ?>
				<?= Form::select('customer_id', Input::post('customer_id', isset($cashier_profile) ? $cashier_profile->customer_id : ''), 
								Model_Customer::listOptions(),
								array('class' => 'col-md-4 form-control select-from-list', 'data-placeholder' => 'Select a customer')); ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<?= Form::hidden('show_sales_person', Input::post('show_sales_person', isset($cashier_profile) ? $cashier_profile->show_sales_person : '0')); ?>
                <?= Form::checkbox('cb_show_sales_person', null, array('class' => 'cb-checked', 'data-input' => 'show_sales_person')); ?>
				&nbsp;
                <?= Form::label('Show sales person', 'cb_show_sales_person', array('class'=>'control-label')); ?>
			</div>
			<div class="col-md-6">
				<?= Form::hidden('require_sales_person', Input::post('require_sales_person', isset($cashier_profile) ? $cashier_profile->require_sales_person : '0')); ?>
				&emsp;<?= Form::checkbox('cb_require_sales_person', null, 
							array(
								'class' => 'cb-checked', 
								'data-input' => 'require_sales_person'
							)); ?>
				&nbsp;
                <?= Form::label('Require sales person', 'cb_require_sales_person', array('class'=>'control-label')); ?>
			</div>
		</div>
		<!-- <div class="form-group">
			<div class="col-md-12">
				<?= Form::label('Price list', 'price_list', array('class'=>'control-label')); ?>
				<?= Form::select('price_list', Input::post('price_list', isset($cashier_profile) ? $cashier_profile->price_list : ''), 
								array(), // Model_Product_Price_List::list_options(),
								array('class' => 'col-md-4 form-control select-from-list', 'data-placeholder' => 'Select price list')); ?>
			</div>
		</div> -->
		<div class="form-group">
			<div class="col-md-12">
				<?= Form::hidden('allow_user_price_edit', Input::post('allow_user_price_edit', isset($cashier_profile) ? $cashier_profile->allow_user_price_edit : '1')); ?>
                <?= Form::checkbox('cb_allow_user_price_edit', null, array('class' => 'cb-checked', 'data-input' => 'allow_user_price_edit')); ?>
				&nbsp;
                <?= Form::label('Allow user to edit price', 'cb_allow_user_price_edit', array('class'=>'control-label')); ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<?= Form::hidden('show_discount', Input::post('show_discount', isset($cashier_profile) ? $cashier_profile->show_discount : '0')); ?>
                <?= Form::checkbox('cb_show_discount', null, array('class' => 'cb-checked', 'data-input' => 'show_discount')); ?>
				&nbsp;
                <?= Form::label('Show discount', 'cb_show_discount', array('class'=>'control-label')); ?>
			</div>
			<div class="col-md-6">
				<?= Form::hidden('allow_user_discount_edit', Input::post('allow_user_discount_edit', isset($cashier_profile) ? $cashier_profile->allow_user_discount_edit : '0')); ?>
                &emsp;<?= Form::checkbox('cb_allow_user_discount_edit', null, array('class' => 'cb-checked', 'data-input' => 'allow_user_discount_edit')); ?>
				&nbsp;
                <?= Form::label('Allow user to edit discount', 'cb_allow_user_discount_edit', array('class'=>'control-label')); ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<?= Form::hidden('show_shipping', Input::post('show_shipping', isset($cashier_profile) ? $cashier_profile->show_shipping : '0')); ?>
                <?= Form::checkbox('cb_show_shipping', null, array('class' => 'cb-checked', 'data-input' => 'show_shipping')); ?>
				&nbsp;
                <?= Form::label('Show shipping', 'cb_show_shipping', array('class'=>'control-label')); ?>
			</div>
			<div class="col-md-6">
				<?= Form::hidden('require_shipping', Input::post('require_shipping', isset($cashier_profile) ? $cashier_profile->require_shipping : '0')); ?>
                &emsp;<?= Form::checkbox('cb_require_shipping', null, array('class' => 'cb-checked', 'data-input' => 'require_shipping')); ?>
				&nbsp;
                <?= Form::label('Require shipping', 'cb_require_shipping', array('class'=>'control-label')); ?>
			</div>
		</div>
		<!-- <div class="form-group">
			<div class="col-md-12">
				<?= Form::label('Currency', 'currency', array('class'=>'control-label')); ?>
				<?= Form::select('currency', Input::post('currency', isset($cashier_profile) ? $cashier_profile->currency : ''), 
								array(),
								array('class' => 'col-md-4 form-control select-from-list', 'data-placeholder' => 'Select a currency')); ?>
			</div>
		</div> -->
		<!-- <div class="form-group">
			<div class="col-md-12">
				<?= Form::hidden('show_currency_symbol', Input::post('show_currency_symbol', isset($cashier_profile) ? $cashier_profile->show_currency_symbol : '0')); ?>
                <?= Form::checkbox('cb_show_currency_symbol', null, array('class' => 'cb-checked', 'data-input' => 'show_currency_symbol')); ?>
				&nbsp;
                <?= Form::label('Show currency symbol', 'cb_show_currency_symbol', array('class'=>'control-label')); ?>
			</div>
		</div> -->
	</div>
	<div class="col-md-6">	
		<!-- <div class="form-group">
			<div class="col-md-12">
				<?= Form::label('Document type', 'document_type', array('class'=>'control-label')); ?>
				<?= Form::input('document_type', Input::post('document_type', isset($cashier_profile) ? $cashier_profile->document_type : 'Cashier Invoice'), 
								array('class' => 'col-md-4 form-control', 'readonly' => true)); ?>
			</div>
		</div> -->
		<div class="form-group">
			<div class="col-md-12">
				<?= Form::label('Default sale type', 'default_sale_type', array('class'=>'control-label')); ?>
				<?= Form::select('default_sale_type', Input::post('default_sale_type', isset($cashier_profile) ? $cashier_profile->default_sale_type : 'Cash Sale'), 
								array(
									'Cash Sale' => 'Cash Sale',
									'Credit Sale' => 'Credit Sale',
									'Sales Return' => 'Sales Return'
								),
								array('class' => 'col-md-4 form-control')); ?>
			</div>
		</div>		
		<div class="form-group">
			<div class="col-md-12">
				<?= Form::hidden('hide_credit_sale', Input::post('hide_credit_sale', isset($cashier_profile) ? $cashier_profile->hide_credit_sale : '0')); ?>
                <?= Form::checkbox('cb_hide_credit_sale', null, array('class' => 'cb-checked', 'data-input' => 'hide_credit_sale')); ?>
				&nbsp;
                <?= Form::label('Hide credit sale', 'cb_hide_credit_sale', array('class'=>'control-label')); ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<?= Form::hidden('require_sales_return_reason', Input::post('require_sales_return_reason', isset($cashier_profile) ? $cashier_profile->require_sales_return_reason : '0')); ?>
				<?= Form::checkbox('cb_require_sales_return_reason', null, 
							array(
								'class' => 'cb-checked', 
								'data-input' => 'require_sales_return_reason'
							)); ?>
				&nbsp;
                <?= Form::label('Require reason for sales return', 'cb_require_sales_return_reason', array('class'=>'control-label')); ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<?= Form::label('Branch', 'branch', array('class'=>'control-label')); ?>
				<?= Form::select('branch', Input::post('branch', isset($cashier_profile) ? $cashier_profile->branch : ''), 
								Model_Business::listOptions(),
								array('class' => 'col-md-4 form-control select-from-list', 'data-placeholder' => 'Select a branch')); ?>
			</div>
		</div>
		<!-- <div class="form-group">
			<div class="col-md-12">
				<?= Form::label('Location', 'location', array('class'=>'control-label')); ?>
				<?= Form::select('location', Input::post('location', isset($cashier_profile) ? $cashier_profile->location : ''), 
								array(), // Model_Stock_Location::listOptions(),
								array('class' => 'col-md-4 form-control select-from-list', 'data-placeholder' => 'Select a location')); ?>
			</div>
		</div> -->
		<div class="form-group">
			<div class="col-md-12">
				<?= Form::label('Item group', 'item_group', array('class'=>'control-label')); ?>
				<?= Form::select('item_group', Input::post('item_group', isset($cashier_profile) ? $cashier_profile->item_group : ''), 
								Model_Product_Group::listOptions(),
								array('class' => 'col-md-4 form-control select-from-list', 'data-placeholder' => 'Select item group')); ?>
			</div>
		</div>
		<!-- <div class="form-group">
			<div class="col-md-12">
				<?= Form::hidden('show_qty_in_stock', Input::post('show_qty_in_stock', isset($cashier_profile) ? $cashier_profile->show_qty_in_stock : '1')); ?>
                <?= Form::checkbox('cb_show_qty_in_stock', null, array('class' => 'cb-checked', 'data-input' => 'show_qty_in_stock')); ?>
				&nbsp;
                <?= Form::label('Show quantity in stock', 'cb_show_qty_in_stock', array('class'=>'control-label')); ?>
			</div>
		</div> -->
		<!-- <div class="form-group">
			<div class="col-md-12">
				<?= Form::hidden('allow_user_item_delete', Input::post('allow_user_item_delete', isset($cashier_profile) ? $cashier_profile->allow_user_item_delete : '1')); ?>
                <?= Form::checkbox('cb_allow_user_item_delete', null, array('class' => 'cb-checked', 'data-input' => 'allow_user_item_delete')); ?>
				&nbsp;
                <?= Form::label('Allow user to delete item', 'cb_allow_user_item_delete', array('class'=>'control-label')); ?>
			</div>
		</div> -->
		<!-- <div class="form-group">
			<div class="col-md-12">
				<?= Form::hidden('update_stock', Input::post('update_stock', isset($cashier_profile) ? $cashier_profile->update_stock : '1')); ?>
                <?= Form::checkbox('cb_update_stock', null, array('class' => 'cb-checked', 'data-input' => 'update_stock')); ?>
				&nbsp;
                <?= Form::label('Update stock', 'cb_update_stock', array('class'=>'control-label')); ?>
			</div>
		</div> -->
	</div>	
</div>

<?= Form::hidden('fdesk_user', Input::post('fdesk_user', isset($cashier_profile) ? $cashier_profile->fdesk_user : $uid)); ?>

<hr>

<div class="form-group">
	<div class="col-md-12">
		<?= Form::submit('submit', isset($cashier_profile) ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
	</div>
	<div class="col-md-12">
	</div>
</div>

<?= Form::close(); ?>

<script>
	if ($('#form_show_sales_person').val() == '1') {
		$('#form_cb_require_sales_person').attr('disabled', false);
	}
	else {
		$('#form_cb_require_sales_person').attr('disabled', true);
	}
	// $('#form_cb_show_sales_person').on('click', function () {
	// 	if ($(this).prop('checked')) {
	// 		$('#form_cb_require_sales_person').attr('disabled', false);
	// 	}
	// }
	if ($('#form_show_discount').val() == '1') {
		$('#form_cb_allow_user_discount_edit').attr('disabled', false);
	}
	else {
		$('#form_cb_allow_user_discount_edit').attr('disabled', true);
	}
	
	if ($('#form_show_shipping').val() == '1') {
		$('#form_cb_require_shipping').attr('disabled', false);
	}
	else {
		$('#form_cb_require_shipping').attr('disabled', true);
	}
</script>