<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Orders
    <div class="pull-right"><?= $this->Html->link(__('New'), ['action' => 'add'], ['class'=>'btn btn-success btn-xs']) ?></div>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= __('List of') ?> Orders</h3>
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
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('product_id') ?></th>
                <th><?= $this->Paginator->sort('status') ?></th>
                <th><?= $this->Paginator->sort('shipping_option_id') ?></th>
                <th><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>

            <?php foreach ($orders as $order): ?>
              <tr>
                <td><?= $this->Number->format($order->id) ?></td>
                <td><?= $order->has('user') ? $this->Html->link($order->user->username, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
                <td><?= $order->has('product') ? $this->Html->link($order->product->title, ['controller' => 'Products', 'action' => 'view', $order->product->id]) : '' ?></td>

                <td><?= $this->Number->format($order->status) ?></td>

                <td><?= $order->has('shipping_option') ? $this->Html->link($order->shipping_option->shipping_name, ['controller' => 'ShippingOptions', 'action' => 'view', $order->shipping_option->id]) : '' ?></td>
                <td class="actions" style="white-space:nowrap">
                  <?= $this->Html->link(__('View'), ['action' => 'orderReview2', $order->id], ['class'=>'btn btn-info btn-xs']) ?>

                  <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $order->id], ['confirm' => __('Confirm to delete this entry?'), 'class'=>'btn btn-danger btn-xs']) ?>
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
