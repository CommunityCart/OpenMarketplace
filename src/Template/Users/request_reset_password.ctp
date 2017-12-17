<?php

use Cake\Core\Configure;

?>
<div class="row">
    <div class="login-box">

        <?php echo $this->element('Users/users_login'); ?>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Enter username to reset your password</p>

            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create('User') ?>

            <div class="form-group has-feedback">
                <?php echo $this->Form->control('reference', ['label' => false, 'type' => 'text', 'placeholder' =>
                'Username', 'class' => 'form-control']); ?>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <?= $this->Form->button(__d('CakeDC/Users', 'Submit'), ['class' => 'btn btn-primary btn-block btn-flat']);
            ?>
            <?= $this->Form->end() ?>

            <!--<div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                    Facebook</a>
                <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                    Google+</a>
            </div>-->
            <!-- /.social-auth-links -->

        </div>
        <!-- /.login-box-body -->
    </div>
</div>