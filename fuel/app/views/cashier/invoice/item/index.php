<div id="list" class="tab-pane fade">
    <?= render('cashier/invoice/item/list', array('pos_invoice_items' => $pos_invoice_item)) ?>
</div>
<div id="grid" class="tab-pane fade">
    <?= render('cashier/invoice/item/grid', array('pos_invoice_items' => $pos_invoice_item)) ?>
</div>