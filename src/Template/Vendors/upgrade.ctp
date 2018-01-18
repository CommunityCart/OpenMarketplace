<section class="content-header">
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
    <?php if($no_pgp == true) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h4 style="display:inline-block;"><b>No PGP Key: </b>You need to set your PGP Key on the Settings Page before Continuing</h4>&nbsp;<a href="/settings?settings=user" class="btn btn-success" style="float:right;">Click Here to Set PGP Key</a>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <h1>
        Upgrade
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Upgrade To Vendor</h3>
                </div>
                <div class="box-body">
                    <?= $this->Form->create(null, ['url' => '/save-upgrade']) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Your PGP Encrypted Challenge</h3>
                            </div>
                            <br/>
                            <div class="col-md-offset-0 col-md-6">
                                <textarea style="width:100%" name="pgp_challenge" id="pgp_challenge" rows="20"><?= $challenge ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <p>Decrypt the message to the left and place it below, then click 'Upgrade To Vendor'</p>
                                <br/>
                                <input type="text" style="width:100%" name="pgp_challenge_response" id="pgp_challenge_response" />
                                <br/>
                                <br/>
                                <?php if($balance == 'low') { ?>
                                <a href="/wallet" class="btn btn-success btn-block">Click Here to Deposit <?= $this->Number->currency($missingBalance) ?></a>
                                <?php } else { ?>
                                <?= $this->Form->button('Upgrade To Vendor', ['class' => 'btn btn-lg btn-primary btn-block padding-t-b-15']) ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->unlockField('pgp_challenge') ?>
                    <?= $this->Form->unlockField('pgp_challenge_response') ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</section>