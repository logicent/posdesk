<?php echo Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

<div class="row form-group">
    <div class="col-md-6">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Prefix', 'code', array('class'=>'control-label')); ?>
                <?= Form::input('code', Input::post('code', isset($serial) ? $serial->code : ''),
                                array('class' => 'col-md-6 form-control', 'autofocus' => true)); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Description', 'name', array('class'=>'control-label')); ?>
                <?= Form::input('name', Input::post('name', isset($serial) ? $serial->name : ''),
                                array('class' => 'col-md-6 form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <?= Form::hidden('enabled', Input::post('enabled', isset($serial) ? $serial->enabled : '1')); ?>
                <?= Form::checkbox('cb_enabled', null, array('class' => 'cb-checked', 'data-input' => 'enabled')); ?>
                <?= Form::label('Enabled', 'cb_enabled', array('class'=>'control-label')); ?>
            </div>
        </div>                
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Start', 'start', array('class'=>'control-label')); ?>
                <?= Form::input('start', Input::post('start', isset($serial) ? $serial->start : ''),
                                array('class' => 'col-md-6 form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Next', 'next', array('class'=>'control-label')); ?>
                <?= Form::input('next', Input::post('next', isset($serial) ? $serial->next : ''),
                                array('class' => 'col-md-6 form-control')); ?>
            </div>
        </div>
    </div>
</div>

<?= Form::hidden('fdesk_user', Input::post('fdesk_user', isset($serial) ? $serial->fdesk_user : $uid)); ?>
    
<hr>

<div class="form-group">
    <div class="col-md-2">
        <?= Form::submit('submit', isset($serial) ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
    </div>
</div>

<?php echo Form::close(); ?>

<script>
</script>