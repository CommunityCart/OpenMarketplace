<section class="content-header">
    <div class="container-fluid">
        <?php if($balance == 'low') { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Your account balance is to low to make this purchase, You are missing <?= $this->Number->currency($missingBalance) ?></h4>
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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Cost Calculations</h4><hr/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            USPS - First Class
                                        </div>
                                        <div class="col-md-6 pull-right">
                                            $15.00
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                           1 x $4000.25
                                        </div>
                                        <div class="col-md-6 pull-right">
                                            $4000.25
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            Total
                                        </div>
                                        <div class="col-md-6 pull-right">
                                            <span>$4015.25</span>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            Available Balance
                                        </div>
                                        <div class="col-md-6 pull-right">
                                            <span>$15.25</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="/wallet/deposit" class="btn btn-success btn-block">Click Here to Deposit $4000</a>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <span>Use Orders link on the left to get back to this page</span>
                                </div>
                            </div>
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