<?php $x = 0; ?>
<?php foreach ($products as $product): ?>
<?php $x = $x + 1; ?>
<?php if($x == 4) { $x = 0; }?>
<?php if($x == 0) { ?>
<div class="row">
    <?php } ?>

    <?php if(isset($product->product)) { ?>
    <?php $product = $product->product; ?>
    <?php } ?>

    <div class="col-md-3" style="display:inline-block">
        <div class="box">
            <div class="box-header">
                <center><h3 class="box-title"><a href="/products/view/<?php echo $product->id; ?>"><?= h($product->title) ?></a></h3></center>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <div class="col-md-12">
                    <?php if(count($product->product_images) > 0 && file_exists(WWW_ROOT . $product->product_images[0]->image_thumbnail)) { ?>
                    <center><a href="/products/view/<?php echo $product->id; ?>"><?= $this->Html->image($product->product_images[0]->image_thumbnail, ['width' => '150px']); ?></a></center>
                    <?php } else { ?>
                    <center><a href="/products/view/<?php echo $product->id; ?>"><img src="/img/product.png" width="150px" /></a></center>
                    <?php } ?>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <table style="width:100%">
                    <tbody>
                    <td><a href="/vendor/<?= $product->vendor->id ?>"><?= $product->vendor->title ?></a></td>
                    <td><?= $this->Number->currency($product->cost) ?></td>
                    <td><?= $product->country->symbol ?></td>
                    <td style="float:right;"> <a href="/products/view/<?php echo $product->id; ?>"><?= $product->product_category->category_name ?></a></td>

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