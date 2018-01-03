<section class="content-header">
  <h1>
    <?php echo __('Order'); ?>
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
                                    <?= $order->has('user') ? $order->user->username : '' ?>
                                </dd>
                                                                                                                <dt><?= __('Product') ?></dt>
                                <dd>
                                    <?= $order->has('product') ? $order->product->title : '' ?>
                                </dd>
                                                                                                                <dt><?= __('Wallet Transaction') ?></dt>
                                <dd>
                                    <?= $order->has('wallet_transaction') ? $order->wallet_transaction->id : '' ?>
                                </dd>
                                                                                                                <dt><?= __('Shipping Option') ?></dt>
                                <dd>
                                    <?= $order->has('shipping_option') ? $order->shipping_option->id : '' ?>
                                </dd>
                                                                                                
                                            
                                                                                                                                                            <dt><?= __('Status') ?></dt>
                                <dd>
                                    <?= $this->Number->format($order->status) ?>
                                </dd>
                                                                                                                <dt><?= __('Quantity') ?></dt>
                                <dd>
                                    <?= $this->Number->format($order->quantity) ?>
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
                    <h3 class="box-title"><?= __('Related {0}', ['Disputes']) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                <?php if (!empty($order->disputes)): ?>

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                                                    
                                    <th>
                                    Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Order Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Comment
                                    </th>
                                        
                                                                                                        
                                <th>
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>

                            <?php foreach ($order->disputes as $disputes): ?>
                                <tr>
                                                                        
                                    <td>
                                    <?= h($disputes->id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($disputes->order_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($disputes->comment) ?>
                                    </td>
                                                                        
                                                                        <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Disputes', 'action' => 'view', $disputes->id], ['class'=>'btn btn-info btn-xs']) ?>

                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Disputes', 'action' => 'edit', $disputes->id], ['class'=>'btn btn-warning btn-xs']) ?>

                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Disputes', 'action' => 'delete', $disputes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $disputes->id), 'class'=>'btn btn-danger btn-xs']) ?>    
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
                    <h3 class="box-title"><?= __('Related {0}', ['Reviews']) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                <?php if (!empty($order->reviews)): ?>

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                                                    
                                    <th>
                                    Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Order Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Comment
                                    </th>
                                        
                                                                    
                                    <th>
                                    Stars
                                    </th>
                                        
                                                                                                                                            
                                <th>
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>

                            <?php foreach ($order->reviews as $reviews): ?>
                                <tr>
                                                                        
                                    <td>
                                    <?= h($reviews->id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($reviews->order_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($reviews->comment) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($reviews->stars) ?>
                                    </td>
                                                                                                            
                                                                        <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Reviews', 'action' => 'view', $reviews->id], ['class'=>'btn btn-info btn-xs']) ?>

                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Reviews', 'action' => 'edit', $reviews->id], ['class'=>'btn btn-warning btn-xs']) ?>

                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Reviews', 'action' => 'delete', $reviews->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reviews->id), 'class'=>'btn btn-danger btn-xs']) ?>    
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
