<h2 class="page-header">Editing <span class='text-muted'>Cashier Profile</span>&nbsp;
<span><?= Html::anchor('admin/settings/cashier/profile', '<i class="fa fa-level-down fa-fw fa-rotate-180"></i> Back to List', array('class' => 'btn btn-default btn-xs')); ?></span>
</h2>
<br>

<?= render('cashier/' . basename(__DIR__) . '/_form'); ?>
