<section class="content-header">
    <h1>
        <?= h($product->title) ?>
    </h1>
    <ol class="breadcrumb">
        <li>
            <?= $this->Html->link('<i class="fa fa-dashboard"></i> ' . __('Back'), ['action' => 'index'], ['escape' =>
            false])?>
        </li>
    </ol>
</section>
<style>
    .checked {
        color: orange;
    }
</style>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6">
                                <img src="<?= str_replace(WWW_ROOT, '/', $product->product_images[$image_index]->image_display) ?>"/>

                            </div>
                        </div>
                        <br/>
                        <div class="row">

                            <?php $x = 0; ?>
                            <?php foreach($product->product_images as $pImage) { ?>

                                <div class="col-md-3">
                                    <a href="/products/view/<?= $id ?>?image_index=<?= $x ?>&"><img src="<?= str_replace(WWW_ROOT, '/', $pImage->image_thumbnail) ?>"/></a>
                                </div>

                            <?php $x = $x + 1; ?>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Vendor</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span><a href="/vendor/<?= $product->vendor->id ?>"><?= $product->vendor->user->username ?></a>&nbsp;&nbsp;(11,500 / 4.94)</span>
                                    </div>
                                </div>
                                <hr/>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Product Rating</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        &nbsp;&nbsp;(1,500)
                                    </div>
                                </div>
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <a href="/products/flag/<?= $product->id ?>" class="btn btn-danger">Flag as Inappropriate</a>
                            </div>
                            <div class="col-md-5">
                                <a href="/products/favorite/<?= $product->id ?>" class="btn btn-primary">Add to favorites</a>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 style="font-size:16px;"><?= h($product->body) ?></h6>
                            </div>
                        </div>
                        <hr/>
                        <?= $this->Form->create(null, ['url' => '/order/' . $product->id]); ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Shipping Options</h4><hr/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="form-group">
                                                <select class="form-control" name="shipping_options">
                                                    <?php foreach($product->vendor->shipping_options as $shippingOption) { ?>
                                                    <option value="<?= $shippingOption->id ?>"><?= $shippingOption->shipping_carrier . ' - ' . $shippingOption->shipping_name . ' - ' . $shippingOption->shipping_cost  ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Quantity</h4><hr/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="form-group">
                                                <input name="quantity" class="form-control" type="text" style="text-align: right;" placeholder="Enter Quantity" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h2 style="display:inline-block"><?= $this->Number->currency($product->cost) ?></h2>&nbsp;&nbsp;per unit
                                <hr/>
                            </div>
                            <div class="col-md-6">
                                <br/>
                                <?= $this->Form->unlockField('shipping_options') ?>
                                <?= $this->Form->unlockField('quantity') ?>
                                <?= $this->Form->button(__('Review Order'), ['class' => 'btn btn-success btn-lg btn-block']) ?>
                            </div>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- ./col -->
    </div>
    <!-- div -->

</section>
