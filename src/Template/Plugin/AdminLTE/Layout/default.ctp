<?php use Cake\Core\Configure; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo Configure::read('Theme.title'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css('AdminLTE./bootstrap/css/bootstrap.min'); ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <?php echo $this->Html->css('AdminLTE.AdminLTE.min'); ?>
    <?php echo $this->Html->css('adminlte_overrides.css'); ?>
<!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <?php echo $this->Html->css('AdminLTE.skins/skin-'. Configure::read('Theme.skin') .'.min'); ?>

    <?php echo $this->fetch('css'); ?>
</head>
<body class="hold-transition skin-<?php echo Configure::read('Theme.skin'); ?> sidebar-mini <?php echo $bodycollapse; ?>">
    <!-- Site wrapper -->
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo $this->Url->build('/'); ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><?php echo Configure::read('Theme.logo.mini'); ?></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><?php echo Configure::read('Theme.logo.large'); ?></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <?php echo $this->element('nav-top') ?>
        </header>

        <!-- Left side column. contains the sidebar -->
        <?php echo $this->element('aside-main-sidebar'); ?>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <?php echo $this->Flash->render(); ?>
            <?php echo $this->Flash->render('auth'); ?>
            <?php echo $this->fetch('content'); ?>

        </div>
        <!-- /.content-wrapper -->

        <?php echo $this->element('footer'); ?>

        <!-- Control Sidebar -->
        <?php echo $this->element('aside-control-sidebar'); ?>

        <!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

</body>
</html>
