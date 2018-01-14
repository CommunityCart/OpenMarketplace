<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?= $title ?>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <?php if($title == 'Incoming Orders') { ?>
        <?= $this->Form->create('null', ['url' => '/incoming-bulk']) ?>
        <?php } ?>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <?php if($title == 'Incoming Orders') { ?>
                <th></th>
                <?php } ?>
                <?php if($title != 'Shopping Cart') { ?>
                    <th>Username</th>
                <?php } ?>
                <th><?= $this->Paginator->sort('product_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('shipping_option_id') ?></th>
                <th>USD</th>
                <th><?= $this->Paginator->sort('status') ?></th>
                <th><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>

            <?php foreach ($orders as $order): ?>
              <tr>
                <?php if($order->status == 2 && $title == 'Incoming Orders') { ?>
                <td><input type="checkbox" name="bulk[]" value="<?= $order->id ?>" /></td>
                <?php } ?>
                <?php if($title != 'Shopping Cart') { ?>
                <td><?= $order->user->username ?></td>
                <?php } ?>
                <td><?= $order->has('product') ? $this->Html->link($order->product->title, ['controller' => 'Products', 'action' => 'view', $order->product->id]) : '' ?></td>
                <td><?= $order->quantity ?></td>

                <?php
                  $status = '';
                  switch($order->status) {
                      case -2:
                        $status = 'Order Disputed by User';
                        break;
                      case -1:
                        $status = 'Order Rejected by Vendor';
                        break;
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
                        $status = 'Order Finalized';
                        break;
                      case 6:
                        $status = 'Order Rated';
                        break;
                  }

                $totalCost = ($order->product->cost * $order->quantity) + $order->shipping_option->shipping_cost;
                ?>

                <td><?= $order->has('shipping_option') ? $this->Html->link($order->shipping_option->shipping_name, ['controller' => 'ShippingOptions', 'action' => 'view', $order->shipping_option->id]) : '' ?></td>
                <td><?= $this->Number->currency($totalCost) ?></td>
                <td><?= $status ?></td>
                <td class="actions" style="white-space:nowrap">

                  <?php if($order->status == 0 && $title == 'Shopping Cart') { ?>
                  <?= $this->Html->link(__('Make Deposit'), ['controller' => 'Wallet', 'action' => 'index'], ['class'=>'btn btn-success btn-xs']) ?>
                  <?= $this->Html->link(__('View'), ['action' => 'orderReview2', $order->id], ['class'=>'btn btn-info btn-xs']) ?>
                  <?php } else if($order->status == 1 && $title == 'Shopping Cart') { ?>
                  <?= $this->Html->link(__('Place Order'), ['controller' => 'Orders', 'action' => 'orderReview2', $order->id], ['class'=>'btn btn-success btn-xs']) ?>
                  <?php } else if($order->status == 5 && $title == 'Shopping Cart') { ?>
                  <?= $this->Html->link(__('Review Order'), ['action' => 'orderReview2', $order->id], ['class'=>'btn btn-xs btn-success']) ?>
                  <?php } else if($order->status == 6 && $title == 'Shopping Cart') { ?>
                  <?= $this->Html->link(__('Update Review'), ['action' => 'orderReview2', $order->id], ['class'=>'btn btn-xs btn-success']) ?>
                  <?php } else { ?>
                  <?= $this->Html->link(__('View'), ['action' => 'orderReview2', $order->id], ['class'=>'btn btn-info btn-xs']) ?>
                  <?php } ?>

                  <?php if($order->status == -2 && $title == 'Disputed Orders') { ?>
                  <?= $this->Html->link(__('Full Refund'), ['controller' => 'Orders', 'action' => 'fullRefund', $order->id], ['class'=>'btn btn-success btn-xs']) ?>
                  <?= $this->Html->link(__('50% Refund'), ['controller' => 'Orders', 'action' => 'halfRefund', $order->id], ['class'=>'btn btn-success btn-xs']) ?>
                  <?php } ?>

                  <?php if($order->status == 2 && $title == 'Incoming Orders') { ?>
                  <?= $this->Html->link(__('Accept Order'), ['controller' => 'Orders', 'action' => 'accept', $order->id], ['class'=>'btn btn-success btn-xs']) ?>
                  <?= $this->Html->link(__('Reject Order'), ['controller' => 'Orders', 'action' => 'reject', $order->id], ['class'=>'btn btn-danger btn-xs']) ?>
                  <?php } ?>

                  <?php if($order->status == 2 && $title == 'Shopping Cart') { ?>
                  <?= $this->Html->link(__('Cancel Order'), ['controller' => 'Orders', 'action' => 'delete', $order->id], ['class'=>'btn btn-danger btn-xs']) ?>
                  <?php } ?>

                  <?php if(($order->status == 0 || $order->status == 1 || $order->status == -1) && $title == 'Shopping Cart') { ?>
                  <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $order->id], ['confirm' => __('Confirm to delete this entry?'), 'class'=>'btn btn-danger btn-xs']) ?>
                  <?php } ?>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <div class="row pull-right">
            <?php if($title == 'Incoming Orders') { ?>
            <div class="col-md-4"><?= $this->Form->button(__('Accept Checked Orders'), ['class' => 'btn btn-success', 'name' => 'submit', 'value' => 'accept']) ?></div>
            <div class="col-md-4 col-md-offset-2"><?= $this->Form->button(__('Reject Checked Orders'), ['class' => 'btn btn-danger', 'name' => 'submit', 'value' => 'reject']) ?></div>
            <?php } ?>
          </div>
          <?php if($title == 'Incoming Orders') { ?>
          <?= $this->Form->unlockField('bulk') ?>
          <?= $this->Form->end() ?>
          <?php } ?>
        </div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
