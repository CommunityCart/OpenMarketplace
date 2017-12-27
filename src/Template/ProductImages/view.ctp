<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productImage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Product Image'), ['action' => 'edit', $productImage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Product Image'), ['action' => 'delete', $productImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productImage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Product Images'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product Image'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="productImages view large-9 medium-8 columns content">
    <h3><?= h($productImage->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($productImage->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Id') ?></th>
            <td><?= $this->Number->format($productImage->product_id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Image Full') ?></h4>
        <?= $this->Text->autoParagraph(h($productImage->image_full)); ?>
    </div>
    <div class="row">
        <h4><?= __('Image Display') ?></h4>
        <?= $this->Text->autoParagraph(h($productImage->image_display)); ?>
    </div>
    <div class="row">
        <h4><?= __('Image Thumbnail') ?></h4>
        <?= $this->Text->autoParagraph(h($productImage->image_thumbnail)); ?>
    </div>
</div>
