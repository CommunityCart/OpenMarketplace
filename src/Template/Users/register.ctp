<?php

use Cake\Core\Configure;

?>
<div class="row">
    <div class="register-box">

        <?php echo $this->element('Users/users_login'); ?>

        <div class="register-box-body">
            <p class="login-box-msg">Register a new membership</p>

            <?= $this->Form->create($user); ?>

            <div class="form-group has-feedback">
                <?php echo $this->Form->control('username', ['label' => false, 'type' => 'text', 'placeholder' =>
                'Username', 'class' => 'form-control']); ?>
                <span class="glyphicon glyphicon-sunglasses form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <?php echo $this->Form->control('password', ['label' => false, 'type' => 'password', 'placeholder' =>
                'Password', 'class' => 'form-control']); ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <?php echo $this->Form->control('password_confirm', ['label' => false, 'type' => 'password',
                'placeholder' => 'Retype Password', 'class' => 'form-control']); ?>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <?php echo $this->Form->control('withdawal_pin', ['label' => false, 'type' => 'password', 'placeholder' =>
                'Withdrawal Pin Number', 'class' => 'form-control']); ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <?php echo $this->Form->control('withdrawal_pin_confirm', ['label' => false, 'type' => 'password',
                'placeholder' => 'Retype Withdrawal Pin Number', 'class' => 'form-control']); ?>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <img src="<?php echo $this->Url->build('/captcha');?>" />
                </div>
            </div>
            <div class="form-group has-feedback">
                <?php echo $this->Form->control('captcha_confirm', ['label' => false, 'type' => 'text',
                'placeholder' => 'Enter Letters From Above Image', 'class' => 'form-control']); ?>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4 pull-right">
                    <?= $this->Form->button(__d('CakeDC/Users', 'Register'), ['class' => 'btn btn-primary btn-block
                    btn-flat']) ?>

                </div>
                <!-- /.col -->
            </div>
            <?= $this->Form->end() ?>
            <br/>
            <center><a href="/login" class="text-center">I already have a membership</a></center>
        </div>
        <!-- /.form-box -->
    </div>
</div>