<li class="dropdown messages-menu">
    <a href="/messages" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope-o"></i>
        <?php if($totalMessageCount > 0) { ?>
        <span class="label label-success"><?= $totalMessageCount ?></span>
        <?php } ?>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have <?= $totalMessageCount ?> messages</li>
        <?php if(count($navMessagesArray) > 0) { ?>
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <?php foreach($navMessagesArray as $navMessage) { ?>
                <li><!-- start message -->
                    <a href="/messages/view/<?= $navMessage['id'] ?>">
                        <div class="pull-left">
                            <?php echo $this->Html->image($navMessage['avatar'] . '.thumb.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>
                        </div>
                        <h4>
                            <?= h($navMessage['username']) ?>
                            <small><i class="fa fa-clock-o"></i> <?= $navMessage['lapsed'] ?></small>
                        </h4>
                        <p><?= h($navMessage['subject']) ?></p>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <li class="footer"><a href="/messages">See All Messages</a></li>
        <?php } ?>
    </ul>
</li>