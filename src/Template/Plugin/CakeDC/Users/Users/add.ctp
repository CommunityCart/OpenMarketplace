
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->Form->create(${$tableAlias}); ?>
            <div class="box-body">
                <div class="form-group has-feedback">
                <?php echo $this->Form->control('username', ['label' => false, 'type' => 'text', 'placeholder' => 'Username', 'class' => 'form-control']); ?>
                <span class="glyphicon glyphicon-sunglasses form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('email', ['label' => false, 'type' => 'email', 'placeholder' => 'Email', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('password', ['label' => false, 'type' => 'password', 'placeholder' => 'Password', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('first_name', ['label' => false, 'type' => 'text', 'placeholder' => 'First Name', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('last_name', ['label' => false, 'type' => 'text', 'placeholder' => 'Last Name', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="checkbox">
                    <?php
                    echo $this->Form->control('active', [
                    'type' => 'checkbox',
                    'label' => __d('CakeDC/Users', 'Activate User')
                    ]);
                    ?>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?= $this->Form->button(__d('CakeDC/Users', 'Add User'), ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>