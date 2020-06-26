<!-- <table id="sale_summary" class="table table-bordered table-hover" style="font-size: 125%"> -->
<table id="sale_summary" class="table table-hover" style="font-size: 125%">
    <thead>
        <tr>
            <th class="text-center" colspan="2"><span>CASH SALE</span></td>
            <th style="display: none" class="text-center" colspan="2"><span>CREDIT SALE</span></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- <td width="50%"><span>Subtotal</span></td> -->
            <td><span>Subtotal</span></td>
            <td class="text-right">
                <span id="sale_subtotal"><?= $pos_invoice->subtotal ?></span>
                <?= Form::hidden('subtotal', Input::post('subtotal', $pos_invoice->subtotal)); ?>
            </td>
        </tr>
        <!-- show discount if enabled for current user or all -->
        <tr style="display: none;">
            <td><span>Discount</span></td>
            <td class="text-right">
                <span id="discount_rate" class="small"><?= $pos_invoice->discount_rate ?>%</span>&ensp;
                <span id="sale_discount"><?= $pos_invoice->discount_total ?></span>
                <?php Form::input('discount_total', Input::post('discount_total', $pos_invoice->discount_total),
                                array('class' => 'col-md-4 form-control input-sm text-right')); ?>                
            </td>
        </tr>
        <tr>
            <td><span>Tax</span>&nbsp;
                <span id="tax_type" class="small"><?= $pos_invoice->tax_type ?></span>
            </td>
            <!-- Loop through tax rates (name/rate) -->
            <td class="text-right">
                <span id="sale_tax_rate" class="small">(<?= $pos_invoice->tax_rate ?>%)</span>&ensp;
                <span id="sale_tax_total"><?= $pos_invoice->tax_total ?></span>
                <?= Form::hidden('tax_total', Input::post('tax_total', $pos_invoice->tax_total)); ?>
            </td>
        </tr>
        <tr style="display: none;">
            <td><span>Shipping</span></td>
            <td class="text-right">
                <span id="shipping_fee"><?= $pos_invoice->shipping_fee ?></span>
                <?= Form::input('shipping_fee', Input::post('shipping_fee', $pos_invoice->shipping_fee),
                                array('class' => 'col-md-4 form-control input-sm text-right')); ?>
                <span id="shipping_tax"><?= $pos_invoice->shipping_tax ?></span>
                <?= Form::input('shipping_tax', Input::post('shipping_tax', $pos_invoice->shipping_tax),
                                array('class' => 'col-md-4 form-control input-sm text-right')); ?>
            </td>
        </tr>
        <tr>
            <td><span class="text-muted" style="font-weight: 500">TOTAL</span></td>
            <td class="text-number">
                <span id="sale_total" style="font-weight: 500"><?= $pos_invoice->amount_due ?></span>
                <?= Form::hidden('amount_due', Input::post('amount_due', $pos_invoice->amount_due)); ?>
            </td>
        </tr>
        <tr>
            <td><span>PAID</span></td>
            <td width="50%" class="text-right">
                <span id="sale_amount_paid"><?= $pos_invoice->amount_paid ?></span>
                <?= Form::input('amount_paid', Input::post('amount_paid', $pos_invoice->amount_paid), 
                                array('class' => 'input-sm form-control text-right')); ?>
            </td>
        </tr>
        <!-- show if payment method is Cash -->
        <tr>
            <td><span class="text-muted" style="font-weight: 500">CHANGE</span></td>
            <td class="text-number">
                <span id="sale_change_due" style="font-weight: 500"><?= $pos_invoice->change_due ?></span>
                <?= Form::hidden('change_due', Input::post('change_due', $pos_invoice->change_due)); ?>
            </td>
        </tr>
        <!-- show if partial payment is allowed -->
        <tr style="display: none;">
            <td><span class="text-muted" style="font-weight: 500">BALANCE</span></td>
            <td class="text-number">
                <span id="sale_balance_due" style="font-weight: 500"><?= $pos_invoice->balance_due ?></span>
                <?= Form::hidden('balance_due', Input::post('balance_due', $pos_invoice->balance_due)); ?>
            </td>
        </tr>
    </tbody>
</table>