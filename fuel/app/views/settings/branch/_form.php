<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off", "enctype"=>"multipart/form-data")); ?>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Business name', 'business_name', array('class'=>'control-label')); ?>
                <?= Form::input('business_name', Input::post('business_name', isset($branch) ? $branch->business_name : ''),
                                array('class' => 'col-md-4 form-control', 'autofocus' => true)); ?>
                <span id="helpBlock" class="help-block text-muted small">Registered name used in legal documents</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Physical address', 'address', array('class'=>'control-label')); ?>
                <?= Form::textarea('address', Input::post('address', isset($branch) ? $branch->address : ''),
                                    array('class' => 'col-md-4 form-control', 'rows' => 5)); ?>
            </div>
        </div>
		<div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Business type', 'business_type', array('class'=>'control-label')); ?>
                <?= Form::select('business_type', Input::post('business_type', isset($branch) ? $branch->business_type : ''), 
                                Model_Business::listOptionsType(), 
                                array('class' => 'col-md-4 form-control')); ?>
    		</div>
        </div>
		<div class="form-group">
			<div class="col-md-3">
				<?= Form::hidden('is_default', Input::post('is_default', isset($branch) ? $branch->is_default : '0')); ?>
				<?= Form::hidden('inactive', Input::post('inactive', isset($branch) ? $branch->inactive : '0')); ?>
				<?= Form::checkbox('cb_inactive', null, array('class' => 'cb-checked', 'data-input' => 'inactive')); ?>
				<?= Form::label('Inactive', 'cb_inactive', array('class'=>'control-label')); ?>
			</div>
		</div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Trading name', 'trading_name', array('class'=>'control-label')); ?>
                <?= Form::input('trading_name', Input::post('trading_name', isset($branch) ? $branch->trading_name : ''),
                                array('class' => 'col-md-4 form-control')); ?>
                <span id="helpBlock" class="help-block text-muted small">Brand name used in marketing and promotions</span>
            </div>
        </div>        
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Email address(es)', 'email_address', array('class'=>'control-label')); ?>
                <?= Form::input('email_address', Input::post('email_address', isset($branch) ? $branch->email_address : ''),
                                array(
                                    'class' => 'col-md-4 form-control', 
                                    'placeholder'=>'info@example.com, sales@example.com'
                                )); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Phone number(s)', 'phone_number', array('class'=>'control-label')); ?>
                <?= Form::input('phone_number', Input::post('phone_number', isset($branch) ? $branch->phone_number : ''),
                                array(
                                    'class' => 'col-md-4 form-control', 
                                    'placeholder'=>'020-123 4567, 0712 345 678'
                                )) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <?= Form::label('Tax identifier', 'tax_identifier', array('class'=>'control-label')); ?>
                <?= Form::input('tax_identifier', Input::post('tax_identifier', isset($branch) ? $branch->tax_identifier : ''),
                                array('class' => 'col-md-4 form-control')); ?>
            </div>
            <div class="col-md-6">
                <?= Form::label('Currency symbol', 'currency_symbol', array('class'=>'control-label')); ?>
                <?= Form::select('currency_symbol', Input::post('currency_symbol', isset($branch) ? $branch->currency_symbol : ''), 
                                Model_Business::listOptionsCurrency(), 
                                array('class' => 'col-md-4 form-control')); ?>
            </div>
		</div>        
    </div>
</div>
<div class="clearfix"></div>
<hr>
<div class="form-group">
    <div class="col-md-6">
    <?= Form::submit('submit', isset($branch) ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
    </div>
</div>
<?= Form::close(); ?>