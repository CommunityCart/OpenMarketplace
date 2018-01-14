<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Invites Claimed
    <div class="pull-right"><?= $this->Html->link(__('New'), ['action' => 'add'], ['class'=>'btn btn-success btn-xs']) ?></div>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= __('List of') ?> Invites Claimed</h3>
          <div class="box-tools">
            <form action="<?php echo $this->Url->build(); ?>" method="POST">
              <div class="input-group input-group-sm"  style="width: 180px;">
                <input type="text" name="search" class="form-control" placeholder="<?= __('Fill in to start search') ?>">
                <span class="input-group-btn">
                <button class="btn btn-info btn-flat" type="submit"><?= __('Filter') ?></button>
                </span>
              </div>
            </form>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('invite_id') ?></th>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('upgraded_to_vendor') ?></th>
                <th><?= $this->Paginator->sort('vendor_id') ?></th>
                <th><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($invitesClaimed as $invitesClaimed): ?>
              <tr>
                <td><?= $this->Number->format($invitesClaimed->id) ?></td>
                <td><?= $invitesClaimed->has('invite') ? $this->Html->link($invitesClaimed->invite->id, ['controller' => 'Invites', 'action' => 'view', $invitesClaimed->invite->id]) : '' ?></td>
                <td><?= $invitesClaimed->has('user') ? $this->Html->link($invitesClaimed->user->username, ['controller' => 'Users', 'action' => 'view', $invitesClaimed->user->id]) : '' ?></td>
                <td><?= $this->Number->format($invitesClaimed->upgraded_to_vendor) ?></td>
                <td><?= $invitesClaimed->has('vendor') ? $this->Html->link($invitesClaimed->vendor->title, ['controller' => 'Vendors', 'action' => 'view', $invitesClaimed->vendor->id]) : '' ?></td>
                <td class="actions" style="white-space:nowrap">
                  <?= $this->Html->link(__('View'), ['action' => 'view', $invitesClaimed->id], ['class'=>'btn btn-info btn-xs']) ?>
                  <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invitesClaimed->id], ['class'=>'btn btn-warning btn-xs']) ?>
                  <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invitesClaimed->id], ['confirm' => __('Confirm to delete this entry?'), 'class'=>'btn btn-danger btn-xs']) ?>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <ul class="pagination pagination-sm no-margin pull-right">
            <?php echo $this->Paginator->numbers(); ?>
          </ul>
        </div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
