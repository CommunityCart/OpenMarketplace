<section class="content-header">
    <h1>
        <?php if($actionUrl == '/save2fa') { ?>
        Settings
        <?php } else { ?>
        Authentication
        <?php } ?>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php if($actionUrl == '/save2fa') { ?>
                    <h3 class="box-title">Enable 2 Factor PGP Authentication</h3>
                    <?php } else { ?>
                    <h3 class="box-title">2 Factor PGP Authentication</h3>
                    <?php } ?>
                </div>
                <div class="box-body">
                    <?= $this->Form->create(null, ['url' => $actionUrl]) ?>
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
                                <p>Decrypt the message to the left and place it below, then click 'Enable 2 Factor Authentication'</p>
                                <br/>
                                <input type="text" style="width:100%" name="pgp_challenge_response" id="pgp_challenge_response" />
                                <br/>
                                <br/>
                                <?php if($actionUrl == '/save2fa') { ?>
                                <?= $this->Form->button('Enable 2 Factor Authentication', ['class' => 'btn btn-lg btn-primary btn-block padding-t-b-15']) ?>
                                <?php } else { ?>
                                <?= $this->Form->button('Login With 2 Factor Authentication', ['class' => 'btn btn-lg btn-primary btn-block padding-t-b-15']) ?>
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