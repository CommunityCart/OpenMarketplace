
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="box-title">
            <h3>Your Wallet Deposit Address</h3>
          </div>
        </div>
        <div class="box-body">
            <pre>143asf;i3g4q;inserg/jldsfgjosdrfg</pre>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="box-title">
            <h3>Your Wallet Total Balance</h3>
          </div>
        </div>
        <div class="box-body">
          <pre>2354.234 LTC</pre>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Deposit History & Current Balance</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <th><?= $this->Paginator->sort('currency_id') ?></th>
                <th><?= $this->Paginator->sort('wallet_balance') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($wallets as $wallet): ?>
              <tr>
                <td><?= $wallet->has('currency') ? $this->Html->link($wallet->currency->name, ['controller' => 'Currencies', 'action' => 'view', $wallet->currency->id]) : '' ?></td>
                <td><?= $wallet->wallet_balance ?></td>
                <td><?= $wallet->created ?></td>
                <td class="actions" style="white-space:nowrap">
                  <?= $this->Html->link(__('View'), ['action' => 'view', $wallet->id], ['class'=>'btn btn-info btn-xs']) ?>
                </td>
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
</section>
<!-- /.content -->
