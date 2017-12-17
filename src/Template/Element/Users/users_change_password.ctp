<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->Flash->render('auth') ?>
            <?php

                if(isset($userPasswordEntity)) {

                    echo $this->Form->create($userPasswordEntity, array('url' => '/users/users/change_password'));
                }
                else {

                    echo $this->Form->create($user, array('url' => '/users/users/change_password'));
                }
            ?>
            <div class="box-body">
                <?php if ($validatePassword) : ?>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('current_password', ['label' => false, 'type' => 'password', 'placeholder' => 'Current Password', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <?php endif; ?>
                <h4>Set New Password</h4>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('password', ['label' => false, 'type' => 'password', 'placeholder' => 'New Password', 'class' => 'form-control', 'value' => '']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('password_confirm', ['label' => false, 'type' => 'password', 'placeholder' => 'Confirm New Password', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?= $this->Form->button(__d('CakeDC/Users', 'Change Password'), ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>