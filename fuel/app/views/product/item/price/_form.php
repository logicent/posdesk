<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

<div class="form-group">
	<div class="col-md-6">
		<?= Form::label('Item', 'item_id', array('class'=>'control-label')); ?>
		<?= Form::select('item_id', Input::post('item_id', isset($item_price) ? $item_price->item_id : ''), 
						Model_Product_Item::listOptions(),
						array('class' => 'col-md-4 form-control select-from-list')); ?>
	</div>
</div>
<div class="form-group">
	<div class="col-md-6">
		<?= Form::label('Price list', 'price_list_id', array('class'=>'control-label')); ?>
		<?= Form::select('price_list_id', Input::post('price_list_id', isset($item_price) ? $item_price->price_list_id : ''), 
						Model_Product_Price_List::listOptions(),
						array('class' => 'col-md-4 form-control select-from-list')); ?>
	</div>
</div>
<div class="form-group">
	<div class="col-md-6">
		<?= Form::label('Rate', 'price_list_rate', array('class'=>'control-label')); ?>
		<?= Form::input('price_list_rate', Input::post('price_list_rate', isset($item_price) ? $item_price->price_list_rate : ''), 
						array('class' => 'col-md-4 form-control')); ?>
	</div>
</div>

<hr>
<div class="form-group">
    <div class="col-md-6">
        <?= Form::submit('submit', isset($item_price) ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
    </div>
</div>

<?= Form::close(); ?>