<section class="content-header">
    <h1>
        <?= h($title) ?>
    </h1>
    <ol class="breadcrumb">
        <li>
            <?= $this->Html->link('<i class="fa fa-dashboard"></i> ' . __('Back'), ['action' => 'index'], ['escape' =>
            false])?>
        </li>
    </ol>
</section>

<section class="content">
    <div class="container-fluid">
        <?= $this->element('Products/index', ['products' => $products]) ?>
    </div>
</section>
<!-- /.content -->
