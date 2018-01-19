<section class="content-header">
    <h1>
        <?php echo __('Vendor'); ?>
    </h1>
    <ol class="breadcrumb">
        <li>
            <?= $this->Html->link('<i class="fa fa-dashboard"></i> ' . __('Back'), ['action' => 'index'], ['escape' =>
            false])?>
        </li>
    </ol>
</section>
<style>
    .checked {
        color: orange;
    }
</style>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if($user->avatar != '') { ?>
                            <img class="profile-user-img-big img-responsive img-circle" src="<?= str_replace(WWW_ROOT, '/', $currentUser->avatar . '.thumb.jpg') ?>" alt="User profile picture">
                            <?php } else { ?>
                            <img class="profile-user-img-big img-responsive img-circle" src="/img/avatar.png" alt="User profile picture">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <center><h3><?= h($vendor->title) ?></h3></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-info"></i>
                    <h3 class="box-title"><?php echo __('Information'); ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <dl class="dl-horizontal">
                                <dt><?= __('Title') ?></dt>
                                <dd>
                                    <?= h($vendor->title) ?>
                                </dd>
                                <dt><?= __('Last Active') ?></dt>
                                <dd>
                                    <?= h($vendor->last_active) ?>
                                </dd>
                                <dt><?= __('Total Orders') ?></dt>
                                <dd>
                                    <?= h($ordersCount) ?>
                                </dd>
                                <dt><?= __('Overall Rating') ?></dt>
                                <dd>
                                    <?= h($vendor->rating) ?> Stars
                                </dd>
                                <dt><?= __('Vendor Since') ?></dt>
                                <dd>
                                    <?= h($vendor->created) ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <a href="/message/<?= $vendor->get('id') ?>" class="btn btn-primary btn-block">Send Message</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $this->element('Products/index', ['products' => $products]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <pre><?php $parser = new \cebe\markdown\Markdown(); echo $parser->parse($vendor->tos); ?></pre>
                </div>
                <div class="col-md-12">
                    <pre><?php echo h($user->pgp); ?></pre>
                </div>
            </div>
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
                            <td><?= h($review->comment) ?></td>
                            <td><?= $review->created ?></td>
                        </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
