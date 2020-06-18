<h2 class="page-header">New <span class='text-muted'>Product</span></span>&nbsp;
<span><?= Html::anchor('products', '<i class="fa fa-level-down fa-fw fa-rotate-180"></i> Back to List', array('class' => 'btn btn-default btn-xs')); ?></span></h2>

<br>

<?= render('product/item/_form'); ?>