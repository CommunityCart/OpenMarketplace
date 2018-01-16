<section class="content-header">
  <h1>
    <?php echo __('Message'); ?>
  </h1>
  <ol class="breadcrumb">
    <li>
    <?= $this->Html->link('<i class="fa fa-dashboard"></i> ' . __('Back'), ['action' => 'index'], ['escape' => false])?>
    </li>
  </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Folders</h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="<?= $userActive ?>"><a href="/messages?inbox=user"><i class="fa fa-inbox"></i> User Inbox<span class="label label-primary pull-right"><?= $userCount ?></span></a></li>
                        <?php if($role == 'vendor') { ?>
                        <li class="<?= $vendorActive ?>"><a href="/messages?inbox=vendor"><i class="fa fa-envelope-o"></i> Vendor Inbox<span class="label label-primary pull-right"><?= $vendorCount ?></span></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-9">

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3><?= h($message->title) ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <?php foreach($message->message_messages as $message_message) { ?>
                            <div class="mailbox-read-info">
                                <?php if($message_message->from_user == 1) { ?>
                                <h5>From: <?= $message->user->username ?>
                                    <span class="mailbox-read-time pull-right"><?= $message_message->created ?></span></h5>
                                <?php } else { ?>
                                <h5>From: <?= $message->vendor->title ?>
                                    <span class="mailbox-read-time pull-right"><?= $message_message->created ?></span></h5>
                                <?php } ?>
                            </div>
                            <!-- /.mailbox-controls -->
                            <div class="mailbox-read-message">
                                <p><?= $message_message->body ?></p>
                            </div>

                            <?php } ?>
                            <!-- /.mailbox-read-message -->
                        </div>
                    </div>
                    <!-- /. box -->
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4>Reply</h4>
                        </div>
                        <?= $this->Form->create(null, ['url' => '/message-send']); ?>
                        <div class="box-body">
                            <textarea style="width:100%" rows="10" name="reply_field" required></textarea>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <?= $this->Form->button('<i class="fa fa-envelope-o"></i> Send', ['escape' => false, 'class' => 'btn btn-primary']) ?>
                            </div>
                            <input type="checkbox" name="reply_encrypt" id="reply_encrypt" /> <label for="reply_encrypt">Encrypt Message on Server</label>
                        </div>
                        <?= $this->Form->unlockField('reply_field') ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php if($username == $message->user->username) { ?>
                    <h4><?= $message->vendor->title ?> PGP Key</h4>
                    <?php } else { ?>
                    <h4><?= $message->user->username ?> PGP Key</h4>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <textarea style="width:100%" rows="15"><?php if($username == $message->user->username) { echo $vendor_pgp; } else { echo $message->user->pgp; } ?></textarea>
                </div>
            </div>
        </div>
    </div>
</section>
