<section class="content-header">
    <h1>
        <?= h($product->title) ?>
    </h1>
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
                                <?php if(count($product->product_images) > $image_index && file_exists(WWW_ROOT . $product->product_images[$image_index]->image_display)) { ?>
                                <img src="<?= $product->product_images[$image_index]->image_display ?>" width="600px" ?>
                                <?php } else { ?>
                                <img src="/img/avatar.png" width="600px" />
                                <?php } ?>
                            </div>
                        </div>
                        <br/>
                        <div class="row">

                            <?php $x = 0; ?>
                            <?php foreach($product->product_images as $pImage) { ?>

                                <div class="col-md-3">
                                    <?php if(file_exists(WWW_ROOT . $pImage->image_thumbnail)) { ?>
                                    <a href="/products/view/<?= $id ?>?image_index=<?= $x ?>&"><img src="<?= str_replace(WWW_ROOT, '/', $pImage->image_thumbnail) ?>"/></a>
                                    <?php } ?>
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
                                        <span><a href="/vendor/<?= $product->vendor->id ?>"><?= $product->vendor->user->username ?></a>&nbsp;&nbsp;(<?= $vendorOrderCount ?>) (<?= $vendorRating ?> Stars)</span>
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
                                        <?php $x = 0; ?>
                                        <?php for($i = 0; $i < $product->rating; $i++) { ?>
                                        <span class="fa fa-star checked"></span>
                                        <?php $x = $x + 1; ?>
                                        <?php } ?>
                                        <?php for($y = $x; $y < 5; $y++) { ?>
                                        <span class="fa fa-star"></span>
                                        <?php } ?>
                                        &nbsp;&nbsp;(<?= $productOrderCount ?>)
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
    <div class="row">
        <div class="col-md-offset-0 col-md-6">
            <pre><?php $parser = new \cebe\markdown\Markdown(); echo $parser->parse($product->vendor->tos); ?></pre>
        </div>
        <div class="col-md-6">
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Stars</th>
                    <th>Comment</th>
                    <th>Timestamp</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($reviews as $review) { ?>
                    <tr>
                        <td nowrap="true"><?php $x = 0; ?>
                            <?php for($i = 0; $i < $review->stars; $i++) { ?>
                            <span class="fa fa-star checked"></span>
                            <?php $x = $x + 1; ?>
                            <?php } ?>
                            <?php for($y = $x; $y < 5; $y++) { ?>
                            <span class="fa fa-star"></span>
                            <?php } ?></td>
                        <td><?= $review->comment ?></td>
                        <td><?= $review->created ?></td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
                </div>
            </div>
        </div>
    </div>
    <!-- div -->

</section>
