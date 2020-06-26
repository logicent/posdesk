<!-- <h2>New <span class='text-muted'>Sale</span></h2> -->
<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>
<div class="row page-header">
    <div class="col-md-8">
        <?= Form::label('Find or Scan', 'item_search', array('class'=>'control-label')); ?>
        <?= Form::select('item_search', Input::post('item_search', ''), 
                        Model_Product_Item::listOptions(),
                        array(
                            'class' => 'col-md-4 form-control select-from-list', 
                            'id' => 'item_search',
                            // 'placeholder' => 'Scan or search for item...'
                        )); ?>
    </div>
    <!-- <div class="col-md-2">
        <?= Form::label('Item Group', 'item_group', array('class'=>'control-label')); ?>
        <?= Form::select('item_group', Input::post('item_group', isset($pos_profile) ? $pos_profile->item_group : ''), 
                        Model_Product_Group::listOptions(), 
                        array(
                            'class' => 'col-md-4 form-control select-from-list',
                            'id' => 'item_group'
                        )); ?>
    </div> -->
    <!-- <div class="col-md-2">
        <div class="btn-toolbar" role="toolbar" aria-label="...">
            <div id="item_cart_view" class="btn-group btn-group-justified" role="group" aria-label="...">
                <?= Html::anchor('#show-list', '<i class="fa fa-fw fa-lg fa-list"></i>', array('class' => 'text-muted btn btn-default', 'title' => 'List')) ?>
                <?= Html::anchor('#show-grid', '<i class="fa fa-fw fa-lg fa-table"></i>', array('class' => 'text-muted btn btn-default', 'title' => 'Grid')) ?>
                <?= Html::anchor('#lock-user', '<i class="fa fa-fw fa-lg fa-lock"></i>', array('class' => 'text-muted btn btn-default', 'title' => 'Lock')) ?>
            </div>
        </div>
    </div> -->
    <div class="col-md-4">
        <?= Form::label('Customer', 'customer_id', array('class'=>'control-label')); ?>
        <?= Form::select('customer_id', Input::post('customer_id', $pos_invoice->customer_id), 
                        Model_Customer::listOptions(), 
                        array('class' => 'col-md-4 form-control select-from-list')); ?>
        <!-- <?= Form::label('Shipping Address', 'shipping_address', array('class'=>'control-label')); ?>
        <?= Form::textarea('shipping_address', Input::post('shipping_address', $pos_invoice->shipping_address), 
                            array('class' => 'col-md-4 form-control', 'style' => 'min-height: 60px', 'readonly' => true)); ?> -->
    </div>
</div>
<div class="row">
    <!-- Detail form -->
    <div class="col-md-8">
        <div id="bills" class="">
            <?php html_tag('label', array('class' => 'control-label'), ''); ?>
            <?= render('cashier/invoice/item/index', array('pos_invoice_items' => $pos_invoice_item)); ?>
        </div>
    </div>
    <!-- Master form -->
    <div class="col-md-4">
        <?= Form::hidden('id', Input::post('id', $pos_invoice->id )); ?>
        <?= Form::hidden('customer_name', Input::post('customer_name', $pos_invoice->customer_name)); ?>
        <?= Form::hidden('status', Input::post('status', Model_Cashier_Invoice::INVOICE_STATUS_OPEN)); ?>
        <?= Form::hidden('paid_status', Input::post('paid_status', $pos_invoice->paid_status)); ?>
        <?= Form::hidden('issue_date', Input::post('issue_date', date('Y-m-d'))); ?>
        <?= Form::hidden('due_date', Input::post('due_date',  date('Y-m-d'))); ?>
        <?= Form::hidden('fdesk_user', Input::post('fdesk_user', $uid)); ?>
        <?= Form::hidden('branch_id', Input::post('branch_id', $business->id)); ?>

        <!-- <div class="form-group">
            <div class="col-md-12">
                <div class="btn-group btn-group-justified">
                <?= Html::anchor('#cash-sale', '<i class="fa fa-fw fa-money"></i> Split', array('class' => 'text-muted btn btn-default')) ?>
                <?= Html::anchor('#credit-sale', '<i class="fa fa-fw fa-card"></i> Split', array('class' => 'text-muted btn btn-default')) ?>
                <?= Html::anchor('#hold', '<i class="fa fa-fw fa-pause"></i> Hold', array('class' => 'text-muted btn btn-default')) ?>
                <?= Html::anchor('#split', '<i class="fa fa-fw fa-unlink"></i> Split', array('class' => 'text-muted btn btn-default')) ?>
                <?= Html::anchor('#cancel', '<i class="fa fa-fw fa-lg fa-close"></i> Cancel', array('class' => 'text-muted btn btn-default')) ?>
                </div>
            </div>
        </div> -->

        <?= render('cashier/invoice/sale_total'); ?>

        <div class="form-group">
            <div class="col-md-12">
                <!-- trigger suspend via F9 -->
                <?php html_tag('button', array('class' => 'btn btn-success', 'data-bind' => 'click: save'), 'Save') ?>
                <!-- trigger submit via F10 -->
                <!-- Pay Now assumes Cash Sale Customer -->
                <!-- Show no. of items in button float:left i.e. in place of icon -->
                <?= Form::submit('submit', 'Pay&ensp;Now', 
                                array('class' => 'btn btn-primary btn-block', 'style' => 'font-size: 125%; font-weight: 500')); ?>
                <!-- or -->
                <!-- Pay Later requires actual Customer (not Cash Sale) -->
                <!-- trigger submit without payment via F8 -->
                <?php Html::anchor('cashier/payment/later', 'Pay&ensp;Later', 
                                array('class' => 'btn btn-info btn-block', 'style' => 'font-size: 125%; font-weight: 500')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Notes', 'notes', array('class'=>'control-label')); ?>
                <?= Form::textarea('notes', Input::post('notes', $pos_invoice->notes), 
                                    array('class' => 'col-md-4 form-control', 'style' => 'min-height: 60px')); ?>
            </div>
        </div>
    </div>
</div>

<?= Form::close(); ?>

<script>
$('#form_amount_paid').on('change', 
    function(e) {
        if ($(this).val() == '')
            return false;

        amountDue = $('#form_amount_due').val();
        amountPaid = $(this).val(); // Amount Tendered
        changeDue = amountPaid - amountDue;
        $('#sale_change_due').text(changeDue.toFixed(2));
        $('#form_change_due').val(changeDue.toFixed(2));
        // balanceDue = amountDue - amountPaid;
        // $('#form_balance_due').val(balanceDue.toFixed(2));
    });
</script>