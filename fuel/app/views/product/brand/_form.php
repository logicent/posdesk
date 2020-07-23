<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

	<div class="form-group">
		<div class="col-md-6">
			<?= Form::label('Name', 'name', array('class'=>'control-label')); ?>
			<?= Form::input('name', Input::post('name', isset($product_brand) ? $product_brand->name : ''), array('class' => 'col-md-4 form-control')); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?= Form::hidden('enabled', Input::post('enabled', isset($product_brand) ? $product_brand->enabled : '1')); ?>
			<?= Form::checkbox('cb_enabled', null, array('class' => 'cb-checked', 'data-input' => 'enabled')); ?>
			&nbsp;
			<?= Form::label('Enabled', 'cb_enabled', array('class'=>'control-label')); ?>
		</div>
	</div>

<?= Form::hidden('fdesk_user', Input::post('fdesk_user', isset($product_brand) ? $product_brand->fdesk_user : $uid)); ?>
<hr>
<div class="form-group">
    <div class="col-md-6">
        <?= Form::submit('submit', isset($product_brand) ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
    </div>
</div>

<?= Form::close(); ?>