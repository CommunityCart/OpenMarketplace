
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="box-title" style="text-align: center;">
            <h3 style="width:100%;">Your Invite Link</h3>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <pre><center><?= $inviteLink ?></center></pre>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <center><pre>Earn <?= $commissionPercent ?>% From User Purchases and <?= $commissionPercentVendors ?>% From Vendor Sales.</pre></center>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="box-title">
            <h3>Your Invite Stats</h3>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <pre>Invites Left: <?= $invitesLeft ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Invites Total: <?= $invitesTotal ?></pre>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <pre>User Registrations: <?= $userRegistrations ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Vendor Upgrades: <?= $vendorUpgrades ?></pre>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="box-title">
            <h3>Users Purchase Stats</h3>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <pre>Purchases in Escrow: <?= $purchasesInEscrow ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Escrow: $<?= $purchasesInEscrowCash ?></pre>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <pre>Finalized Purchases: <?= $purchasesFinalized ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Finalized: $<?= $purchasesFinalizedCash ?></pre>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <pre>Total Purchases: <?= ($purchasesInEscrow + $purchasesFinalized) ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Total Cash: $<?= ($purchasesInEscrowCash + $purchasesFinalizedCash) ?></pre>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="box-title">
            <h3>Vendor Sales Stats</h3>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <pre>Sales in Escrow: <?= $salesInEscrow ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Escrow: $<?= $salesInEscrowCash ?></pre>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <pre>Finalized Sales: <?= $salesFinalized ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Finalized: $<?= $salesFinalizedCash ?></pre>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <pre>Total Sales: <?= ($salesInEscrow + $salesFinalized) ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Total Cash: $<?= ($salesInEscrowCash + $salesFinalizedCash) ?></pre>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <div class="box-title">
            <h3>Commission Stats</h3>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <pre>Unpaid User Purchases in Escrow: $<?= $unpaidPurchasesInEscrow ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Finalized Paid User Purchases: $<?= $paidFinalizedPurchases ?></pre>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <pre>Unpaid Vendor Sales in Escrow: $<?= $unpaidSalesInEscrow ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Finalized Paid Vendor Sales: $<?= $paidFinalizedSales ?></pre>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <pre>Unpaid Total in Escrow: $<?= $unpaidTotalInEscrow ?></pre>
            </div>
            <div class="col-md-6">
              <pre>Finalized Paid Total: $<?= $paidFinalizedTotal ?></pre>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= __('List of') ?> Last 100 Invites Claimed</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
            <tr>
              <th>Anonymous User Hash</th>
              <th>Upgraded to Vendor</th>
              <th>Registration Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($invitesClaimed as $invitesClaimed): ?>
            <tr>
              <td><?= substr(md5(md5($invitesClaimed->user->id)), 0, 16) ?></td>
              <?php if($invitesClaimed->upgraded_to_vendor == 1) { ?>
              <td>Yes</td>
              <?php } else { ?>
              <td>No</td>
              <?php } ?>
              <td><?= $invitesClaimed->created ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= __('List of') ?> Last 100 Finalized Orders</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
            <tr>
              <th>Total Price</th>
              <th>Your Commission</th>
              <th>Finalized Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($invitesFinalized as $invitesFinalize): ?>
            <tr>
              <td>$<?= $invitesFinalize->order->order_total_dollars ?></td>
              <td>$<?= number_format($invitesFinalize->commission, 5) ?></td>
              <td><?= $invitesFinalize->finalized ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
