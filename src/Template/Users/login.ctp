<?php

use Cake\Core\Configure;

?>

<div class="row">
    <div class="login-box">
        <?php echo $this->element('Users/users_login'); ?>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create() ?>
            <div class="form-group has-feedback">
                <?php echo $this->Form->control('username', ['required' => true, 'label' => false, 'type' => 'text',
                'placeholder' => 'Username', 'class' => 'form-control']); ?>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <?php echo $this->Form->control('password', ['required' => true, 'label' => false, 'type' => 'password',
                'placeholder' => 'Password', 'class' => 'form-control']); ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <?php
if (Configure::read('Users.RememberMe.active')) {
        echo $this->Form->control(Configure::read('Users.Key.Data.rememberMe'), [
                    'type' => 'checkbox',
                    'label' => __d('CakeDC/Users', 'Remember me'),
                    'checked' => Configure::read('Users.RememberMe.checked')
                    ]);
                    }
                    ?>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?= $this->Form->button(__d('CakeDC/Users', 'Login'), ['class' => 'btn btn-primary btn-block
                    btn-flat']); ?>

                </div>
                <!-- /.col -->
            </div>
            <?php
        if (Configure::read('Users.reCaptcha.login')) {
            echo $this->User->addReCaptcha();
            }

            ?>
            <?php
        $registrationActive = Configure::read('Users.Registration.active');
        if ($registrationActive) {
            echo '<a href="/register">Register</a>';
            }
            if (Configure::read('Users.Email.required')) {
            if ($registrationActive) {
            echo ' | ';
            }
            echo '<a href="/reset">Reset Password</a>';
            }
            ?>
            <?php
         // implode(' ', $this->User->socialLoginList());
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