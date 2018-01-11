<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pending Shipment
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">


            <?php foreach ($orders as $order): ?>
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-1">
                                <input type="checkbox" name="bulk[]" value="<?= $order->id ?>" />
                            </div>
                            <div class="col-md-6">
                                <h3><?= $order->product->title ?></h3>
                            </div>
                            <div class="col-md-2">
                                <h4>Quantity: <?= $order->quantity ?></h4>
                            </div>
                            <div class="col-md-3">
                                <h4><?= $order->shipping_option->shipping_name ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-1">
                                        <textarea style="width:100%;" rows="6"><?= $order->shipping_details ?></textarea>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <h4><?= $order->user->username ?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <a href="/compose/<?= $order->user->id ?>" class="btn btn-primary btn-block" target="_blank">Send Message To <?= $order->user->username ?> </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Total Orders: <?= count($order->user->orders); ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <?php $totalUserOrdersCost = 0; ?>
                                                        <?php foreach($order->user->orders as $user_order) { ?>
                                                        <?php $totalUserOrdersCost = $totalUserOrdersCost + $user_order->product->cost + $user_order->shipping_option->shipping_cost; ?>
                                                        <?php } ?>
                                                        Total Cost of Orders: $<?= $totalUserOrdersCost ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Total Disputes:
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Total Cost of Disputes:
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <div class="row pull-right">
                            <div class="col-md-12">
                                <a href="/shipped/<?= $order->id ?>" class="btn btn-success btn-lg btn-block">Mark Shipped</a>
                            </div>
                        </div>
                    </div>
                </div>
            <hr/>
            <?php endforeach; ?>

            <div class="box">
                <div class="box-footer clearfix">
                    <div class="row pull-right">
                        <div class="col-md-12">
                            <a href="/shipped/<?= $order->id ?>" class="btn btn-success btn-lg btn-block">Mark All Checked Shipped</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
