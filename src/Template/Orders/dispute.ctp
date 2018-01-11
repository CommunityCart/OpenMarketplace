<section class="content-header">
    <h1>
        Open Dispute
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= $this->Form->create('null', ['url' => '/open-dispute/' . $order->id]); ?>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-info"></i>
                    <h3 class="box-title"><?php echo __('Information'); ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Please Select One of The Following</h4>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="radio" name="dispute_radio" value="null_route" style="display:inline-block" />
                                    <h4 style="display:inline-block">&nbsp;Order Never Arrived</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="radio" name="dispute_radio" value="wrong" style="display:inline-block" />
                                    <h4 style="display:inline-block">&nbsp;Wrong Product</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="radio" name="dispute_radio" value="quality" style="display:inline-block" />
                                    <h4 style="display:inline-block">&nbsp;Product Not As Described</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="radio" name="dispute_radio" value="other" style="display:inline-block" />
                                    <h4 style="display:inline-block">&nbsp;Other</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea name="other_comment" rows="5" style="width:100%;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><?= $product->title ?></h4>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Vendor: <b><?= $vendor_user->username ?></b></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Vendor Rating: <b><?= $vendor->rating ?></b></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Vendor Orders: <b><?= $vendor->total_reviews ?></b></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Product Rating: <b><?= $product->rating ?></b></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Product Cost: <b><?= $product->cost ?></b></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Shipping Option: <b><?= $shipping->shipping_name ?></b></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Shipping Cost: <b><?= $shipping->shipping_cost ?></b></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <div class="row pull-right">
                        <div class="col-md-5">
                            <a href="/dashboard" class="btn btn-success btn-lg btn-block">Cancel</a>
                        </div>
                        <div class="col-md-7">
                            <?= $this->Form->button(__('Open Dispute'), ['class' => 'btn btn-danger btn-lg btn-block']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->unlockField('dispute_radio') ?>
            <?= $this->Form->unlockField('other_comment') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>