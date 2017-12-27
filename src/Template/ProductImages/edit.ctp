<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productImage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $productImage->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $productImage->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Product Images'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="productImages form large-9 medium-8 columns content">
    <?= $this->Form->create($productImage) ?>
    <fieldset>
        <legend><?= __('Edit Product Image') ?></legend>
        <?php
            echo $this->Form->control('product_id');
            echo $this->Form->control('image_full');
            echo $this->Form->control('image_display');
            echo $this->Form->control('image_thumbnail');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
