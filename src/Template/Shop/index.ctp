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

    <?php $x = 0; ?>
    <?php foreach ($products as $product): ?>
    <?php $x = $x + 1; ?>
    <?php if($x == 4) { $x = 0; }?>
    <?php if($x == 0) { ?>
        <div class="row">
    <?php } ?>

        <div class="col-md-3" style="display:inline-block">
            <div class="box">
                <div class="box-header">
                    <center><h3 class="box-title"><a href="/products/view/<?php echo $product->product->id; ?>"><?= h($product->product->title) ?></a></h3></center>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <div class="col-md-12">
                        <?php if(count($product->product->product_images) > 0 && file_exists(WWW_ROOT . $product->product->product_images[0]->image_thumbnail)) { ?>
                            <center><a href="/products/view/<?php echo $product->product->id; ?>"><?= $this->Html->image($product->product->product_images[0]->image_thumbnail, ['width' => '150px']); ?></a></center>
                        <?php } else { ?>
                            <center><a href="/products/view/<?php echo $product->product->id; ?>"><img src="/img/avatar.png" width="150px" /></a></center>
                        <?php } ?>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <table style="width:100%">
                        <tbody>
                        <td><a href="/products/vendor/<?= $product->product->vendor->id ?>"><?= $product->product->vendor->user->username ?></a></td>
                        <td><?= $this->Number->currency($product->product->cost) ?></td>
                        <td><?= $product->product->country->symbol ?></td>
                        <td style="float:right;"> <a href="/products/view/<?php echo $product->product->id; ?>"><?= $product->product->product_category->category_name ?></a></td>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box -->
        </div>
    <?php if($x == 0) { ?>
        </div>
    <?php } ?>
    <?php endforeach; ?>
        </div>

</section>
<!-- /.content -->
