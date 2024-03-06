<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/sub_product') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Sub Product</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-horizontal form-label-left" id="sub_product_update_form" name="sub_product_update_form" method="post" action="<?= base_url('admin/sub_product/update') ?>">
            <div class="error error-message">
                <?php echo validation_errors(); ?>
            </div>
            <input type="hidden" id="id" name="id" value="<?= $sub_product->selectiveItemId ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category_id" name="category_id" class="form-control select2">
                            <option value="">Please Select</option>
                            <?php foreach ($category_list as $category_row): ?>
                                <?php
                                    $select = '';
                                    if ($category->categoryId == $category_row->categoryId) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?= $category_row->categoryId ?>" <?= $select ?>><?= $category_row->categoryName ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="food-item">Food Item</label>
                        <div class="product_id">
                            <select id="product_id" name="product_id" class="form-control select2">
                                <option value="">Please Select</option>
                                <?php foreach ($product_list as $product_row): ?>
                                    <?php
                                        $select = '';
                                        if ($product->foodItemId == $product_row->foodItemId) {
                                            $select = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $product_row->foodItemId ?>" <?= $select ?>><?= $product_row->foodItemName ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sub-product-short-name">Sub Product Short Name</label>
                        <input class="form-control" type="text" value="<?= htmlspecialchars($sub_product->selectiveItemName) ?>" id="sub_product_name" name="sub_product_name" placeholder="Sub Product Short Name">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sub-product-full-name">Sub Product Full Name</label>
                        <input class="form-control" type="text" value="<?= htmlspecialchars($sub_product->selectiveItemFullName) ?>" id="sub_product_full_name" name="sub_product_full_name" placeholder="Sub Product Full Name">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="food-item">Product Size</label>
                        <div class="product_size_id">
                            <select class="form-control select2" id="product_size_id" name="product_size_id">
                                <option value="">Please Select</option>
                                <?php foreach ($product_sizes as $size): ?>
                                    <?php
                                        $select = '';
                                        if ($size->id == $sub_product->productSizeId) {
                                            $select = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $size->id ?>" <?= $select ?>><?= $size->title ?></option>        
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="table-price">Table Price</label>
                        <input class="form-control" type="number" min="0" value="<?= $sub_product->tablePrice ?>" id="table_price" name="table_price" placeholder=" Table Price">
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="takeway-price">Takeaway Price</label>
                        <input class="form-control" type="number" min="0" value="<?= $sub_product->takeawayPrice ?>" id="takeaway_price" name="takeaway_price" placeholder=" Takeaway Price">
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="bar-price">Bar Price</label>
                        <input class="form-control" type="number" min="0" value="<?= $sub_product->barPrice ?>" id="bar_price" name="bar_price" placeholder=" Bar Price">
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="vat-rate">Vat Rate</label>
                        <input class="form-control" type="number" min="0" value="<?= $sub_product->vatRate ?>" id="vat_rate" name="vat_rate" placeholder="Vat Rate" >

                        <input type="checkbox" class="form-check-input" id="vat_included" name="vat_included" <?= $sub_product->vatIncluded == 1 ? 'checked' : '' ?>>
                        <span class="">Vat Included</span>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sort-order">Sort Order</label>
                        <input class="form-control" type="number" min="0" id="sort_order" name="sort_order" value="<?= $sub_product->SortOrder ?>" placeholder=" Sort Order">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" rows="5"><?= $sub_product->selection_item_description ?></textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="printed-description">Printed Description</label>
                        <textarea class="form-control" name="printed_description" rows="5"><?= $sub_product->selection_item_printed_description ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <a type="button" href="<?= base_url('admin/sub_product') ?>" class="btn btn-danger">Cancel</a>
                        <button id="send" type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
