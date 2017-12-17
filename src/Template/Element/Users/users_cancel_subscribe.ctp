<?= $this->Form->create(null, array('url' => '/billing/cancel_subscribe/' . $currentUser->id)); ?>
<?= $this->Form->button('Cancel Subscription', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
<?= $this->Form->end() ?>