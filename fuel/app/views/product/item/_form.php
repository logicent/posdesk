<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

    <div class="form-group">
        <div class="col-md-6">
            <?= Form::label('Description', 'description', array('class'=>'control-label')); ?>
            <?= Form::input('description', Input::post('description', isset($product_item) ? $product_item->description : ''), 
                            array('class' => 'col-md-4 form-control', 'autofocus' => true)); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3">
            <?= Form::label('Group', 'group_id', array('class'=>'control-label')); ?>
            <?= Form::select('group_id', Input::post('group_id', isset($product_item) ? $product_item->group_id : ''),
                            array(), // Model_Product_Group::listOptions(),
                            array('class' => 'form-control')); ?>
        </div>

        <div class="col-md-3">
            <?= Form::label('Code', 'code', array('class'=>'control-label')); ?>
            <?= Form::input('code', Input::post('code', isset($product_item) ? $product_item->code : ''), 
                            array('class' => 'col-md-4 form-control')); ?>
        </div>        
    </div>

    <div class="form-group">
        <div class="col-md-3">
            <?= Form::label('Quantity', 'qty', array('class'=>'control-label')); ?>
            <?= Form::input('qty', Input::post('qty', isset($product_item) ? $product_item->qty : 
                            Model_Product_Item::getColumnDefault('qty')), 
                            array('class' => 'col-md-4 form-control')); ?>
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
            <?= Form::hidden('enabled', Input::post('enabled', isset($product_item) ? $product_item->enabled : '0')); ?>
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
                    <a href="<?= Uri::create('service/item/create/'.$product_item->id); ?>" class="btn btn-default">Duplicate</a>
                </div>
            </div>
    <?php 
        endif ?>
        </div>
    </div>

<?= Form::close(); ?>
