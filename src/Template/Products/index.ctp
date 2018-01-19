<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Products
    <?php if($shippingOptionsCount == 0) { ?>
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h4 style="display:inline-block;"><b>No Shipping Options Found: </b>You must create your shipping options before your products.</h4>&nbsp;<a href="/settings/shipping" class="btn btn-success" style="float:right;">Click Here to Create Shipping Options</a>
          </div>
        </div>
      </div>
    </div>
    <?php } else { ?>
    <div class="pull-right"><?= $this->Html->link(__('New'), ['action' => 'add'], ['class'=>'btn btn-success btn-lg btn-block']) ?></div>
    <?php } ?>
  </h1>
</section>
<br/>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= __('List of') ?> Products</h3>
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
                <th>Thumbnail</th>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('cost') ?></th>
                <th><?= $this->Paginator->sort('product_category_id') ?></th>
                <th><?= $this->Paginator->sort('country_id') ?></th>
                <th><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
              <tr>
                <?php if(count($product->product_images) > 0 && file_exists(WWW_ROOT . $product->product_images[0]->image_thumbnail)) { ?>
                <td><?= $this->Html->image($product->product_images[0]->image_thumbnail); ?></td>
                <?php } else { ?>
                <td><img src="/img/avatar.png" width="150px" /></td>
                <?php } ?>
                <td style="width:100%"><?= h($product->title) ?></td>
                <td><?= $this->Number->format($product->cost) ?></td>
                <td nowrap="true"><?= $product->product_category->category_name ?></td>
                <td nowrap="true"><?= $product->country->name ?></td>
                <td class="actions" style="white-space:nowrap">
                  <?= $this->Html->link(__('View'), ['action' => 'view', $product->id], ['class'=>'btn btn-info btn-xs']) ?>
                  <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id], ['class'=>'btn btn-warning btn-xs']) ?>
                  <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id], ['confirm' => __('Confirm to delete this entry?'), 'class'=>'btn btn-danger btn-xs']) ?>
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
