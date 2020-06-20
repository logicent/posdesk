<!-- <table id="sale_summary" class="table table-bordered table-hover" style="font-size: 125%"> -->
<table id="sale_summary" class="table table-hover" style="font-size: 125%">
    <tbody>
        <tr id="tr_subtotal">        
            <!-- <td width="50%"><span>Subtotal</span></td> -->
            <td><span>Subtotal</span></td>
            <td class="text-right">
                <span id="subtotal">1,250.00</span>
                <?= Form::hidden('subtotal', Input::post('subtotal', isset($pos_invoice) ? $pos_invoice->subtotal : 0)); ?>
            </td>
        </tr>
        <!-- show discount if enabled for current user or all -->
        <!-- <tr id="tr_discount" style="display: none;"> -->
        <tr id="tr_discount">
            <td><span>Discount</span></td>
            <td class="text-right">
                <span class="small">(20%)</span>&ensp;
                <span id="discount">-250.00</span>
                <?php Form::input('disc_total', Input::post('disc_total', isset($pos_invoice) ? $pos_invoice->disc_total : 0),
                                array('class' => 'col-md-4 form-control input-sm text-right')); ?>                
            </td>
        </tr>
        <tr id="tr_tax_total">
            <td><span>Vat</span>&nbsp;
            <span class="small">(excl.)</span>
            </td>
            <td class="text-right">
                <span class="small">(14%)</span>&ensp;
                <span id="tax_total">140.00</span>
                <?= Form::hidden('tax_total', Input::post('tax_total', isset($pos_invoice) ? $pos_invoice->tax_total : 0)); ?>
            </td>
        </tr>
        <!-- <tr id="tr_delivery_fee" style="display: none;"> -->
        <tr id="tr_delivery_fee">
            <td><span>Delivery</span></td>
            <!-- <td><span>Shipping</span></td> -->
            <td class="text-right">
                <span id="delivery_fee">160.00</span>
                <?php Form::input('delivery_fee', Input::post('delivery_fee', isset($pos_invoice) ? $pos_invoice->delivery_fee : 0),
                                array('class' => 'col-md-4 form-control input-sm text-right')); ?>
            </td>
        </tr>
        <tr id="tr_grand_total" style="font-size: 150%">
            <td><span class="text-muted" style="font-weight: 500">TOTAL</span></td>
            <td class="text-number">
                <span id="grand_total" style="font-weight: 500">1,300.00</span>
                <?= Form::hidden('amount_due', Input::post('amount_due', isset($pos_invoice) ? $pos_invoice->amount_due : 0)); ?>
            </td>
        </tr>
        <tr id="tr_amount_paid">
            <td><span>PAID</span></td>
            <td class="text-right">
                <span id="amount_paid">1,500.00</span>
                <?= Form::hidden('amount_paid', Input::post('amount_paid', isset($pos_invoice) ? $pos_invoice->amount_paid : 0)); ?>
            </td>
        </tr>
        <!-- show if payment method is Cash -->
        <tr id="tr_change_due">
            <td><span class="text-muted" style="font-weight: 500">CHANGE</span></td>
            <td class="text-number">
                <span id="change_due" style="font-weight: 500">200.00</span>
                <?= Form::hidden('change_due', Input::post('change_due', isset($pos_invoice) ? $pos_invoice->change_due : 0)); ?>
            </td>
        </tr>
        <!-- show if partial payment is allowed -->
        <tr id="tr_balance_due" style="display: none;">
            <td><span class="text-muted" style="font-weight: 500">BALANCE</span></td>
            <td class="text-number">
                <span id="balance_due" style="font-weight: 500">0.00</span>
                <?= Form::hidden('balance_due', Input::post('balance_due', isset($pos_invoice) ? $pos_invoice->balance_due : 0)); ?>
            </td>
        </tr>
    </tbody>
</table>