<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

    <div class="form-group">
        <div class="col-md-6">
            <?= Form::label('Item name', 'item_name', array('class'=>'control-label')); ?>
            <?= Form::input('item_name', Input::post('item_name', isset($product_item) ? $product_item->item_name : ''), 
                            array('class' => 'col-md-4 form-control', 'autofocus' => true)); ?>
        </div>
        <div class="col-md-6">
            <?= Form::label('Description', 'description', array('class'=>'control-label')); ?>
            <?= Form::input('description', Input::post('description', isset($product_item) ? $product_item->description : ''), 
                            array('class' => 'col-md-4 form-control', 'autofocus' => true)); ?>
        </div>        
    </div>

    <div class="form-group">
        <div class="col-md-6">
            <?= Form::label('Item code', 'item_code', array('class'=>'control-label')); ?>
            <?= Form::input('item_code', Input::post('item_code', isset($product_item) ? $product_item->item_code : ''), 
                            array('class' => 'col-md-4 form-control')); ?>
        </div>
        <div class="col-md-6">
            <?= Form::label('Group', 'group_id', array('class'=>'control-label')); ?>
            <?= Form::select('group_id', Input::post('group_id', isset($product_item) ? $product_item->group_id : ''),
                            Model_Product_Group::listOptions(),
                            array('class' => 'form-control')); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3">
            <?= Form::label('Quantity', 'quantity', array('class'=>'control-label')); ?>
            <?= Form::input('quantity', Input::post('quantity', isset($product_item) ? $product_item->quantity : 
                            Model_Product_Item::getColumnDefault('quantity')), 
                            array('class' => 'col-md-4 form-control')); ?>
        </div>
        <div class="col-md-3">
            <?= Form::label('Min sales qty', 'min_sale_qty', array('class'=>'control-label')); ?>
            <?= Form::input('min_sale_qty', Input::post('min_sale_qty', isset($product_item) ? $product_item->min_sale_qty : 
                            Model_Product_Item::getColumnDefault('min_sale_qty')), 
                            array('class' => 'col-md-4 form-control')); ?>
        </div>
        <div class="col-md-3">
            <?= Form::label('Reorder level', 'reorder_level', array('class'=>'control-label')); ?>
            <?= Form::input('reorder_level', Input::post('reorder_level', isset($product_item) ? $product_item->reorder_level : 
                            Model_Product_Item::getColumnDefault('reorder_level')), 
                            array('class' => 'col-md-4 form-control')); ?>
        </div>
        <div class="col-md-3">
            <?= Form::label('Receiving qty', 'receiving_qty', array('class'=>'control-label')); ?>
            <?= Form::input('receiving_qty', Input::post('receiving_qty', isset($product_item) ? $product_item->receiving_qty : 
                            Model_Product_Item::getColumnDefault('receiving_qty')), 
                            array('class' => 'col-md-4 form-control')); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3">
            <?= Form::label('Cost price', 'cost_price', array('class'=>'control-label')); ?>
            <?= Form::input('cost_price', Input::post('cost_price', isset($product_item) ? $product_item->cost_price : ''), 
                            array('class' => 'col-md-4 form-control text-right')); ?>
        </div>        
        <div class="col-md-3">
            <?= Form::label('Unit price', 'unit_price', array('class'=>'control-label')); ?>
            <?= Form::input('unit_price', Input::post('unit_price', isset($product_item) ? $product_item->unit_price : ''), 
                            array('class' => 'col-md-4 form-control text-right')); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3">
            <?= Form::hidden('billable', Input::post('billable', isset($product_item) ? $product_item->billable : '0')); ?>
            <?= Form::checkbox('cb_billable', null, array('class' => 'cb-checked', 'data-input' => 'billable')); ?>
            <?= Form::label('Is billable', 'cb_billable', array('class'=>'control-label')); ?>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-3">
            <?= Form::hidden('enabled', Input::post('enabled', isset($product_item) ? $product_item->enabled : '1')); ?>
            <?= Form::checkbox('cb_enabled', null, array('class' => 'cb-checked', 'data-input' => 'enabled')); ?>
            <?= Form::label('Enabled', 'cb_enabled', array('class'=>'control-label')); ?>
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
