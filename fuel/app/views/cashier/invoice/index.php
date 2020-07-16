<!-- <h2>New <span class='text-muted'>Sale</span></h2> -->
<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <div class="col-md-8">
                <?= Form::label('Item', 'item_search', array('class'=>'control-label')); ?>
                <?= Form::select('item_search', Input::post('item_search', ''), 
                                Model_Product_Item::listSaleItems($pos_profile->item_group),
                                array(
                                    'class' => 'col-md-4 form-control search-for-item', 
                                    'id' => 'item_search',
                                )); ?>
            </div>
            <div class="col-md-4">
                <?= Form::label('Item Group', 'item_group', array('class'=>'control-label')); ?>
                <?= Form::select('item_group', Input::post('item_group', $pos_profile->item_group), 
                                Model_Product_Group::listOptions(), 
                                array(
                                    'class' => 'col-md-4 form-control select-from-list text-required',
                                    'id' => 'item_group'
                                )); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                <div class="btn-toolbar" role="toolbar" aria-label="...">
                    <div id="item_view" class="btn-group" role="group" aria-label="...">
                        <?= Html::anchor('#list', '<i class="fa fa-fw fa-th-list"></i>', 
                                        array(
                                            'class' => 'text-muted btn btn-default', 
                                            'title' => 'List', 
                                            'id' => 'item_list',
                                            'data-toggle' => 'tab'
                                        )) ?>
                        <?= Html::anchor('#grid', '<i class="fa fa-fw fa-th-large"></i>', 
                                        array(
                                            'class' => 'text-muted btn btn-default', 
                                            'title' => 'Grid', 
                                            'id' => 'item_grid',
                                            'data-toggle' => 'tab'
                                        )) ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Detail form -->
        <div class="form-group">
            <div class="col-md-12">
                <div id="cart_tabs" class="tab-content">
                    <?= render('cashier/invoice/item/index') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Customer', 'customer_id', array('class'=>'control-label')); ?>
                <div class="input-group">
                    <?= Form::select('customer_id', Input::post('customer_id', $pos_invoice->customer_id), 
                                    Model_Customer::listOptions(), 
                                    array('class' => 'col-md-4 form-control select-from-list')); ?>
                    <span class="input-group-btn">
                        <?= Html::anchor(null, '<i class="fa fa-fw fa-user-o"></i>', 
                                        array('id' => 'add_customer', 'class' => 'text-muted btn btn-default', 'style' => 'padding: 8px 10px')) ?>
                    </span>
                </div><!-- /.input-group -->
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="btn-group btn-group-justified" role="group">
                    <div class="btn-group" role="group">
                        <a href="#" class="text-muted btn btn-default dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Sale Type&ensp;<span class="fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="disabled"><?= Html::anchor(null, 'Cash Sale', array('id' => 'cash_sale')) ?></li>
                        <?php
                        if ( (bool) $pos_profile->hide_credit_sale === false ) : ?>
                            <li><?= Html::anchor(null, 'Credit Sale', array('id' => 'credit_sale')) ?></li>
                        <?php 
                        endif ?>
                            <li role="separator" class="divider"></li>
                            <li><?= Html::anchor(null, 'Sales Return', array('id' => 'sales_return')) ?></li>
                        </ul>
                    </div>
                    <?= Html::anchor(null, 'Hold / Cont.',
                            // Model_Cashier_Invoice::count_sales_on_hold() or count_draft_sales()
                            //  . '&ensp;' . html_tag('span', array('class' => 'text-primary'), '(1)'), 
                            array('class' => 'text-muted btn btn-default', 'id' => 'hold_sale')) ?>
                    <?= Html::anchor(null, 'Cancel', array('class' => 'text-muted btn btn-default', 'id' => 'cancel_sale')) ?>
                </div>
            </div>
        </div>
        <!-- Master form -->
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::hidden('id', Input::post('id', $pos_invoice->id )); ?>
                <?= Form::hidden('customer_name', Input::post('customer_name', $pos_invoice->customer_name)); ?>
                <?= Form::hidden('status', Input::post('status', Model_Cashier_Invoice::INVOICE_STATUS_OPEN)); ?>
                <?= Form::hidden('paid_status', Input::post('paid_status', $pos_invoice->paid_status)); ?>
                <?= Form::hidden('issue_date', Input::post('issue_date', date('Y-m-d'))); ?>
                <?= Form::hidden('due_date', Input::post('due_date',  date('Y-m-d'))); ?>
                <?= Form::hidden('fdesk_user', Input::post('fdesk_user', $uid)); ?>
                <?= Form::hidden('branch_id', Input::post('branch_id', $business->id)); ?>

                <?= render('cashier/invoice/sale_total'); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <!-- trigger suspend via F9 -->
                <?= Form::submit('submit_sale_return', 'Return / Credit', 
                                array(
                                    'class' => 'sales-return btn btn-success btn-block', 
                                    'style' => 'font-size: 125%; font-weight: 500; display: none'
                                )); ?>
                <!-- trigger submit via F10 -->
                <!-- Pay Now assumes Cash Sale Customer -->
                <!-- Show no. of items in button float:left i.e. in place of icon -->
                <?= Form::submit('submit_cash_sale', 'Pay&ensp;Now', 
                                array(
                                    'class' => 'cash-sale btn btn-primary btn-block', 
                                    'style' => 'font-size: 125%; font-weight: 500'
                                )); ?>
                <!-- or -->
                <!-- Pay Later requires actual Customer (not Cash Sale) -->
                <!-- trigger submit without payment via F8 -->
                <?= Form::submit('submit_credit_sale', 'Pay&ensp;Later', 
                                array(
                                    'class' => 'credit-sale btn btn-info btn-block', 
                                    'style' => 'font-size: 125%; font-weight: 500; display: none',
                                    'data-url' => 'cashier/payment/later'
                                )); ?>
            </div>
        </div>
    <?php
        if ( (bool) $pos_profile->show_sales_person ) : ?>
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Sales Person', 'sales_person', array('class'=>'control-label')); ?>
                <?= Form::select('sales_person', Input::post('sales_person', $pos_invoice->sales_person), 
                                array(), // Model_Sales_Person::listOptions(), 
                                array(
                                    'class' => 'col-md-4 form-control select-from-list text-required',
                                    'id' => 'sales_person'
                                )); ?>
            </div>
        </div>
    <?php 
        endif;
        if ( (bool) $pos_profile->show_shipping ) : ?>        
        <div class="form-group">
            <div class="col-md-12">
                <?= Form::label('Shipping Address', 'shipping_address', array('class'=>'control-label')); ?>
                <?= Form::textarea('shipping_address', Input::post('shipping_address', $pos_invoice->shipping_address), 
                                    array('class' => 'col-md-4 form-control', 'style' => 'min-height: 60px', 'readonly' => true)); ?>
            </div>
        </div>
    <?php 
        endif ?>
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
	<?= render('cashier/invoice/index.js'); ?>
</script>