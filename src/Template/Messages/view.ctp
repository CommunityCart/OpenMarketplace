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
                                    <?= $message->has('user') ? $message->user->username : '' ?>
                                </dd>
                                                                                                                <dt><?= __('Vendor') ?></dt>
                                <dd>
                                    <?= $message->has('vendor') ? $message->vendor->title : '' ?>
                                </dd>
                                                                                                                        <dt><?= __('Title') ?></dt>
                                        <dd>
                                            <?= h($message->title) ?>
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
                    <h3 class="box-title"><?= __('Related {0}', ['Message Messages']) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                <?php if (!empty($message->message_messages)): ?>

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                                                    
                                    <th>
                                    Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Message Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Body
                                    </th>
                                        
                                                                                                        
                                <th>
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>

                            <?php foreach ($message->message_messages as $messageMessages): ?>
                                <tr>
                                                                        
                                    <td>
                                    <?= h($messageMessages->id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($messageMessages->message_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($messageMessages->body) ?>
                                    </td>
                                                                        
                                                                        <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'MessageMessages', 'action' => 'view', $messageMessages->id], ['class'=>'btn btn-info btn-xs']) ?>

                                    <?= $this->Html->link(__('Edit'), ['controller' => 'MessageMessages', 'action' => 'edit', $messageMessages->id], ['class'=>'btn btn-warning btn-xs']) ?>

                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MessageMessages', 'action' => 'delete', $messageMessages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $messageMessages->id), 'class'=>'btn btn-danger btn-xs']) ?>    
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
