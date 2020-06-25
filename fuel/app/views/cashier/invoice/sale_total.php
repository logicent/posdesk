<!-- <table id="sale_summary" class="table table-bordered table-hover" style="font-size: 125%"> -->
<table id="sale_summary" class="table table-hover" style="font-size: 125%">
    <thead>
        <tr>
            <th class="text-center" colspan="2"><span>CASH SALE</span></td>
            <!-- <th class="text-center" colspan="2"><span>CREDIT SALE</span></td> -->
        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- <td width="50%"><span>Subtotal</span></td> -->
            <td><span>Subtotal</span></td>
            <td class="text-right">
                <span id="sale_subtotal"><?= isset($pos_invoice) ? $pos_invoice->subtotal : 0 ?></span>
                <?= Form::hidden('subtotal', Input::post('subtotal', isset($pos_invoice) ? $pos_invoice->subtotal : 0)); ?>
            </td>
        </tr>
        <!-- show discount if enabled for current user or all -->
        <tr style="display: none;">
            <td><span>Discount</span></td>
            <td class="text-right">
                <span id="discount_rate" class="small"><?= isset($pos_invoice) ? $pos_invoice->discount_rate : 0 ?>%</span>&ensp;
                <span id="sale_discount"><?= isset($pos_invoice) ? $pos_invoice->disc_total : 0 ?></span>
                <?php Form::input('disc_total', Input::post('disc_total', isset($pos_invoice) ? $pos_invoice->disc_total : 0),
                                array('class' => 'col-md-4 form-control input-sm text-right')); ?>                
            </td>
        </tr>
        <tr>
            <td><span>Tax</span>&nbsp;
                <span id="tax_type" class="small"><?= isset($pos_invoice) ? $pos_invoice->tax_type : '' ?></span>
            </td>
            <!-- Loop through tax rates (name/rate) -->
            <td class="text-right">
                <span id="sale_tax_rate" class="small">(<?= isset($pos_invoice) ? $pos_invoice->tax_rate : '0' ?>%)</span>&ensp;
                <span id="sale_tax_total"><?= isset($pos_invoice) ? $pos_invoice->tax_total : 0 ?></span>
                <?= Form::hidden('tax_total', Input::post('tax_total', isset($pos_invoice) ? $pos_invoice->tax_total : 0)); ?>
            </td>
        </tr>
        <tr style="display: none;">
            <td><span>Delivery</span></td>
            <!-- <td><span>Shipping</span></td> -->
            <td class="text-right">
                <span id="sale_delivery_fee"><?= isset($pos_invoice) ? $pos_invoice->delivery_fee : 0 ?></span>
                <?= Form::input('delivery_fee', Input::post('delivery_fee', isset($pos_invoice) ? $pos_invoice->delivery_fee : 0),
                                array('class' => 'col-md-4 form-control input-sm text-right')); ?>
            </td>
        </tr>
        <tr>
            <td><span class="text-muted" style="font-weight: 500">TOTAL</span></td>
            <td class="text-number">
                <span id="sale_total" style="font-weight: 500"><?= isset($pos_invoice) ? $pos_invoice->amount_due : 0 ?></span>
                <?= Form::hidden('amount_due', Input::post('amount_due', isset($pos_invoice) ? $pos_invoice->amount_due : 0)); ?>
            </td>
        </tr>
        <tr>
            <td><span>PAID</span></td>
            <td class="text-right">
                <span id="sale_amount_paid"><?= isset($pos_invoice) ? $pos_invoice->amount_paid : 0 ?></span>
                <?= Form::hidden('amount_paid', Input::post('amount_paid', isset($pos_invoice) ? $pos_invoice->amount_paid : 0)); ?>
            </td>
        </tr>
        <!-- show if payment method is Cash -->
        <tr>
            <td><span class="text-muted" style="font-weight: 500">CHANGE</span></td>
            <td class="text-number">
                <span id="sale_change_due" style="font-weight: 500"><?= isset($pos_invoice) ? $pos_invoice->change_due : 0 ?></span>
                <?= Form::hidden('change_due', Input::post('change_due', isset($pos_invoice) ? $pos_invoice->change_due : 0)); ?>
            </td>
        </tr>
        <!-- show if partial payment is allowed -->
        <tr style="display: none;">
            <td><span class="text-muted" style="font-weight: 500">BALANCE</span></td>
            <td class="text-number">
                <span id="sale_balance_due" style="font-weight: 500"><?= isset($pos_invoice) ? $pos_invoice->balance_due : 0 ?></span>
                <?= Form::hidden('balance_due', Input::post('balance_due', isset($pos_invoice) ? $pos_invoice->balance_due : 0)); ?>
            </td>
        </tr>
    </tbody>
</table>