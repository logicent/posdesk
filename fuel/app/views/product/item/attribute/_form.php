<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Name', 'name', array('class'=>'control-label')); ?>
			<?= Form::input('name', Input::post('name', isset($item_attribute) ? $item_attribute->name : ''), 
							array('class' => 'col-md-4 form-control')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Description', 'description', array('class'=>'control-label')); ?>
			<?= Form::input('description', Input::post('description', isset($item_attribute) ? $item_attribute->description : ''), 
							array('class' => 'col-md-4 form-control')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Item', 'item_id', array('class'=>'control-label')); ?>
			<?= Form::input('item_id', Input::post('item_id', isset($item_attribute) ? $item_attribute->item_id : ''), 
							array('class' => 'col-md-4 form-control')); ?>
		</div>
	</div>

<hr>

<div class="form-group">
    <div class="col-md-6">
        <?= Form::submit('submit', isset($item_attribute) ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
    </div>
</div>

<?= Form::close(); ?>