<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Name', 'name', array('class'=>'control-label')); ?>
			<?= Form::input('name', Input::post('name', isset($price_list) ? $price_list->name : ''), 
							array('class' => 'col-md-4 form-control')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Description', 'description', array('class'=>'control-label')); ?>
			<?= Form::textarea('description', Input::post('description', isset($price_list) ? $price_list->description : ''), 
							array('class' => 'col-md-4 form-control', 'rows' => 4)); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Currency', 'currency', array('class'=>'control-label')); ?>
			<?= Form::select('currency', Input::post('currency', isset($price_list) ? $price_list->currency : ''), 
							array('KES' => 'KES'),
							array('class' => 'col-md-4 form-control select-from-list')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Type', 'module', array('class'=>'control-label')); ?>
			<?= Form::select('module', Input::post('module', isset($price_list) ? $price_list->module : ''), 
							array(
								'Selling' => 'Selling', 
								'Buying' => 'Buying'
							),
							array('class' => 'col-md-4 form-control select-from-list')); ?>
		</div>
	</div>	
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::hidden('enabled', Input::post('enabled', isset($price_list) ? $price_list->enabled : '1')); ?>
			<?= Form::checkbox('cb_enabled', null, array('class' => 'cb-checked', 'data-input' => 'enabled')); ?>
			&nbsp;
			<?= Form::label('Enabled', 'cb_enabled', array('class'=>'control-label')); ?>
		</div>
	</div>

<?= Form::hidden('fdesk_user', Input::post('fdesk_user', isset($price_list) ? $price_list->fdesk_user : $uid)); ?>
<hr>
<div class="form-group">
    <div class="col-md-3">
		<?= Form::submit('submit', isset($price_list) && !$price_list->is_new() ? 'Update' : 'Create', 
						array('class' => 'btn btn-primary')); ?>
	</div>
</div>

<?= Form::close(); ?>

<?php 
if (isset($price_list)) :
    echo render('product/item/price/index', array('item_prices' => $price_list->item_prices)); 
endif ?>
