<section class="content-header">
  <h1>
    <?php echo __('Wallet Transaction'); ?>
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
                                                                                                        <dt><?= __('Wallet') ?></dt>
                                <dd>
                                    <?= $walletTransaction->has('wallet') ? $walletTransaction->wallet->id : '' ?>
                                </dd>
                                                                                                                        <dt><?= __('Transaction Hash') ?></dt>
                                        <dd>
                                            <?= h($walletTransaction->transaction_hash) ?>
                                        </dd>
                                                                                                                                    
                                            
                                                                                                                                                            <dt><?= __('Balance') ?></dt>
                                <dd>
                                    <?= $this->Number->format($walletTransaction->balance) ?>
                                </dd>
                                                                                                
                                                                                                                                            
                                            
                                                                        <dt><?= __('Transaction Details') ?></dt>
                            <dd>
                            <?= $this->Text->autoParagraph(h($walletTransaction->transaction_details)); ?>
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
                    <h3 class="box-title"><?= __('Related {0}', ['Orders']) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                <?php if (!empty($walletTransaction->orders)): ?>

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                                                    
                                    <th>
                                    Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    User Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Product Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Wallet Transaction Id
                                    </th>
                                        
                                                                                                        
                                    <th>
                                    Status
                                    </th>
                                        
                                                                    
                                    <th>
                                    Shipping Option Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Quantity
                                    </th>
                                        
                                                                    
                                <th>
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>

                            <?php foreach ($walletTransaction->orders as $orders): ?>
                                <tr>
                                                                        
                                    <td>
                                    <?= h($orders->id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($orders->user_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($orders->product_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($orders->wallet_transaction_id) ?>
                                    </td>
                                                                                                            
                                    <td>
                                    <?= h($orders->status) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($orders->shipping_option_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($orders->quantity) ?>
                                    </td>
                                    
                                                                        <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id], ['class'=>'btn btn-info btn-xs']) ?>

                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id], ['class'=>'btn btn-warning btn-xs']) ?>

                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id), 'class'=>'btn btn-danger btn-xs']) ?>    
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
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <i class="fa fa-share-alt"></i>
                    <h3 class="box-title"><?= __('Related {0}', ['User Transactions']) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                <?php if (!empty($walletTransaction->user_transactions)): ?>

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                                                    
                                    <th>
                                    Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    User Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Wallet Transaction Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Is Withdrawal
                                    </th>
                                        
                                                                                                        
                                <th>
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>

                            <?php foreach ($walletTransaction->user_transactions as $userTransactions): ?>
                                <tr>
                                                                        
                                    <td>
                                    <?= h($userTransactions->id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($userTransactions->user_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($userTransactions->wallet_transaction_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($userTransactions->is_withdrawal) ?>
                                    </td>
                                                                        
                                                                        <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'UserTransactions', 'action' => 'view', $userTransactions->id], ['class'=>'btn btn-info btn-xs']) ?>

                                    <?= $this->Html->link(__('Edit'), ['controller' => 'UserTransactions', 'action' => 'edit', $userTransactions->id], ['class'=>'btn btn-warning btn-xs']) ?>

                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserTransactions', 'action' => 'delete', $userTransactions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userTransactions->id), 'class'=>'btn btn-danger btn-xs']) ?>    
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
