<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Shipping Options
    <div class="pull-right"><?= $this->Html->link(__('New'), ['action' => 'add'], ['class'=>'btn btn-success btn-xs']) ?></div>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= __('List of') ?> Shipping Options</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <th><?= $this->Paginator->sort('shipping_name') ?></th>
                <th><?= $this->Paginator->sort('shipping_carrier') ?></th>
                <th><?= $this->Paginator->sort('shipping_cost') ?></th>
                <th><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($shippingOptions as $shippingOption): ?>
              <tr>
                <td><?= h($shippingOption->shipping_name) ?></td>
                <td><?= h($shippingOption->shipping_carrier) ?></td>
                <td><?= h($shippingOption->shipping_cost) ?></td>
                <td class="actions" style="white-space:nowrap">
                  <?= $this->Html->link(__('View'), ['action' => 'view', $shippingOption->id], ['class'=>'btn btn-info btn-xs']) ?>
                  <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shippingOption->id], ['class'=>'btn btn-warning btn-xs']) ?>
                  <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shippingOption->id], ['confirm' => __('Confirm to delete this entry?'), 'class'=>'btn btn-danger btn-xs']) ?>
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
