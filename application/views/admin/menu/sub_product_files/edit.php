
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/sub_product_files') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Sub Product Files Items</a>
                <a class="btn btn-info" href="<?= base_url('admin/sub_product_files/assign') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Assign/Remove Sub Product Files Item</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-horizontal form-label-left" id="sub_product_update_form" name="sub_product_update_form" method="post" action="<?= base_url('admin/sub_product_files/update') ?>">
            <div class="error error-message"><?= validation_errors(); ?></div>
            <input type="hidden" id="id" name="id" value="<?= $sub_product->selectiveItemId ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sub-product-short-name">Sub Product Short Name</label>
                        <input class="form-control" type="text" id="sub_product_name" name="sub_product_name" placeholder="Sub Product Short Name" value="<?= $sub_product->selectiveItemName ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sub-product-full-name">Sub Product Full Name</label>
                        <input class="form-control" type="text" id="sub_product_full_name" name="sub_product_full_name" placeholder="Sub Product Full Name" value="<?= $sub_product->selectiveItemFullName ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="table-price">Table Price</label>
                        <input class="form-control" type="text" id="table_price" name="table_price" placeholder=" Table Price" value="<?= $sub_product->tablePrice ?>">
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="takeaway-price">Takeaway Price</label>
                        <input class="form-control" type="text" id="takeaway_price" name="takeaway_price" placeholder="Takeaway Price" value="<?= $sub_product->takeawayPrice ?>">
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="bar-price">Bar Price</label>
                        <input class="form-control" type="text" id="bar_price" name="bar_price" placeholder="Bar Price" value="<?= $sub_product->barPrice ?>">
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="vat-rate">Vat Rate</label>
                        <input type="text" class="form-control" id="vat_rate" name="vat_rate" placeholder="Vat Rate" value="<?= $sub_product->vatRate ?>">
                        <?php
                            $check = '';
                            if ($sub_product->vatIncluded == 1) {
                                $check = 'checked';
                            }
                        ?>
                        <input type="checkbox" class="form-check-input" id="vat_included" name="vat_included" <?= $check ?>><span> Vat Included</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sort-order">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" placeholder="Sort Order" value="<?= $sub_product->SortOrder ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <a type="button" href="<?= base_url('admin/sub_product_files') ?>" class="btn btn-danger">Cancel</a>
                        <button id="send" type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
