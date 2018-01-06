<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-offset-3 col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="box-title" style="text-align: center;">
            <h3 style="width:100%;">Convert Your <b>Bitcoin</b> to <b>Cash Money Coin</b> Here</h3>
          </div>
        </div>
        <div class="box-body">
          <pre><center>https://www.cashmoney.exchange</center></pre>
        </div>
      </div>
    </div>
  </div>

  <?php if(isset($total)) { ?>
    <div class="row">
      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <div class="box-title">
              <h3>Insufficient Funds</h3>
            </div>
          </div>
          <div class="box-body">
            <pre><?= $missing ?> USD</pre>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <div class="box-title">
              <h3>Suggested Deposit Amount</h3>
            </div>
          </div>
          <div class="box-body">
            <pre><?= $missing2 ?></pre>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="box-title">
            <h3>Your Wallet Total Balance</h3>
          </div>
        </div>
        <div class="box-body">
          <pre><?= $totalBalance ?> CMC</pre>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="box-title">
            <h3>Your <b>Cash Money Coin</b> Deposit Address</h3>
          </div>
        </div>
        <div class="box-body">
            <pre>CMCx<?= $currentWallet->address ?></pre>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Current Balance</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('currency_id') ?></th>
                <th><?= $this->Paginator->sort('wallet_balance') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($wallets as $wallet): ?>
              <tr>
                <td><?= $wallet->id ?></td>
                <td><?= $wallet->has('currency') ? $this->Html->link($wallet->currency->name, ['controller' => 'Currencies', 'action' => 'view', $wallet->currency->id]) : '' ?></td>
                <td><?= $wallet->wallet_balance ?></td>
                <td><?= $wallet->created ?></td>
              </tr>
            <?php endforeach; ?>
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
              <th><?= $this->Paginator->sort('id') ?></th>
              <th><?= $this->Paginator->sort('wallet_id') ?></th>
              <th><?= $this->Paginator->sort('transaction_hash') ?></th>
              <th><?= $this->Paginator->sort('balance') ?></th>
              <th><?= $this->Paginator->sort('created') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($wallets as $wallet) { ?>
            <?php foreach ($wallet->wallet_transactions as $walletTransaction): ?>
            <tr>
              <td><?= $this->Number->format($walletTransaction->id) ?></td>
              <td><?= $wallet->id ?></td>
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
