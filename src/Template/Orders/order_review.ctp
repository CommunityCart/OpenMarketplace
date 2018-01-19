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
                            <?php if($order->status == -2) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Order Disputed By User</h4><hr/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span>Someone from the staff will contact you shortly.</span>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Dispute Details</h4><hr/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if($dispute->never_arrived == 1) { ?>
                                            <span>Order Never Arrived</span>
                                            <?php } else if($dispute->wrong_product == 1) { ?>
                                            <span>Wrong Product Delivered</span>
                                            <?php } else if($dispute->bad_quality == 1) { ?>
                                            <span>Product Not As Described</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span><?= $dispute->comment ?></span>
                                        </div>
                                    </div>
                                    <?php if($userIsVendor == true) { ?>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="/refund/<?= $order->id ?>" class="btn btn-success btn-lg btn-block">Refund 100%</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="/refund50/<?= $order->id ?>" class="btn btn-success btn-lg btn-block">Refund 50%</a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($order->status < 2 && $order->status > -1) { ?>
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
                            <?php } else if($order->status >= 2) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Ordered</h5><hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <h5><?= $order->created ?></h5><hr/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Accepted</h5><hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <?php if($order->accepted != '') { ?>
                                            <h5><?= $order->accepted ?></h5><hr/>
                                            <?php } else { ?>
                                            <h5>Pending</h5><hr/>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Shipped</h5><hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <?php if($order->shipped != '') { ?>
                                            <h5><?= $order->shipped ?></h5><hr/>
                                            <?php } else { ?>
                                            <h5>Pending</h5><hr/>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Finalized</h5><hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <?php if($order->finalized != '') { ?>
                                            <h5><?= $order->finalized ?></h5><hr/>
                                            <?php } else { ?>
                                            <h5>Pending</h5><hr/>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if($order->rated != '') { ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Rated</h5><hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <h5><?= $order->rated ?></h5><hr/>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if($order->finalize_early == 1) { ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Finalize Early</h5><hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>YES</h5><hr/>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if($order->status >= 5) { ?>

                            <?= $this->Form->create('null', ['url' => '/rate/' . $order->id]); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if($order->status == 5) { ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center><h4>Please Submit Review</h4></center><br/>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-md-1">&nbsp;</div>
                                        <div class="col-md-2">
                                            <center><input type="radio" name="review_star" value="1" required <?php if(isset($order->reviews[0]) && $order->reviews[0]->stars == 1) { ?> checked="checked" <?php } ?>/></center>
                                            <label for="review_star" style="text-align: center">1 Star</label>
                                        </div>
                                        <div class="col-md-2">
                                            <center><input type="radio" name="review_star" value="2" <?php if(isset($order->reviews[0]) && $order->reviews[0]->stars == 2) { ?> checked="checked" <?php } ?>/></center>
                                            <label for="review_star" style="text-align: center">2 Stars</label>
                                        </div>
                                        <div class="col-md-2">
                                            <center><input type="radio" name="review_star" value="3" <?php if(isset($order->reviews[0]) && $order->reviews[0]->stars == 3) { ?> checked="checked" <?php } ?>/></center>
                                            <label for="review_star" style="text-align: center">3 Stars</label>
                                        </div>
                                        <div class="col-md-2">
                                            <center><input type="radio" name="review_star" value="4" <?php if(isset($order->reviews[0]) && $order->reviews[0]->stars == 4) { ?> checked="checked" <?php } ?> /></center>
                                            <label for="review_star" style="text-align: center">4 Stars</label>
                                        </div>
                                        <div class="col-md-2">
                                            <center><input type="radio" name="review_star" value="5" <?php if(isset($order->reviews[0]) && $order->reviews[0]->stars == 5) { ?> checked="checked" <?php } ?>/></center>
                                            <label for="review_star" style="text-align: center">5 Stars</label>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if(isset($order->reviews[0])) { ?>
                                                <textarea style="width:100%;" name="review_comment" rows="3" required ><?= $order->reviews[0]->comment ?></textarea>
                                            <?php } else { ?>
                                                <textarea style="width:100%;" name="review_comment" rows="3" required ></textarea>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if($order->status == 5) { ?>
                                            <?= $this->Form->button(__('Submit Review'), ['class' => 'btn btn-success btn-lg btn-block']) ?>
                                            <?php } else { ?>
                                            <?= $this->Form->button(__('Update Review'), ['class' => 'btn btn-success btn-lg btn-block']) ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= $this->Form->unlockField('review_star') ?>
                            <?= $this->Form->unlockField('review_comment') ?>
                            <?= $this->Form->end() ?>
                            <?php } ?>

                            <?php

                            if($order->status < 2 && $order->status > -1) {

                                $url = '/submit/' . $order->id;
                            }
                            else {
                                $url = '';
                            }
                            ?>

                            <?= $this->Form->create('null', ['url' => $url]); ?>
                            <?php if($order->status < 2 && $order->status > -1) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <center><span>Enter Your Shipping Details Below</span></center>
                                    <textarea style="width:100%;" rows="4" name="shipping_details" required><?php if(isset($order->shipping_details) && $order->shipping_details != '') { ?><?= $order->shipping_details ?><?php } ?></textarea>
                                    <center><input type="checkbox" name="encrypt_shipping" id="encrypt_shipping" /><label for="encrypt_shipping">&nbsp;Encrypt Shipping Details</label></center>
                                </div>
                            </div>
                            <hr/>
                            <?php } ?>
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
                                <?php if($order->status < 2 && $order->status > -1) { ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $this->Form->button(__('Click Here To Submit Order'), ['class' => 'btn btn-success btn-lg btn-block']) ?>
                                        </div>
                                    </div>
                                <?php } else if($order->status == 2) { ?>
                                    <div class="row">
                                        <?php if($order->finalize_early == 0) { ?>
                                        <div class="col-md-6">
                                            <?= $this->Html->link(__('Cancel Order'), ['controller' => 'Orders', 'action' => 'delete', $order->id], ['class'=>'btn btn-danger btn-lg btn-block']) ?>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="/finalize/<?= $order->id ?>" class="btn btn-success btn-lg btn-block">Finalize Early</a>
                                        </div>
                                        <?php } else if($order->finalize_early == 1) { ?>
                                        <div class="col-md-12">
                                            <a href="/unfinalize/<?= $order->id ?>" class="btn btn-danger btn-lg btn-block">Remove Finalize Early</a>
                                        </div>
                                        <?php } ?>
                                    </div>
                                <?php } else if($order->status == 3) { ?>
                                    <?php if($order->finalize_early == 0) { ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="/dispute/<?= $order->id ?>" class="btn btn-danger btn-lg btn-block">Open Dispute</a>
                                            </div>
                                            <div class="col-md-6">
                                                <a href="/finalize/<?= $order->id ?>" class="btn btn-success btn-lg btn-block">Finalize Early</a>
                                            </div>
                                        </div>
                                    <?php } else if($order->finalize_early == 1) { ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="/unfinalize/<?= $order->id ?>" class="btn btn-danger btn-lg btn-block">Remove Finalize Early</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else if($order->status == 4) { ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="/dispute/<?= $order->id ?>" class="btn btn-danger btn-lg btn-block">Open Dispute</a>
                                            </div>
                                            <div class="col-md-6">
                                                <a href="/finalize/<?= $order->id ?>" class="btn btn-success btn-lg btn-block">Finalize Order</a>
                                            </div>
                                        </div>
                                <?php } ?>
                            <?php } ?>
                            <?= $this->Form->unlockField('shipping_details') ?>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <pre><?php $parser = new \cebe\markdown\Markdown(); echo $parser->parse($order->product->vendor->user->pgp); ?></pre>
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
    </div>
</section>