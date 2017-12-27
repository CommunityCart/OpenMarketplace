<section class="content-header">
  <h1>
    Product
    <small><?= __('Edit') ?></small>
  </h1>
  <ol class="breadcrumb">
    <li>
    <?= $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Back'), ['action' => 'index'], ['escape' => false]) ?>
    </li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Product</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?= $this->Form->create($product, array('role' => 'form')) ?>
          <div class="box-body">
          <?php
            echo $this->Form->input('vendor_id');
            echo $this->Form->input('title');
            echo $this->Form->input('body');
            echo $this->Form->input('cost');
            echo $this->Form->input('product_category_id');
            echo $this->Form->input('country_id');
          ?>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <?= $this->Form->button(__('Save')) ?>
          </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Images</h3>
          </div>
          <div class="box-body">
            <?php
            echo $this->Form->create($image, ['url' => '/images/add/' . $product_id, 'enctype' => 'multipart/form-data']);
            echo $this->Form->input('upload', ['type' => 'file']);
            echo $this->Form->button('Upload Image', ['class' => 'btn btn-lg btn-primary btn-block padding-t-b-15']);
            echo $this->Form->end();
            ?>
          </div>
      </div>
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Images</h3>
          </div>
          <div class="box-body">
            <?php foreach($images as $img) { ?>
            <?= $this->Form->postLink($this->Html->image(str_replace(WWW_ROOT, '/', $img->image_thumbnail)), ['controller' => 'ProductImages', 'action' => 'delete', $img->id], ['escape' => false, 'confirm' => __('Confirm to delete this entry?'), 'class'=>'btn btn-danger btn-xs']) ?>

            <?php } ?>
          </div>
        </div>
      </div>
  </div>
</section>

