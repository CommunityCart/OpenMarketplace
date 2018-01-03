<section class="content-header">
  <h1>
    <?php echo __('Wallet'); ?>
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
                                    <?= $wallet->has('user') ? $wallet->user->username : '' ?>
                                </dd>
                                                                                                                <dt><?= __('Currency') ?></dt>
                                <dd>
                                    <?= $wallet->has('currency') ? $wallet->currency->name : '' ?>
                                </dd>
                                                                                                
                                            
                                                                                                                                            
                                                                                                                                            
                                            
                                                                        <dt><?= __('Address') ?></dt>
                            <dd>
                            <?= $this->Text->autoParagraph(h($wallet->address)); ?>
                            </dd>
                                                    <dt><?= __('Private Key') ?></dt>
                            <dd>
                            <?= $this->Text->autoParagraph(h($wallet->private_key)); ?>
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
                    <h3 class="box-title"><?= __('Related {0}', ['Wallet Transactions']) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                <?php if (!empty($wallet->wallet_transactions)): ?>

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                                                    
                                    <th>
                                    Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Wallet Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Transaction Hash
                                    </th>
                                        
                                                                    
                                    <th>
                                    Transaction Details
                                    </th>
                                        
                                                                    
                                    <th>
                                    Balance
                                    </th>
                                        
                                                                                                        
                                <th>
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>

                            <?php foreach ($wallet->wallet_transactions as $walletTransactions): ?>
                                <tr>
                                                                        
                                    <td>
                                    <?= h($walletTransactions->id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($walletTransactions->wallet_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($walletTransactions->transaction_hash) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($walletTransactions->transaction_details) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($walletTransactions->balance) ?>
                                    </td>
                                                                        
                                                                        <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'WalletTransactions', 'action' => 'view', $walletTransactions->id], ['class'=>'btn btn-info btn-xs']) ?>

                                    <?= $this->Html->link(__('Edit'), ['controller' => 'WalletTransactions', 'action' => 'edit', $walletTransactions->id], ['class'=>'btn btn-warning btn-xs']) ?>

                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'WalletTransactions', 'action' => 'delete', $walletTransactions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $walletTransactions->id), 'class'=>'btn btn-danger btn-xs']) ?>    
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
