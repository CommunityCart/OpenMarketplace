<section class="content-header">
  <h1>
    <?php echo __('Invites Claimed'); ?>
  </h1>
  <ol class="breadcrumb">
    <li>
    <?= $this->Html->link('<i class="fa fa-dashboard"></i> ' . __('Back'), ['action' => 'index'], ['escape' => false])?>
    </li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-info"></i>
                <h3 class="box-title"><?php echo __('Information'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <dl class="dl-horizontal">
                                                                                                        <dt><?= __('Invite') ?></dt>
                                <dd>
                                    <?= $invitesClaimed->has('invite') ? $invitesClaimed->invite->id : '' ?>
                                </dd>
                                                                                                                <dt><?= __('User') ?></dt>
                                <dd>
                                    <?= $invitesClaimed->has('user') ? $invitesClaimed->user->username : '' ?>
                                </dd>
                                                                                                                <dt><?= __('Vendor') ?></dt>
                                <dd>
                                    <?= $invitesClaimed->has('vendor') ? $invitesClaimed->vendor->title : '' ?>
                                </dd>
                                                                                                
                                            
                                                                                                                                                            <dt><?= __('Upgraded To Vendor') ?></dt>
                                <dd>
                                    <?= $this->Number->format($invitesClaimed->upgraded_to_vendor) ?>
                                </dd>
                                                                                                
                                                                                                                                            
                                            
                                    </dl>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- ./col -->
</div>
<!-- div -->

</section>
