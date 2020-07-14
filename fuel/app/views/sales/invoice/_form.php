<!-- Invoice Amounts -->
<!-- Amount Due      Black (Sales) -->
<!-- Amount Paid     Green (Receipts) -->
<!-- Advance Paid    Blue (Liability) -->
<!-- Balance Due     Red (Debts owed) -->

<?= Form::open(array("class"=>"form-horizontal", "autocomplete" => "off")); ?>

	<div class="form-group">
        <div class="col-md-6">
            <?= Form::label('Customer', 'customer_id', array('class'=>'control-label')); ?>
			<?= Form::hidden('customer_name', Input::post('customer_name', isset($sales_invoice) ? $sales_invoice->customer_name : '')); ?>
            <?= Form::select('customer_id', Input::post('customer_id', isset($sales_invoice) ? $sales_invoice->customer_id : ''),
                            Model_Customer::listOptions(), 
                            array('class' => 'col-md-4 form-control select-from-list')); ?>
        </div>
        <div class="col-md-3">
			<?= Form::label('Invoice no.', 'id', array('class'=>'control-label')); ?>
            <?= Form::input('id', Input::post('id', isset($sales_invoice) ? $sales_invoice->id : 
                            Model_Sales_Invoice::getNextSerialNumber()), 
                            array('class' => 'col-md-4 form-control', 'readonly' => true)); ?>
		</div>
		<div class="col-md-3">
			<?= Form::label('Status', 'status', array('class'=>'control-label')); ?>
			<?= Form::hidden('status', Input::post('status', isset($sales_invoice) ? $sales_invoice->status : Model_Sales_Invoice::INVOICE_STATUS_OPEN)); ?>
            <?= Form::select('status_list', Input::post('status_list', isset($sales_invoice) ? $sales_invoice->status : ''), 
                            Model_Sales_Invoice::$invoice_status, 
                            array('class' => 'col-md-4 form-control', 'disabled' => true)); ?>
		</div>
	</div>
	<div class="form-group">
        <div class="col-md-6">
            <?= Form::label('Shipping address', 'shipping_address', array('class'=>'control-label')); ?>
            <?= Form::textarea('shipping_address', Input::post('shipping_address', isset($sales_invoice) ? $sales_invoice->shipping_address : ''), 
                                array('class' => 'col-md-4 form-control', 'rows' => 5)); ?>        
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-md-6">
                    <?= Form::label('Issue date', 'issue_date', array('class'=>'control-label')); ?>
                    <?= Form::input('issue_date', Input::post('issue_date', isset($sales_invoice) ? $sales_invoice->issue_date : date('Y-m-d')), 
                                    array('class' => 'col-md-4 form-control datepicker', 'readonly' => isset($sales_invoice) ? true : false)); ?>
                </div>
                <div class="col-md-6">
                    <?= Form::label('Due date', 'due_date', array('class'=>'control-label')); ?>
                    <?= Form::input('due_date', Input::post('due_date', isset($sales_invoice) ? $sales_invoice->due_date :  date('Y-m-d')), 
                                    array('class' => 'col-md-4 form-control datepicker', 'readonly' => isset($sales_invoice) ? true : false)); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <?= Form::label('Branch', 'branch_id', array('class'=>'control-label')); ?>
                    <?= Form::hidden('branch_name', Input::post('branch_name', isset($sales_invoice) ? $sales_invoice->branch_name : '')); ?>
                    <?= Form::select('branch_id', Input::post('branch_id', isset($sales_invoice) ? $sales_invoice->branch_id : ''),
                                    array(), // Model_Branch::getBranchName($sales_invoice->branch_id), 
                                    array('class' => 'col-md-4 form-control')); ?>        
                </div>        
                <div class="col-md-6">
                    <?= Form::label('Paid Status', 'paid_status', array('class'=>'control-label')); ?>
                    <?= Form::hidden('paid_status', Input::post('paid_status', isset($sales_invoice) ? $sales_invoice->paid_status : '')); ?>
                    <?= Form::select('paid_status_list', Input::post('paid_status_list', 
                                isset($sales_invoice) ? $sales_invoice->paid_status : ''), 
                                Model_Sales_Invoice::$invoice_paid_status, 
                                array('class' => 'col-md-4 form-control', 'disabled' => true)); ?>        
                </div>
            </div>
        </div>
	</div>
    <br>
	<ul id="doc_detail" class="nav nav-tabs">
		<li>
			<a id="items-tab" data-toggle="tab" href="#items">Items</a>
		</li>
		<li>
			<a id="payments-tab" data-toggle="tab" href="#payments">Payments</a>
		</li>
	</ul>
    <!-- <br> -->
	<div id="doc_tabs" class="tab-content">
		<div id="items" class="tab-pane fade">
			<?= render('sales/invoice/item/index', array('sales_invoice_items' => isset($sales_invoice) ? $sales_invoice->items : array())); ?>
		</div>
		<div id="payments" class="tab-pane fade">
			<table class="table table-hover">
				<thead>
					<tr>
						<th class="col-md-2">Receipt no.</th>
						<th class="col-md-2">Date</th>
						<th class="col-md-6">Description</th>
						<th class="col-md-2 text-right">Amount</th>
					</tr>
				</thead>
				<tbody>
        <?php 
            if (isset($sales_invoice) && !empty($sales_invoice->receipts)) :
                foreach ($sales_invoice->receipts as $item): ?>
                    <tr class="<?= $item->amount > 0 ? : 'strikeout text-muted' ?>">
                        <td><?= Html::anchor('accounts/payment/receipt/edit/'.$item->id, $item->reference); ?></td>
                        <td><?= $item->date; ?></td>
                        <td><?= $item->description; ?></td>
                        <td class="text-right"><?= number_format($item->amount, 2); ?></td>
                    </tr>
        <?php 
                endforeach;
            else : ?>
                    <tr id="no_data"><td class="text-muted text-center" colspan="4">No data</td></tr>
        <?php
            endif ?>
				</tbody>
			</table>
		</div>
	</div>
    <?= Form::hidden('fdesk_user', Input::post('fdesk_user', isset($sales_invoice) ? $sales_invoice->fdesk_user : $uid)); ?>
    <br>
	<div class="row">
		<div class="col-md-6">
            <div class="form-group">
                <div class="col-md-12">
                    <?= Form::label('Notes', 'notes', array('class'=>'control-label')); ?>
                    <?= Form::textarea('notes', Input::post('notes', isset($sales_invoice) ? $sales_invoice->notes : ''), 
                                        array('class' => 'col-md-4 form-control', 'rows' => 5)); ?>
                </div>
            </div>
        </div>
		<div class="col-md-6">
            <div class="form-group">
                <div class="col-md-6">
                    <?= Form::label('Subtotal', 'subtotal', array('class'=>'control-label')); ?>
                    <?= Form::input('subtotal', Input::post('subtotal', isset($sales_invoice) ? 
                                    number_format($sales_invoice->subtotal, 0, '.', '') : 0),
                                    array('class' => 'col-md-4 form-control text-number', 'readonly' => true)); ?>
                    <?php Form::label('Discount Amount', 'discount_total', array('class'=>'control-label')); ?>
                    <?= Form::hidden('discount_total', Input::post('discount_total', isset($sales_invoice) ? 
                                    number_format($sales_invoice->discount_total, 0, '.', '') : 0),
                                    array('class' => 'col-md-4 form-control text-number')); ?>
                </div>
                <div class="col-md-6">
                    <?= Form::label('Amount Due', 'amount_due', array('class'=>'control-label')); ?>
                    <?= Form::input('amount_due', Input::post('amount_due', isset($sales_invoice) ? 
                                    number_format($sales_invoice->amount_due, 0, '.', '') : 0),
                                    array('class' => 'col-md-4 form-control text-number', 'readonly' => true)); ?>
                </div>
                <?= Form::hidden('tax_total', Input::post('tax_total', isset($sales_invoice) ? 
                                number_format($sales_invoice->tax_total, 0, '.', '') : 0.0)); ?>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <?= Form::label('Amount Paid', 'amount_paid', array('class'=>'control-label')); ?>
                    <?= Form::input('amount_paid', Input::post('amount_paid', isset($sales_invoice) ? 
                                    number_format($sales_invoice->amount_paid, 0, '.', '') : 0),
                                    array('class' => 'col-md-4 form-control text-number', 'readonly' => true)); ?>
                </div>
                <div class="col-md-6">
                    <?= Form::label('Balance Due', 'balance_due', array('class'=>'control-label')); ?>
                    <?= Form::input('balance_due', Input::post('balance_due', isset($sales_invoice) ? 
                                    number_format($sales_invoice->balance_due, 0, '.', '') : 0),
                                    array('class' => 'col-md-4 form-control text-number', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
    </div>
    <hr>
	<div class="form-group">
		<div class="col-md-6">
			<!-- <button class="btn btn-success" data-bind='click: save'>Save</button> -->
			<?= Form::submit('submit', isset($sales_invoice) ? 'Update' : 'Create', array('class' => 'btn btn-primary')); ?>
		</div>
		<div class="col-md-6">
			<div class="pull-right btn-group">
            <?php 
                if (isset($sales_invoice)) :
                    if ($sales_invoice->status == 'O') : ?>
                        <a href="<?= Uri::create('accounts/payment/receipt/create/' . $sales_invoice->id); ?>" class="btn btn-default ">Add payment</a>
            <?php 
                    endif;
                endif ?>
			</div>
		</div>
	</div>

<?= Form::close(); ?>

<script>
	$('#doc_detail a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
	})
	$('#doc_detail a:first').tab('show')

    // Fetch dependent drop down list options
    $('#form_source').on('change', function() { 
        $.ajax({
            type: 'post',
            url: '/accounts/sales-invoice/get-source-list-options',
            // dataType: 'json',
            data: {
                // console.log($(this).val());
                'source': $(this).val(),
            },
            success: function(listOptions) 
            {
                var selectOptions = '<option value="" selected></option>';
                $.each(JSON.parse(listOptions), function(index, listOption)               
                {
                    selectOptions += '<option value="' + index + '">' + listOption + '</option>';
                });
                $('#form_source_id').html(selectOptions);
            },
            error: function(jqXhr, textStatus, errorThrown) {
                console.log(errorThrown)
            }
        });
    });

    $('#form_source_id').on('change', function() { 
        $.ajax({
            type: 'post',
            url: '/accounts/sales-invoice/get-source-info',
            // dataType: 'json',
            data: {
                // console.log($(this).val());
                'source': $('#form_source').val(),
                'source_id': $(this).val(),
            },
            success: function(data) 
            {
                // console.log(data);
                data = JSON.parse(data);
                $('#form_customer_name').val(data.customer_name);
                $('#form_billing_address').val(data.email_address);
            },
            error: function(jqXhr, textStatus, errorThrown) {
                console.log(errorThrown)
            }
        });
    });

</script>