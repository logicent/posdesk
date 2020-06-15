<?php 
    $img_ph = "images/camera.gif";
    $img_src = '';
    if (isset($supplier)) :
        if ($supplier->ID_attachment) :
            $img_src = $supplier->ID_attachment;
        else :
            $img_src = "https://avatars.dicebear.com/v2/initials/{$supplier->supplier_name}.svg";
        endif;
    else :
        $img_src = $img_ph;
    endif ?>

<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off", "enctype"=>"multipart/form-data")); ?>

<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<div class="col-md-6">
				<?= Form::label('Full name', 'supplier_name', array('class'=>'control-label')); ?>
                <?= Form::input('supplier_name', Input::post('supplier_name', isset($supplier) ? $supplier->supplier_name : ''), 
                                                            array('class' => 'col-md-4 form-control')); ?>
			</div>
            
            <div class="col-md-3">
                <?= Form::label('Title of Courtesy', 'title_of_courtesy', array('class'=>'control-label')); ?>
                <?= Form::select('title_of_courtesy', Input::post('title_of_courtesy', isset($supplier) ? $supplier->title_of_courtesy : ''), 
                                Model_Supplier::$toc, 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>

            <div class="col-md-3">
                <?= Form::label('Sex', 'sex', array('class'=>'control-label')); ?>
                <?= Form::select('sex', Input::post('sex', isset($supplier) ? $supplier->sex : ''), Model_Supplier::$sex, 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>            
		</div>
<!--
            <div class="col-md-6">
				<?php // Form::label('Supplier group', 'supplier_group', array('class'=>'control-label')); ?>
                <?php // Form::select('supplier_group', Input::post('supplier_group', isset($supplier) ? $supplier->supplier_group : ''), 
                        //                                        Model_Supplier::listOptionsSupplierGroup(), 
                        //                                        array('class' => 'col-md-4 form-control')); ?>
			</div>
-->      
		<div class="form-group">
            <div class="col-md-6"> 
				<?= Form::label('Type', 'supplier_type', array('class'=>'control-label')); ?>
                <?= Form::select('supplier_type', Input::post('supplier_type', isset($supplier) ? $supplier->supplier_type : ''), 
                                Model_Supplier::listOptionsSupplierType(), 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>            
            <div class="col-md-6">
                <?= Form::label('Date of Birth', 'birth_date', array('class'=>'control-label')); ?>
                <!--<div class="input-group">-->
                    <?= Form::input('birth_date', Input::post('birth_date', isset($supplier) ? $supplier->birth_date : ''),
                                    array('class' => 'col-md-4 form-control datepicker', 'readonly' => true)); ?>
                    <!--
                    <span class="input-group-addon">
                        <i class="fa fa-calendar text-default"></i>
                    </span>
                </div>-->
            </div>
        </div>

		<div class="form-group">
            <div class="col-md-6">
				<?= Form::label('Email address', 'email_address', array('class'=>'control-label')); ?>
                <?= Form::input('email_address', Input::post('email_address', isset($supplier) ? $supplier->email_address : ''), 
                                                                array('class' => 'col-md-4 form-control')); ?>
			</div>        

            <div class="col-md-6">
				<?= Form::label('Mobile phone', 'mobile_phone', array('class'=>'control-label')); ?>
                <?= Form::input('mobile_phone', Input::post('mobile_phone', isset($supplier) ? $supplier->mobile_phone : ''), 
                                                                array('class' => 'col-md-4 form-control')); ?>
			</div>
		</div>

        <div class="form-group">
            <div class="col-md-6">
                <?= Form::label('Account manager', 'account_manager', array('class'=>'control-label')); ?>
                <?= Form::select('account_manager', Input::post('account_manager', isset($supplier) ? $supplier->account_manager : ''), 
                                Model_User::listOptions(), 
                                array('class' => 'col-md-4 form-control', 'id' => 'user_id')); ?>
            </div>
            
            <div class="col-md-6">
				<?= Form::label('Tax ID', 'tax_ID', array('class'=>'control-label')); ?>
                <?= Form::input('tax_ID', Input::post('tax_ID', isset($supplier) ? $supplier->tax_ID : ''), 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6">
                <?= Form::hidden('inactive', Input::post('inactive', isset($supplier) ? $supplier->inactive : '0')); ?>
                <?= Form::checkbox('cb_inactive', null, array('class' => 'cb-checked', 'data-input' => 'inactive')); ?>
                <?= Form::label('Inactive', 'cb_inactive', array('class'=>'control-label')); ?>
                <br>
                <?php // Form::hidden('is_internal_supplier', Input::post('is_internal_supplier', isset($supplier) ? $supplier->is_internal_supplier : '0')); ?>
                <?php // Form::checkbox('cb_is_internal_supplier', null, array('class' => 'cb-checked', 'data-input' => 'is_internal_supplier')); ?>
                <?php // Form::label('Is internal supplier', 'cb_is_internal_supplier', array('class'=>'control-label')); ?>                
            </div>

            <div class="col-md-6">
				<?= Form::label('Bank account', 'bank_account', array('class'=>'control-label')); ?>
                <?= Form::input('bank_account', Input::post('bank_account', isset($supplier) ? $supplier->bank_account : ''), 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>
        </div>

	</div><!--/.col-md-6-->

    <!-- Right Side -->
	<div class="col-md-4">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('ID preview', 'upload_img', array('class'=>'control-label')); ?>
                <div class="well text-center">
                    <?= Form::file('uploaded_file', array('class' => '', 'style' => 'display: none;')); ?>
                    <div class="img-wrapper">
                        <?= Html::img($img_src, 
                                array(
                                    'class'=>'upload-img', 
                                    'style' => 'max-width: 360px; max-height: 270px;'
                                )
                            ); ?>
                    </div>
                </div>
            </div>
        </div>

		<div class="form-group">
            <div class="col-md-12">
                <?= Form::label('ID path', 'ID_attachment', array('class'=>'control-label')); ?>
                <div class="input-group">
                    <?= Form::input('ID_attachment', Input::post('ID_attachment', isset($supplier) ? $supplier->ID_attachment : ''),
                                    array('id' => 'file_path', 'class' => 'col-md-4 form-control', 'readonly' => true)); ?>
                    <span class="input-group-addon">
                        <?= Html::anchor(Uri::create(false), '<i class="fa fa-plus-square-o"></i>', 
                                        array('id' => 'add_img', 'class' => 'text-info')) ?>
                    </span>
                <?php 
                    if (isset($supplier)) : ?>
                    <span class="input-group-addon">
                        <?= Html::anchor(Uri::create('supplier/remove_img/' . $supplier->id), '<i class="fa fa-trash-o"></i>',
                                        array('id' => 'del_img', 'class' => ' text-primary', 'data-ph' => $img_ph)) ?>
                    </span>
                <?php 
                    endif ?>
                </div>
            </div>
		</div>

		<div class="form-group">
            <div class="col-md-12">
				<?= Form::label('Remarks', 'remarks', array('class'=>'control-label')); ?>
                <?= Form::textarea('remarks', Input::post('remarks', isset($supplier) ? $supplier->remarks : ''), 
                                    array('class' => 'col-md-4 form-control', 'rows' => 5)); ?>
            </div>
		</div>
    </div><!--/.col-md-6-->
</div><!--/.row-->

<?= Form::hidden('fdesk_user', Input::post('fdesk_user', isset($supplier) ? $supplier->fdesk_user : $uid)); ?>

<hr>

<div class="form-group">
	<div class="col-md-6">
		<?= Form::submit('submit', isset($supplier) ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
		<?php //echo Form::submit('submit', "Save + New", array('class' => 'btn btn-success')); ?>
	</div>

	<div class="col-md-6">
	</div>
</div>

<?= Form::close(); ?>

<script>
    // see checkbox code in custom.js
	// Date range picker for birth_date
</script>
