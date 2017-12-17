<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <h1>Sales Page Place Holder</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <h1>Total to be charged</h1>
        <h3 style="float:right">$10.29</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Upgrade to Member</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->Form->create(null, array('url' => '/billing/subscribe/' . $currentUser->id)); ?>
            <div class="box-body">
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('first_name', ['label' => false, 'type' => 'text', 'placeholder' => 'First name', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('last_name', ['label' => false, 'type' => 'text', 'placeholder' => 'Last name', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('creditcardNumber', ['label' => false, 'value' => '4111111111111111', 'type' => 'text', 'placeholder' => 'Credit Card Number', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $this->Form->control('creditcardExpiration', ['label' => false, 'value' => '2020-02', 'type' => 'text', 'placeholder' => 'Expiration YYYY-MM', 'class' => 'form-control']); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?= $this->Form->button('Upgrade', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>