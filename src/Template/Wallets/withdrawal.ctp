<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <h3>Your Wallet Total Balance</h3>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <pre><?= $totalBalance ?> CMC</pre>
                        </div>
                        <div class="col-md-6">
                            <pre><?= $totalUSDBalance ?> USD</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-title" style="text-align: center;">
                        <h3 style="width:100%;">Convert Your <b>Cash Money Coin</b> to <b>Bitcoin</b> Here</h3>
                    </div>
                </div>
                <div class="box-body">
                    <pre><center>https://www.cashmoney.exchange</center></pre>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= __('List of') ?> Wallet Transactions</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('transaction_hash') ?></th>
                            <th><?= $this->Paginator->sort('balance') ?></th>
                            <th><?= $this->Paginator->sort('created') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($wallets as $wallet) { ?>
                        <?php foreach ($wallet->wallet_transactions as $walletTransaction): ?>
                        <tr>
                            <td><?= h($walletTransaction->transaction_hash) ?></td>
                            <td><?= $this->Number->format($walletTransaction->balance) ?></td>
                            <td><?= $walletTransaction->created ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <?php echo $this->Paginator->numbers(); ?>
                    </ul>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
