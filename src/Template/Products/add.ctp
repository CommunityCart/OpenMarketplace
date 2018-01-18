<section class="content-header">
  <h1>
    Product
    <small><?= __('Add') ?></small>
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
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= __('Form') ?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?= $this->Form->create($product, array('role' => 'form')) ?>
          <div class="box-body">
            <?php echo $this->Form->input('title');
            echo $this->Form->input('body');
            ?>
            <div class="row">
              <div class="col-md-3">
              <?php echo $this->Form->input('cost', ['label' => 'Product Price in USD']); ?>
              </div>
              <div class="col-md-3">
              <?php echo $this->Form->input('product_category_id'); ?>
              </div>
              <div class="col-md-3">
              <?php echo $this->Form->input('country_id', ['label' => 'Ships From Country']); ?>
              </div>
              <div class="col-md-3">
                <?php echo $this->Form->input('countries', ['type' => 'select', 'multiple' => true, 'options' => $shipToOptions, 'label' => 'Ships To Countries']); ?>
              </div>
            </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <span>Images can be added from the product edit page after saving.</span>
            <?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary pull-right']) ?>
          </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</section>

