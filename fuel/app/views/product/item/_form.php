<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Item name', 'item_name', array('class'=>'control-label')); ?>
                <?= Form::input('item_name', Input::post('item_name', isset($product_item) ? $product_item->item_name : ''), 
                                array('class' => 'col-md-4 form-control', 'autofocus' => true)); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Item code', 'item_code', array('class'=>'control-label')); ?>
                <?= Form::input('item_code', Input::post('item_code', isset($product_item) ? $product_item->item_code : ''), 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Description', 'description', array('class'=>'control-label')); ?>
                <?= Form::textarea('description', Input::post('description', isset($product_item) ? $product_item->description : ''), 
                                    array('class' => 'col-md-4 form-control', 'rows' => 5)); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                <?= Form::hidden('is_sales_item', Input::post('is_sales_item', isset($product_item) ? $product_item->is_sales_item : '1')); ?>
                <?= Form::checkbox('cb_is_sales_item', null, array('class' => 'cb-checked', 'data-input' => 'is_sales_item')); ?>
                <?= Form::label('Is sales item', 'cb_is_sales_item', array('class'=>'control-label')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                <?= Form::hidden('enabled', Input::post('enabled', isset($product_item) ? $product_item->enabled : '1')); ?>
                <?= Form::checkbox('cb_enabled', null, array('class' => 'cb-checked', 'data-input' => 'enabled')); ?>
                <?= Form::label('Enabled', 'cb_enabled', array('class'=>'control-label')); ?>
            </div>
        </div>        
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Item group', 'group_id', array('class'=>'control-label')); ?>
                <?= Form::select('group_id', Input::post('group_id', isset($product_item) ? $product_item->group_id : ''),
                                Model_Product_Group::listOptions(),
                                array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <?= Form::label('Quantity', 'quantity', array('class'=>'control-label')); ?>
                <?= Form::input('quantity', Input::post('quantity', isset($product_item) ? $product_item->quantity : 
                                Model_Product_Item::getColumnDefault('quantity')), 
                                array('class' => 'col-md-4 form-control', 'readonly' => true)); ?>
            </div>
            <div class="col-md-6">
                <?= Form::label('Min order qty', 'min_order_qty', array('class'=>'control-label')); ?>
                <?= Form::input('min_order_qty', Input::post('min_order_qty', isset($product_item) ? $product_item->min_order_qty : 
                                Model_Product_Item::getColumnDefault('min_order_qty')), 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>            
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <?= Form::label('Cost price', 'cost_price', array('class'=>'control-label')); ?>
                <?= Form::input('cost_price', Input::post('cost_price', isset($product_item) ? $product_item->cost_price : '0'), 
                                array('class' => 'col-md-4 form-control text-right')); ?>
            </div>        
            <div class="col-md-6">
                <?= Form::label('Unit price', 'unit_price', array('class'=>'control-label')); ?>
                <?= Form::input('unit_price', Input::post('unit_price', isset($product_item) ? $product_item->unit_price : '0'), 
                                array('class' => 'col-md-4 form-control text-right')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
            <?= Form::label('Reorder level', 'reorder_level', array('class'=>'control-label')); ?>
                <?= Form::input('reorder_level', Input::post('reorder_level', isset($product_item) ? $product_item->reorder_level : 
                                Model_Product_Item::getColumnDefault('reorder_level')), 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>
            <div class="col-md-6">
                <?= Form::label('Tax rate', 'tax_rate', array('class'=>'control-label')); ?>
                <?= Form::input('tax_rate', Input::post('tax_rate', isset($product_item) ? $product_item->tax_rate : 
                                Model_Product_Item::getColumnDefault('tax_rate')), 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>            
        </div>
    </div>
</div>

<?= Form::hidden('fdesk_user', Input::post('fdesk_user', isset($product_item) ? $product_item->fdesk_user : $uid)); ?>
<hr>
<div class="form-group">
    <div class="col-md-3">
        <?= Form::submit('submit', isset($product_item) && !$product_item->is_new() ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
    </div>
    <div class="col-md-3">
<?php 
    if (isset($product_item) && !$product_item->is_new()): ?>
        <div class="pull-right btn-toolbar">
            <div class="btn-group">
                <a href="<?= Uri::create('product/item/create/'.$product_item->id); ?>" class="btn btn-default">Duplicate</a>
            </div>
        </div>
<?php 
    endif ?>
    </div>
</div>

<?= Form::close(); ?>
