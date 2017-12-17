<?php

use Cake\Core\Configure;

$Users = ${$tableAlias};
?>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->Form->create($Users, array('url' => '/users/users/edit/' . $currentUser->id)); ?>
            <div class="box-body">
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('username', ['label' => false, 'type' => 'text', 'placeholder' => 'Username', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('email', ['label' => false, 'type' => 'text', 'placeholder' => 'Email', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('first_name', ['label' => false, 'type' => 'text', 'placeholder' => 'First name', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('last_name', ['label' => false, 'type' => 'text', 'placeholder' => 'Last name', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('token', ['label' => false, 'type' => 'text', 'placeholder' => 'Token', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <div class="row">
                        <div class="col-lg-4"><label>Token Expires</label></div>
                        <div class="col-lg-8">
                            <?php echo $this->Form->control('token_expires', ['label' => false, 'placeholder' => 'Token Expires', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('api_token', ['label' => false, 'type' => 'text', 'placeholder' => 'API Token', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <div class="row">
                        <div class="col-lg-4"><label>Activation Date</label></div>
                        <div class="col-lg-8">
                            <?php echo $this->Form->control('activation_date', ['label' => false, 'placeholder' => 'Activation Date', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <div class="row">
                        <div class="col-lg-4"><label>TOS Date</label></div>
                        <div class="col-lg-8">
                            <?php echo $this->Form->control('tos_date', ['label' => false, 'placeholder' => 'TOS Date', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('active', ['type' => 'checkbox']); ?>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?= $this->Form->button(__d('CakeDC/Users', 'Save User'), ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>
            <?= $this->Form->end() ?>
            <?php if (Configure::read('Users.GoogleAuthenticator.login')) : ?>
            <fieldset>
                <legend>Reset Google Authenticator</legend>
                <?= $this->Form->postLink(
                __d('CakeDC/Users', 'Reset Google Authenticator Token'), [
                'plugin' => 'CakeDC/Users',
                'controller' => 'Users',
                'action' => 'resetGoogleAuthenticator', $Users->id
                ], [
                'class' => 'btn btn-danger',
                'confirm' => __d(
                'CakeDC/Users',
                'Are you sure you want to reset token for user "{0}"?', $Users->username
                )
                ]);
                ?>
            </fieldset>
            <?php endif; ?>
        </div>
    </div>
</div>