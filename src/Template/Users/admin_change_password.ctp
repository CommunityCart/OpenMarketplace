<div class="row jlr-dashbox">
    <div class="col-lg-4 col-lg-offset-1">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <?php
                    echo $this->Html->image(
                empty($user->avatar) ? $avatarPlaceholder : $user2->avatar,
                ['class' => 'profile-user-img img-responsive img-circle']
                );
                ?>
                <h3 class="profile-username text-center">
                    <?php
                        echo $this->Html->tag(
                    'span',
                    __d('CakeDC/Users', '{0} {1}', $user2->first_name, $user2->last_name),
                    ['class' => 'full_name']
                    );
                    ?>
                </h3>

                <p class="text-muted text-center"><?php echo ucfirst($user2->role); ?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Username</b> <a class="pull-right"><?php echo $user2->username; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Email</b> <a class="pull-right"><?php echo $user2->email; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Member Since</b>
                        <a class="pull-right">
                            <?php

                                echo $user2->created;
                            ?>
                        </a>
                    </li>
                </ul>
                <?php
                // @todo add follow
                // <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                ?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-lg-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->Flash->render('auth') ?>
            <?php

                if(isset($userPasswordEntity) && !isset($user2)) {

                    echo $this->Form->create($userPasswordEntity, array('url' => '/users/users/change_password'));
            }
            else {

            echo $this->Form->create($user2, array('url' => '/users/users/change_password'));
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