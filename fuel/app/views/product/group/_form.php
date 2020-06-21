<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Name', 'name', array('class'=>'control-label')); ?>
                <?= Form::input('name', Input::post('name', isset($product_group) ? $product_group->name : ''), 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Default Supplier', 'default_supplier', array('class'=>'control-label')); ?>
                <?= Form::select('default_supplier', Input::post('default_supplier', isset($product_group) ? $product_group->default_supplier : ''),
                                        Model_Supplier::listOptions(),
                                        array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::hidden('is_default', Input::post('is_default', isset($product_group) ? $product_group->is_default : '0')); ?>
                <?= Form::checkbox('cb_is_default', null, array('class' => 'cb-checked', 'data-input' => 'is_default')); ?>
                <?= Form::label('Is default', 'cb_is_default', array('class'=>'control-label')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::hidden('enabled', Input::post('enabled', isset($product_group) ? $product_group->enabled : '1')); ?>
                <?= Form::checkbox('cb_enabled', null, array('class' => 'cb-checked', 'data-input' => 'enabled')); ?>
                <?= Form::label('Enabled', 'cb_enabled', array('class'=>'control-label')); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Code', 'code', array('class'=>'control-label')); ?>
                <?= Form::input('code', Input::post('code', isset($product_group) ? $product_group->code : ''), 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Parent', 'parent_id', array('class'=>'control-label')); ?>
                <?= Form::select('parent_id', Input::post('parent_id', isset($product_group) ? $product_group->parent_id : ''),
                                        Model_Product_Group::listOptionsParentGroup(),
                                        array('class' => 'form-control')); ?>
            </div>
        </div>
    </div>
</div>

<?= Form::hidden('fdesk_user', Input::post('fdesk_user', isset($product_group) ? $product_group->fdesk_user : $uid)); ?>
<hr>
<div class="form-group">
    <div class="col-md-6">
        <?= Form::submit('submit', isset($product_group) ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
    </div>
</div>

<?= Form::close(); ?>