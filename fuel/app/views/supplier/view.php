<h2>Viewing <span class='muted'>#<?php echo $supplier->id; ?></span></h2>


<?php echo Html::anchor('supplier/edit/'.$supplier->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/supplier', 'Back'); ?>