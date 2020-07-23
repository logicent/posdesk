<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Item id', 'item_id', array('class'=>'control-label')); ?>
			<?= Form::input('item_id', Input::post('item_id', isset($item_location) ? $item_location->item_id : ''), 
							array('class' => 'col-md-4 form-control')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Location id', 'location_id', array('class'=>'control-label')); ?>
			<?= Form::input('location_id', Input::post('location_id', isset($item_location) ? $item_location->location_id : ''), 
							array('class' => 'col-md-4 form-control')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Quantity', 'quantity', array('class'=>'control-label')); ?>
			<?= Form::input('quantity', Input::post('quantity', isset($item_location) ? $item_location->quantity : ''), 
							array('class' => 'col-md-4 form-control')); ?>
		</div>
	</div>
</div>

<?= Form::hidden('fdesk_user', Input::post('fdesk_user', isset($item_location) ? $item_location->fdesk_user : $uid)); ?>
<hr>
<div class="form-group">
    <div class="col-md-6">
		<?= Form::submit('submit', isset($item_location) ? 'Update' : 'Create', 
						array('class' => 'btn btn-primary')); ?>
    </div>
</div>

<?= Form::close(); ?>