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
        <form class="form-horizontal form-label-left" id="sub_product_save_form" name="sub_product_save_form" method="post" action="<?= base_url('admin/sub_product/save') ?>">
            <div class="error error-message">
                <?php echo validation_errors(); ?>
            </div>
            <div class="row">                
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category_id" name="category_id" class="form-control select2">
                            <option value="">Please Select</option>
                            <?php foreach ($category_list as $category): ?>
                                <?php
                                    $select = '';
                                    if ($category->categoryId == $session_category_id) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?= $category->categoryId ?>" <?= $select ?>><?= $category->categoryName ?></option>
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
                                <?php foreach ($product_list as $product): ?>
                                    <?php
                                        $select = '';
                                        if ($product->foodItemId == $session_food_item_id) {
                                            $select = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $product->foodItemId ?>" <?= $select ?>><?= $product->foodItemName ?></option>        
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
                        <input class="form-control" type="text" id="sub_product_name" name="sub_product_name" placeholder="Sub Product Short Name" value="">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sub-product-full-name">Sub Product Full Name</label>
                        <input class="form-control" type="text" id="sub_product_full_name" name="sub_product_full_name" placeholder="Sub Product Full Name" value="">
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
                                        if ($size->id == $session_product_size_id) {
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
                        <input class="form-control" type="number" min="0" id="table_price" name="table_price" placeholder=" Table Price" value="0">
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="takeway-price">Takeaway Price</label>
                        <input class="form-control" type="number" min="0" id="takeaway_price" name="takeaway_price" placeholder=" Takeaway Price" value="0">
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="bar-price">Bar Price</label>
                        <input class="form-control" type="number" min="0" id="bar_price" name="bar_price" placeholder=" Bar Price" value="0">
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="vat-rate">Vat Rate</label>
                    <div class="form-group">
                        <?php
                            $vatRate = $form_data['vatRate'];
                            $check = "";
                            if (empty($vatRate)) {
                                $vatRate = 0;
                            }
                            if ($form_data['vatIncluded'] == 1) {
                                $check = "checked";
                            }
                        ?>
                        <input class="form-control" type="number" min="0" id="vat_rate" name="vat_rate" placeholder="Vat Rate" value="<?= $vatRate ?>">
                        <input type="checkbox" class="form-check-input" id="vat_included" name="vat_included" <?= $check ?>>
                        <span class="">Vat Included</span>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?php
                        $SortOrder = $form_data['SortOrder'];
                        if ($SortOrder) {
                            $SortOrder = $SortOrder + 1;
                        } else {
                            $SortOrder = 1;
                        }
                    ?>
                    <div class="form-group">
                        <label for="sort-order">Sort Order</label>
                        <input class="form-control" type="number" min="1" id="sort_order" name="sort_order" placeholder=" Sort Order" value="<?= $SortOrder ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="printed-description">Printed Description</label>
                        <textarea class="form-control" name="printed_description" rows="5"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <a type="button" href="<?= base_url('admin/sub_product') ?>" class="btn btn-danger">Cancel</a>
                        <button id="send" type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
