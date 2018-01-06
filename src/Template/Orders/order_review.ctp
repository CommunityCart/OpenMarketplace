<section class="content-header">
    <div class="container-fluid">
        <?php if($balance == 'low') { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4 style="display:inline-block;"><b>Insufficient Funds: </b>Your account balance is to low to make this purchase, You are missing <?= $this->Number->currency($missingBalance) ?> USD</h4>&nbsp;<a href="/wallet" class="btn btn-success" style="float:right;">Click Here to Deposit <?= $this->Number->currency($missingBalance) ?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <h4>
            Please review your order for <?= h($product->title) ?>
        </h4>
    </div>
</section>
<style>
    .checked {
        color: orange;
    }
</style>
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
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
                                    <a href="/products/view/<?= $id ?>?image_index=<?= $x ?>&"><img
                                            src="<?= str_replace(WWW_ROOT, '/', $pImage->image_thumbnail) ?>"/></a>
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
                                            <span><a href="/vendor/<?= $product->vendor->id ?>"><?= $product->vendor->user->username ?></a>&nbsp;&nbsp;(<?= $vendorOrderCount ?> / <?= $vendorRating ?>)</span>
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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Cost Calculations</h4><hr/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                           <?= $shipping_options->shipping_carrier . ' - ' . $shipping_options->shipping_name ?>
                                        </div>
                                        <div class="col-md-6 pull-right">
                                            <?= $shipping_options->shipping_cost ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                           <?= 'Quantity of ' . $order->quantity ?> x <?= $product->cost ?>
                                        </div>
                                        <div class="col-md-6 pull-right">
                                            <?= $order->quantity * $product->cost ?>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            Total
                                        </div>
                                        <div class="col-md-6 pull-right">
                                            <span><?= $this->Number->currency(($order->quantity * $product->cost) + $shipping_options->shipping_cost) ?></span>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            Available Balance
                                        </div>
                                        <div class="col-md-6 pull-right">
                                            <span><?= $this->Number->currency($totalBalance, 'USD', ['precision' => 3]) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <?php if($balance == 'low') { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="/wallet" class="btn btn-success btn-block">Click Here to Deposit <?= $this->Number->currency($missingBalance) ?></a>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <span>Use Orders link on the left to get back to this page</span>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="/wallet" class="btn btn-success btn-block">Click Here Submit Order</a>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>