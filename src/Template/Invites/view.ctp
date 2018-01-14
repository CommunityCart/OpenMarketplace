<section class="content-header">
  <h1>
    <?php echo __('Invite'); ?>
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
                                                                                                        <dt><?= __('User') ?></dt>
                                <dd>
                                    <?= $invite->has('user') ? $invite->user->username : '' ?>
                                </dd>
                                                                                                                        <dt><?= __('Code') ?></dt>
                                        <dd>
                                            <?= h($invite->code) ?>
                                        </dd>
                                                                                                                                    
                                            
                                                                                                                                                            <dt><?= __('Count Left') ?></dt>
                                <dd>
                                    <?= $this->Number->format($invite->count_left) ?>
                                </dd>
                                                                                                                <dt><?= __('Count Claimed') ?></dt>
                                <dd>
                                    <?= $this->Number->format($invite->count_claimed) ?>
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

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <i class="fa fa-share-alt"></i>
                    <h3 class="box-title"><?= __('Related {0}', ['Invites Claimed']) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                <?php if (!empty($invite->invites_claimed)): ?>

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                                                    
                                    <th>
                                    Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Invite Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    User Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Upgraded To Vendor
                                    </th>
                                        
                                                                    
                                    <th>
                                    Vendor Id
                                    </th>
                                        
                                                                                                        
                                <th>
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>

                            <?php foreach ($invite->invites_claimed as $invitesClaimed): ?>
                                <tr>
                                                                        
                                    <td>
                                    <?= h($invitesClaimed->id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($invitesClaimed->invite_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($invitesClaimed->user_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($invitesClaimed->upgraded_to_vendor) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($invitesClaimed->vendor_id) ?>
                                    </td>
                                                                        
                                                                        <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'InvitesClaimed', 'action' => 'view', $invitesClaimed->id], ['class'=>'btn btn-info btn-xs']) ?>

                                    <?= $this->Html->link(__('Edit'), ['controller' => 'InvitesClaimed', 'action' => 'edit', $invitesClaimed->id], ['class'=>'btn btn-warning btn-xs']) ?>

                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'InvitesClaimed', 'action' => 'delete', $invitesClaimed->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invitesClaimed->id), 'class'=>'btn btn-danger btn-xs']) ?>    
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                                    
                        </tbody>
                    </table>

                <?php endif; ?>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
