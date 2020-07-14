<?php 
    $img_ph = "images/camera.gif";
    $img_src = '';
    if (isset($product_item)) :
        if ($product_item->image_path) :
            $img_src = $product_item->image_path;
        else :
            $img_src = "https://avatars.dicebear.com/v2/initials/{$product_item->item_name}.svg";
        endif;
    else :
        $img_src = $img_ph;
    endif ?>

<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::hidden('enabled', Input::post('enabled', isset($product_item) ? $product_item->enabled : '1')); ?>
                <?= Form::checkbox('cb_enabled', null, array('class' => 'cb-checked', 'data-input' => 'enabled')); ?>
                &nbsp;
                <?= Form::label('Enabled', 'cb_enabled', array('class'=>'control-label')); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
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
            <div class="col-md-12">
                <?= Form::hidden('is_sales_item', Input::post('is_sales_item', isset($product_item) ? $product_item->is_sales_item : '1')); ?>
                <?= Form::checkbox('cb_is_sales_item', null, array('class' => 'cb-checked', 'data-input' => 'is_sales_item')); ?>
                &nbsp;
                <?= Form::label('Is sales item', 'cb_is_sales_item', array('class'=>'control-label')); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
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
	<div class="col-md-offset-1 col-md-3">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Image preview', 'upload_img', array('class'=>'control-label')); ?>
                <div class="well text-center">
                    <?= Form::file('uploaded_file', array('class' => '', 'style' => 'display: none;')); ?>
                    <div class="img-wrapper" style="height: 198px;">
                        <?= Html::img($img_src, 
                                array(
                                    'class'=>'upload-img', 
                                    'style' => 'max-width: 160px; height: 160px;'
                                )
                            ); ?>
                    </div>
                </div>
            </div>
        </div>
		<div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Image path', 'image_path', array('class'=>'control-label')); ?>
                <div class="input-group">
                    <?= Form::input('image_path', Input::post('image_path', isset($product_item) ? $product_item->image_path : ''),
                                    array('id' => 'file_path', 'class' => 'col-md-4 form-control', 'readonly' => true)); ?>
                    <span class="input-group-addon">
                        <?= Html::anchor(Uri::create(false), '<i class="fa fa-plus-square-o"></i>', 
                                        array('id' => 'add_img', 'class' => 'text-info')) ?>
                    </span>
                <?php 
                    if (isset($product_item)) : ?>
                    <span class="input-group-addon">
                        <?= Html::anchor(Uri::create('product/item/remove_img/' . $product_item->id), '<i class="fa fa-trash-o"></i>',
                                        array('id' => 'del_img', 'class' => ' text-primary', 'data-ph' => $img_ph)) ?>
                    </span>
                <?php 
                    endif ?>
                </div>
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
