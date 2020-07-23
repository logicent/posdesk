<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Name', 'name', array('class'=>'control-label')); ?>
			<?= Form::input('name', Input::post('name', isset($location) ? $location->name : ''), 
							array('class' => 'col-md-4 form-control')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Description', 'description', array('class'=>'control-label')); ?>
			<?= Form::textarea('description', Input::post('description', isset($location) ? $location->description : ''), 
								array('class' => 'col-md-4 form-control', 'rows' => '5')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Branch', 'branch_id', array('class'=>'control-label')); ?>
			<?= Form::select('branch_id', Input::post('branch_id', isset($location) ? $location->branch_id : ''), 
							Model_Business::listOptions(),
							array('class' => 'col-md-4 form-control select-from-list')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::hidden('enabled', Input::post('enabled', isset($location) ? $location->enabled : '1')); ?>
			<?= Form::checkbox('cb_enabled', null, array('class' => 'cb-checked', 'data-input' => 'enabled')); ?>
			&nbsp;
			<?= Form::label('Enabled', 'cb_enabled', array('class'=>'control-label')); ?>
		</div>
	</div>

<?= Form::hidden('fdesk_user', Input::post('fdesk_user', isset($location) ? $location->fdesk_user : $uid)); ?>

<hr>
<div class="form-group">
    <div class="col-md-6">
        <?= Form::submit('submit', isset($location) ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
    </div>
</div>

<?= Form::close(); ?>

<?php 
if (isset($location)) :
    echo render('product/item/location/index', array('item_locations' => $location->item_locations)); 
endif ?>
