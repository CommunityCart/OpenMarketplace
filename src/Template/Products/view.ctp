<section class="content-header">
  <h1>
    <?php echo __('Product'); ?>
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
                                                                                                                <dt><?= __('Title') ?></dt>
                                        <dd>
                                            <?= h($product->title) ?>
                                        </dd>
                                                                                                                                    
                                            
                                                                                                                                                            <dt><?= __('Vendor Id') ?></dt>
                                <dd>
                                    <?= $this->Number->format($product->vendor_id) ?>
                                </dd>
                                                                                                                <dt><?= __('Cost') ?></dt>
                                <dd>
                                    <?= $this->Number->format($product->cost) ?>
                                </dd>
                                                                                                                <dt><?= __('Product Category Id') ?></dt>
                                <dd>
                                    <?= $this->Number->format($product->product_category_id) ?>
                                </dd>
                                                                                                                <dt><?= __('Country Id') ?></dt>
                                <dd>
                                    <?= $this->Number->format($product->country_id) ?>
                                </dd>
                                                                                                
                                                                                                                                                                                                
                                            
                                                                        <dt><?= __('Desc') ?></dt>
                            <dd>
                            <?= $this->Text->autoParagraph(h($product->body)); ?>
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

</section>
