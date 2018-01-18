<section class="content-header">
    <h1>
        Settings
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Folders</h3>
                        </div>
                        <div class="box-body no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="<?= $userActive ?>"><a href="/settings?settings=user"><i class="fa fa-cog"></i> User Settings</a></li>
                                <?php if($role == 'vendor') { ?>
                                <li class="<?= $vendorActive ?>"><a href="/settings?settings=vendor"><i class="fa fa-cogs"></i> Vendor Settings</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($role == 'vendor' && $settings == 'vendor') { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">TOS Markdown Styling</h3>
                        </div>
                        <div class="box-body">
                                <pre>
# H1
## H2
### H3
#### H4
##### H5
###### H6

Alt-H1
======

Alt-H2
------

italics, *asterisks*

bold, **asterisks**

* Unordered asterisks
- Or minuses
+ Or pluses</pre>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $settingsTitle ?></h3>
                </div>
                <?php if($settings == 'user') { ?>
                <div class="box-body">
                    <?= $this->Form->create(null, ['url' => '/saveUserSettings', 'enctype' => 'multipart/form-data']) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Your Avatar</h3>
                            </div>
                            <br/>
                            <div class="col-md-offset-0 col-md-5">
                                <?php if($user->avatar != '') { ?>
                                <img class="profile-user-img img-responsive img-circle" src="<?= str_replace(WWW_ROOT, '/', $user->avatar . '.thumb.jpg') ?>" alt="User profile picture">
                                <?php } else { ?>
                                <img class="profile-user-img img-responsive img-circle" src="/img/avatar.jpg" alt="User profile picture">
                                <?php } ?>
                            </div>
                            <div class="col-md-7">
                                <?= $this->Form->input('upload', ['type' => 'file']) ?>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">2 Factor Authentication</h3>
                            </div>
                            <br/>
                            <div class="col-md-offset-0 col-md-5">
                                <input type="checkbox" name="enable_2fa" id="enable_2fa" <?php if($user->get('2fa') == 1) { echo 'checked'; } ?> /><label for="enable_2fa">&nbsp;Enable 2 Factor PGP Authentication</label>
                            </div>
                            <div class="col-md-7">
                                <p>Enabling 2 Factor PGP Authentication will require you to respond to an encrypted challenge. You will be given an encrypted message which you will have to decrypt and respond with the message in plain text to login.</p>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Your PGP Key</h3>
                            </div>
                            <br/>
                            <div class="col-md-offset-0 col-md-5">
                                <textarea name="pgp_key" rows="15" style="width:100%"><?php if($user->pgp != '') { echo $user->pgp; } ?></textarea>
                            </div>
                            <div class="col-md-7">
                                <p>This is the key that people will use to encrypt your messages.</p>
                                <p>This is also the key that will be used in 2 Factor Authentication.</p>
                                <p>For more information, Google: How to use PGP</p>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->button('Save User Settings', ['class' => 'btn btn-lg btn-primary btn-block padding-t-b-15']) ?>
                        </div>
                    </div>
                    <?= $this->Form->unlockField('pgp_key'); ?>
                    <?= $this->Form->unlockField('enable_2fa'); ?>
                    <?= $this->Form->end() ?>
                </div>
                <?php } else if($settings == 'vendor') { ?>
                <div class="box-body">
                    <?= $this->Form->create(null, ['url' => '/saveVendorSettings']) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Your Title</h3>
                            </div>
                            <br/>
                            <div class="col-md-offset-0 col-md-5">
                                <input type="text" name="title" id="title" style="width:100%;" placeholder="Mr. Jones" value="<?= $vendor->title ?>" required />
                            </div>
                            <div class="col-md-7">
                                <p>As in something like Mr. Jones</p>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Your Terms of Service</h3>
                            </div>
                            <br/>
                            <div class="col-md-offset-0 col-md-5">
                                <textarea name="tos" id="tos" rows="28" style="width:100%"><?= $vendor->tos ?></textarea>
                            </div>
                            <div class="col-md-7" style="background-color:lightgrey; border: double 1px;min-height: 570px;">

                                        <?php
                    $parser = new \cebe\markdown\Markdown();
                    echo $parser->parse($vendor->tos);
                                        ?>

                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->button('Save Vendor Settings', ['class' => 'btn btn-lg btn-primary btn-block padding-t-b-15']) ?>
                        </div>
                    </div>
                    <?= $this->Form->unlockField('title') ?>
                    <?= $this->Form->unlockField('tos') ?>
                    <?= $this->Form->end() ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
