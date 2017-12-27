<section class="content-header">
  <h1>
    <?php echo __('Vendor'); ?>
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
                                    <?= $vendor->has('user') ? $vendor->user->username : '' ?>
                                </dd>
                                                                                                                        <dt><?= __('Title') ?></dt>
                                        <dd>
                                            <?= h($vendor->title) ?>
                                        </dd>
                                                                                                                                    
                                            
                                                                                                                                            
                                                                                                                                                                                                                <dt><?= __('Last Active') ?></dt>
                                <dd>
                                    <?= h($vendor->last_active) ?>
                                </dd>
                                                                                                    
                                            
                                                                        <dt><?= __('Tos') ?></dt>
                            <dd>
                            <?= $this->Text->autoParagraph(h($vendor->tos)); ?>
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
                    <h3 class="box-title"><?= __('Related {0}', ['Messages']) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                <?php if (!empty($vendor->messages)): ?>

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
                                    Vendor Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Title
                                    </th>
                                        
                                                                                                        
                                <th>
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>

                            <?php foreach ($vendor->messages as $messages): ?>
                                <tr>
                                                                        
                                    <td>
                                    <?= h($messages->id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($messages->user_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($messages->vendor_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($messages->title) ?>
                                    </td>
                                                                        
                                                                        <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Messages', 'action' => 'view', $messages->id], ['class'=>'btn btn-info btn-xs']) ?>

                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Messages', 'action' => 'edit', $messages->id], ['class'=>'btn btn-warning btn-xs']) ?>

                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Messages', 'action' => 'delete', $messages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $messages->id), 'class'=>'btn btn-danger btn-xs']) ?>    
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
                    <h3 class="box-title"><?= __('Related {0}', ['Products']) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                <?php if (!empty($vendor->products)): ?>

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                                                    
                                    <th>
                                    Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Vendor Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Title
                                    </th>
                                        
                                                                    
                                    <th>
                                    Desc
                                    </th>
                                        
                                                                    
                                    <th>
                                    Cost
                                    </th>
                                        
                                                                    
                                    <th>
                                    Product Category Id
                                    </th>
                                        
                                                                    
                                    <th>
                                    Country Id
                                    </th>
                                        
                                                                                                                                            
                                <th>
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>

                            <?php foreach ($vendor->products as $products): ?>
                                <tr>
                                                                        
                                    <td>
                                    <?= h($products->id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($products->vendor_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($products->title) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($products->desc) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($products->cost) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($products->product_category_id) ?>
                                    </td>
                                                                        
                                    <td>
                                    <?= h($products->country_id) ?>
                                    </td>
                                                                                                            
                                                                        <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Products', 'action' => 'view', $products->id], ['class'=>'btn btn-info btn-xs']) ?>

                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Products', 'action' => 'edit', $products->id], ['class'=>'btn btn-warning btn-xs']) ?>

                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Products', 'action' => 'delete', $products->id], ['confirm' => __('Are you sure you want to delete # {0}?', $products->id), 'class'=>'btn btn-danger btn-xs']) ?>    
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
