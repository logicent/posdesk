<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>POSDesk &ndash; <?= $title; ?></title>
        <!-- CSS libraries/plugins -->
        <?= Asset::css(
            array(
                '//maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css',
                '//cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css',
                '//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css',
                '//www.fuelcdn.com/fuelux/3.17.0/css/fuelux.min.css',
                '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
                '//cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css',
                'vendor/united.bootstrap.min.css',
                'vendor/datepicker.css',
                'vendor/fullcalendar.min.css',
                'sb-admin.css', // SB Admin Scripts
                'custom.css',
                'pos.css'
            )); ?>
        <!-- JavaScript libraries/plugins -->
        <?= Asset::js(
            array(
                // '//cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js',
                '//code.jquery.com/jquery-3.4.1.js',
                '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
                '//cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js',
                '//www.fuelcdn.com/fuelux/3.17.0/js/fuelux.min.js',
                '//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js',
                'vendor/jquery.slugify.js',
                'vendor/bootstrap-datepicker.js',
                'plugins/metisMenu/jquery.metisMenu.js',
                '//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js',
                '//cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js',
                'vendor/moment.js',
                'vendor/fullcalendar.min.js',
                'sb-admin.js', // SB Admin Scripts
                'custom.js',
            )); ?>
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                <div class="col-md-1">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?= Uri::create('/'); ?>">POS<span class="text-muted">Desk</span></a><!-- SB Admin v2.0 -->
                    </div>  <!-- /.navbar-header -->
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-top-links top-menu">
                        <li><a class="<?= Uri::segment(1) == 'cashier'  || Uri::segment(1) == '' ? 'active' : '' ?>" href="<?= Uri::create('cashier'); ?>">
                                <i class="fa fa-shopping-cart fa-fw text-muted"></i>&ensp;Cashier</a></li>
                    <?php if (Uri::segment(1) != 'admin') : ?>
                        <li><a class="<?= Uri::segment(1) == 'sales' ? 'active' : '' ?>" href="<?= Uri::create('sales'); ?>">
                                <i class="fa fa-line-chart fa-fw text-muted"></i>&ensp;Sales</a></li>
                        <li><a class="<?= Uri::segment(1) == 'customer' ? 'active' : '' ?>" href="<?= Uri::create('customer'); ?>">
                                <i class="fa fa-users fa-fw text-muted"></i>&ensp;Customer</a></li>
                        <li><a class="<?= Uri::segment(1) == 'product' ? 'active' : '' ?>" href="<?= Uri::create('product'); ?>">
                                <i class="fa fa-cubes fa-fw text-muted"></i>&ensp;Product</a></li>
                        <li><a class="<?= Uri::segment(1) == 'reports' ? 'active' : '' ?>" href="<?= Uri::create('reports'); ?>">
                                <i class="fa fa-bar-chart fa-fw text-muted"></i>&ensp;Reports</a></li>
                        <!-- More menu items -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="text-muted fa fa-fw fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="<?= Uri::segment(1) == 'supplier' ? 'active' : '' ?>" href="<?= Uri::create('supplier'); ?>">
                                    <i class="fa fa-truck fa-fw text-muted"></i>&ensp;Supplier</a></li>
                                <li><a class="<?= Uri::segment(1) == 'purchase' ? 'active' : '' ?>" href="<?= Uri::create('purchases'); ?>">
                                    <i class="fa fa-cubes fa-fw text-muted"></i>&ensp;Purchases</a></li>
                            </ul>   <!-- /.dropdown-more -->
                        </li>   <!-- /.dropdown -->
                    <?php if ($ugroup->id !=3) : ?>
                        <li><a class="<?= Uri::segment(1) == 'admin' ? 'active' : '' ?>" href="<?= Uri::create('admin'); ?>">
                            <i class="fa fa-cog fa-fw text-muted"></i>&ensp;Admin</a></li>
                    <?php endif;
                    endif;
                    if (Uri::segment(1) == 'admin') : ?>
                        <li><a class="<?= Uri::segment(1) == 'dashboard' ? 'active' : '' ?>" href="<?= Uri::create('admin/dashboard'); ?>">
                                <i class="fa fa-trello fa-fw text-muted"></i>&ensp;Dashboard</a></li>
                        <li><a class="<?= Uri::segment(1) == 'users'  || Uri::segment(2) == 'users' ? 'active' : '' ?>" href="<?= Uri::create('admin/users'); ?>">
                                <i class="fa fa-users fa-fw text-muted"></i>&ensp;Users</a></li>
                        <li><a class="<?= Uri::segment(1) == 'settings' || Uri::segment(2) == 'settings' ? 'active' : '' ?>" href="<?= Uri::create('admin/settings'); ?>">
                                <i class="fa fa-cog fa-fw text-muted"></i>&ensp;Settings</a></li>
                    <?php endif ?>
                    </ul><!-- /.navbar-top-links -->
                </div>
                <div class="col-md-3">
                    <ul class="nav navbar-top-links navbar-right">
                        <li><a class="<?= Uri::segment(1) == 'help' ? 'active' : '' ?>" href="<?= Uri::create('help'); ?>"><i class="fa fa-question-circle fa-fw text-muted"></i></a></li>
                        <!-- <li><a class="<?= Uri::segment(1) == 'lock-user' ? 'active' : '' ?>" href="<?= Uri::create('lock-user'); ?>"><i class="fa fa-lock fa-fw text-muted"></i></a></li> -->
                        <li class="dropdown">
                            <!-- show image placeholder for user avatar -->
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <span class="small"><?= $uname; ?></span>&nbsp;
                                <i class="text-muted fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <!--<li><a href="<?php Uri::create('admin/users/change-password/'.$uid) ?>"> Change Password</a></li>-->
                                <li><a href="<?= Uri::create('admin/users/view/'.$uid) ?>"> My Account</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= Uri::create('logout') ?>"> Log out</a></li>
                            </ul>   <!-- /.dropdown-user -->
                        </li>   <!-- /.dropdown -->
                    </ul>   <!-- /.navbar-top-links -->
                </div>
            </nav>
            <div id="page-wrapper">
    <?php 
        if (Session::get_flash('success')): ?>
                <div class="alert alert-success alert-dismissable alert-popup">
                    <h4>Success:
                        <span><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></span>
                    </h4>
                    <div class="alert-popup-detail">
                        <?= implode('<hr>', e( (array) Session::get_flash('success'))); ?>
                    </div>
                </div>
    <?php 
        endif; ?>
    <?php 
        if (Session::get_flash('error')): ?>
                <div class="alert alert-danger alert-dismissable alert-popup">
                    <h4>Some error(s) were encountered:
                        <span><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></span>
                    </h4>
                    <div class="alert-popup-detail">
                        <?= implode('<hr>', e( (array) Session::get_flash('error'))); ?>
                    </div>
                </div>
    <?php 
        endif; ?>
    <?php 
        if (Session::get_flash('warning')): ?>
                <div class="alert alert-warning alert-dismissable alert-popup">
                    <h4>Some warning(s) were encountered:
                        <span><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></span>
                    </h4>
                    <div class="alert-popup-detail">
                        <?= implode('<hr>', e( (array) Session::get_flash('warning'))); ?>
                    </div>
                </div>
    <?php 
        endif; ?>
    <?php 
        if (Session::get_flash('info')): ?>
                <div class="alert alert-info alert-dismissable alert-popup">
                    <h4>Some info for you:
                        <span><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></span>
                    </h4>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div class="alert-popup-detail">
                        <?= implode('<hr>', e( (array) Session::get_flash('info'))); ?>
                    </div>
                </div>
    <?php 
        endif; ?>
                <div id="content" class="row">
                    <div class="col-md-offset-1 col-md-10 content-pane">
                        <!-- <h1 class="page-header"><?= $title; ?></h1> -->
                        <div class="panel"><!-- panel-default -->
                            <div class="panel-body">
                                <?= $content; ?>
                            </div>
                        </div>  <!-- /.panel -->
                    </div>  <!-- /.col-lg-10  -->
                </div>  <!-- /.row -->
            </div>  <!-- /#page-wrapper -->
            <footer id="footer" class="text-center small">
                <a href="http://logicent.co/solutions/point-of-sale.html" target="_blank">POSDesk</a> &copy; 2014-<?= date('Y'); ?> All Rights Reserved.
            </footer>
        </div>  <!-- /#wrapper -->
    </body>
</html>
