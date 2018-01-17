<?php

use App\Utility\Dates;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Messages
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-3">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Folders</h3>
        </div>
        <div class="box-body no-padding">
          <ul class="nav nav-pills nav-stacked">
            <li class="<?= $userActive ?>"><a href="/messages?inbox=user"><i class="fa fa-inbox"></i> User Inbox<span class="label label-<?php if($userCount > 0) { echo 'success'; } else { echo 'primary'; } ?> pull-right"><?= $userCount ?></span></a></li>
            <?php if($role == 'vendor') { ?>
            <li class="<?= $vendorActive ?>"><a href="/messages?inbox=vendor"><i class="fa fa-envelope-o"></i> Vendor Inbox<span class="label label-<?php if($vendorCount > 0) { echo 'success'; } else { echo 'primary'; } ?> pull-right"><?= $vendorCount ?></span></a></li>
            <?php } ?>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= $inboxTitle ?></h3>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <div class="table-responsive mailbox-messages">
            <?= $this->Form->create(null, ['url' => $url]); ?>
            <div class="mailbox-controls">
              <?= $this->Form->button('<i class="fa fa-square-o"></i>', ['escape' => false, 'class' => 'btn btn-default btn-sm checkbox-toggle', 'name' => 'submit', 'value' => 'checkAll']) ?>
              <div class="btn-group">
                <?= $this->Form->button('<i class="fa fa-trash-o"></i>', ['escape' => false, 'class' => 'btn btn-default btn-sm', 'name' => 'submit', 'value' => 'deleteChecked']) ?>
              </div>
              <!-- /.pull-right -->
            </div>
            <table class="table table-hover table-striped table-bordered">
              <tbody>
              <?php foreach ($messages as $message): ?>
              <tr>
                <td><input type="checkbox" name="checkie[]" value="<?= $message->id ?>" <?php if($checkAll == true) { ?>checked<?php } ?>></td>
                <?php if($role == 'vendor') { ?>
                  <td class="mailbox-name"><?= $message->user->username ?></td>
                  <?php if($message->vendor_read == 0) { ?>
                    <td><span class="label label-success pull-right">UNREAD</span></td>
                  <?php } else { ?>
                    <td><span class="label label-primary pull-right">READ</span></td>
                  <?php } ?>
                <?php } else { ?>
                  <td class="mailbox-name"><?= $message->has('vendor') ? $this->Html->link($message->vendor->title, ['controller' => 'Vendors', 'action' => 'view', $message->vendor->id], ['target' => '_blank']) : '' ?></td>
                  <?php if($message->user_read == 0) { ?>
                    <td><span class="label label-success pull-right">UNREAD</span></td>
                  <?php } else { ?>
                    <td><span class="label label-primary pull-right">READ</span></td>
                  <?php } ?>
                <?php } ?>
                <td class="mailbox-subject" style="width:100%"><?= $this->Html->link(__($message->title), ['action' => 'view', $message->id], ['target' => '_blank']) ?></td>
                <td class="mailbox-date" style="white-space: nowrap;"><?= Dates::getLapsedTime($message->created) ?></td>
                <td class="actions" style="white-space:nowrap">
                  <?= $this->Html->link(__('View'), ['action' => 'view', $message->id], ['class'=>'btn btn-info btn-xs', 'target' => '_blank']) ?>
                </td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
            <?= $this->Form->unlockField('checkie') ?>
            <?= $this->Form->end() ?>
            <!-- /.table -->
          </div>
          <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">
          <div class="mailbox-controls">
            <div class="paginator">
              <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
              </ul>
              <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
            </div>
          </div>
        </div>
      </div>
      <!-- /. box -->
    </div>
    <!-- /.col -->
  </div>
</section>
<!-- /.content -->
