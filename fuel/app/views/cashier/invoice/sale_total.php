<?= Form::hidden('sale_type', empty(Input::post()) ? $pos_profile->default_sale_type : Input::post('sale_type', $pos_invoice->sale_type)); ?>

<!-- <table id="sale_summary" class="table table-bordered table-hover" style="font-size: 125%"> -->
<table id="sale_summary" class="table table-hover" style="font-size: 125%">
    <thead>
        <tr class="cash-sale">
            <th class="text-center" colspan="2"><span>CASH SALE</span></td>
        </tr>
        <tr class="credit-sale" style="display: none">
            <th class="text-center" colspan="2"><span>CREDIT SALE</span></td>
        </tr>
        <tr class="sales-return" style="display: none">
            <th class="text-center" colspan="2"><span>SALES RETURN</span></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- <td width="50%"><span>Subtotal</span></td> -->
            <td><span>Subtotal</span></td>
            <td class="text-right">
                <span id="sale_subtotal"><?= number_format($pos_invoice->subtotal, 2) ?></span>
                <?= Form::hidden('subtotal', Input::post('subtotal', $pos_invoice->subtotal)); ?>
            </td>
        </tr>
        <?php if ((bool) $pos_profile->show_discount) : ?>
        <tr>
            <td><span>Discount</span></td>
            <td class="text-right">
                <span id="discount_rate" class="small"><?= $pos_invoice->discount_rate ?>%</span>&ensp;
                <span id="sale_discount"><?= number_format($pos_invoice->discount_total, 0) ?></span>
                <?php Form::input('discount_total', Input::post('discount_total', $pos_invoice->discount_total),
                                array('class' => 'col-md-4 form-control input-sm text-right')); ?>                
            </td>
        </tr>
        <?php endif ?>
        <tr>
            <td><span>Tax</span>&nbsp;
                <span id="tax_type" class="small"><?= $pos_invoice->tax_type ?></span>
                <?= Form::hidden('amounts_tax_inclusive', Input::post('amounts_tax_inclusive', $pos_invoice->amounts_tax_inclusive)); ?>
                <?php Form::checkbox('cb_amounts_tax_inclusive', null, array('class' => 'cb-checked', 'data-input' => 'amounts_tax_inclusive')); ?>
            </td>
            <!-- Loop through tax rates (name/rate) -->
            <td class="text-right">
                <span id="sale_tax_rate" class="small">(<?= $pos_invoice->tax_rate ?>%)</span>&ensp;
                <span id="sale_tax_total"><?= number_format($pos_invoice->tax_total, 2) ?></span>
                <?= Form::hidden('tax_total', Input::post('tax_total', $pos_invoice->tax_total)); ?>
            </td>
        </tr>
        <?php if ((bool) $pos_profile->show_shipping) : ?>
        <tr>
            <td><span>Shipping</span></td>
            <td class="text-right">
                <span id="shipping_fee"><?= number_format($pos_invoice->shipping_fee, 2) ?></span>
                <?= Form::input('shipping_fee', Input::post('shipping_fee', $pos_invoice->shipping_fee),
                                array('class' => 'col-md-4 form-control input-sm text-right')); ?>
                <span id="shipping_tax"><?= number_format($pos_invoice->shipping_tax, 2) ?></span>
                <?= Form::input('shipping_tax', Input::post('shipping_tax', $pos_invoice->shipping_tax),
                                array('class' => 'col-md-4 form-control input-sm text-right')); ?>
            </td>
        </tr>
        <?php endif ?>
        <tr style="font-size: 150%; font-weight: 500; height: 82px">
            <td style="vertical-align: middle"><span class="text-muted">TOTAL</span></td>
            <td style="vertical-align: middle" class="text-right">
                <span id="sale_total"><?= number_format($pos_invoice->amount_due, 2) ?></span>
                <?= Form::hidden('amount_due', Input::post('amount_due', $pos_invoice->amount_due)); ?>
            </td>
        </tr>
        <tr data-toggle="collapse" data-target="#payment_options" class="accordion-toggle">
            <td><span>PAID</span>&ensp;<span id="collapse_icon"><i class="fa fa-angle-down"></i></span></td>
            <td width="50%" class="text-right">
                <span id="sale_amount_paid"><?= number_format($pos_invoice->amount_paid, 2) ?></span>
                <?= Form::hidden('amount_paid', Input::post('amount_paid', $pos_invoice->amount_paid), 
                                array('class' => 'input-sm form-control text-right')); ?>
            </td>
        </tr>
        <!-- Loop through the payment methods in POS Profile -->
        <tr class="accordion-body collapse" id="payment_options">
            <td colspan="2" style="border-top: none; padding: 0">
                <div class="inline-table">
                    <?= render('cashier/invoice/payment/index', array('pos_invoice_payments' => $pos_invoice_payment)); ?>
                </div>
            </td>
        </tr>
        <!-- show if payment method is Cash -->
        <tr class="cash-sale">
            <td><span class="text-muted" style="font-weight: 500">CHANGE</span></td>
            <td class="text-number">
                <span id="sale_change_due" style="font-weight: 500"><?= number_format($pos_invoice->change_due, 2) ?></span>
                <?= Form::hidden('change_due', Input::post('change_due', $pos_invoice->change_due)); ?>
            </td>
        </tr>
        <!-- show if partial payment is allowed -->
        <tr class="credit-sale" style="display: none;">
            <td><span class="text-muted" style="font-weight: 500">BALANCE</span></td>
            <td class="text-number">
                <span id="sale_balance_due" style="font-weight: 500"><?= number_format($pos_invoice->balance_due, 2) ?></span>
                <?= Form::hidden('balance_due', Input::post('balance_due', $pos_invoice->balance_due)); ?>
            </td>
        </tr>
    </tbody>
</table>