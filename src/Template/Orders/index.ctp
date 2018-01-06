<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Shopping Cart
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <th><?= $this->Paginator->sort('product_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('shipping_option_id') ?></th>
                <th>Total Cost in USD</th>
                <th><?= $this->Paginator->sort('status') ?></th>
                <th><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>

            <?php foreach ($orders as $order): ?>
              <tr>

                <td><?= $order->has('product') ? $this->Html->link($order->product->title, ['controller' => 'Products', 'action' => 'view', $order->product->id]) : '' ?></td>
                <td><?= $order->quantity ?></td>

                <?php
                  $status = '';
                  switch($order->status) {
                      case 0:
                        $status = 'Insufficient funds';
                        break;
                      case 1:
                        $status = 'Pending Place Order';
                        break;
                      case 2:
                        $status = 'Pending Vendor Acceptance';
                        break;
                      case 3:
                        $status = 'Pending Shipment';
                        break;
                      case 4:
                        $status = 'Order Shipped';
                        break;
                      case 5:
                        $status = 'Order Rejected by Vendor';
                        break;
                  }

                $totalCost = ($order->product->cost * $order->quantity) + $order->shipping_option->shipping_cost;
                ?>

                <td><?= $order->has('shipping_option') ? $this->Html->link($order->shipping_option->shipping_name, ['controller' => 'ShippingOptions', 'action' => 'view', $order->shipping_option->id]) : '' ?></td>
                <td><?= $this->Number->currency($totalCost) ?></td>
                <td><?= $status ?></td>
                <td class="actions" style="white-space:nowrap">

                  <?php if($order->status == 0) { ?>
                  <?= $this->Html->link(__('Make Deposit'), ['controller' => 'Wallet', 'action' => 'index'], ['class'=>'btn btn-success btn-xs']) ?>
                  <?= $this->Html->link(__('View'), ['action' => 'orderReview2', $order->id], ['class'=>'btn btn-info btn-xs']) ?>
                  <?php } else { ?>
                  <?= $this->Html->link(__('Place Order'), ['controller' => 'Orders', 'action' => 'orderReview2', $order->id], ['class'=>'btn btn-success btn-xs']) ?>
                  <?php } ?>

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
