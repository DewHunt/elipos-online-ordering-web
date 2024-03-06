<?php //dd(validation_errors()); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/product') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Products</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-horizontal form-label-left" id="product_update_form" name="product_update_form" method="post" action="<?= base_url('admin/product/update') ?>">
            <div class="error error-message"><?php echo validation_errors(); ?></div>
            <input type="hidden" id="id" name="id" value="<?= $product->foodItemId ?>">

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input type="hidden" id="product_category_id" name="product_category_id" value="<?= $product->categoryId ?>">
                    <label>Category</label>
                    <div class="form-group">
                        <select id="category_id" name="category_id" class="form-control select2">
                            <option id="category_id" name="category_id" value="">Please Select</option>
                            <?php if (!empty($category_list)): ?>
                                <?php foreach ($category_list as $category): ?>
                                    <?php
                                        $select = '';
                                        if ($product->categoryId == $category->categoryId) {
                                            $select = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $category->categoryId ?>" <?= $select ?> ><?= $category->categoryName ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Product Short Name</label>
                    <div class="form-group">
                        <input class="form-control" type="text" value="<?= $product->foodItemName ?>" id="product_name" name="product_name" placeholder="Product Short Name">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Product Full Name</label>
                    <div class="form-group">
                        <input class="form-control" type="text" value="<?= $product->foodItemFullName ?>" id="product_full_name" name="product_full_name" placeholder="Product Full Name">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <?php
                        $order_types = get_order_type_array();
                    ?>
                    <label>Order Type</label>
                    <div class="form-group">
                        <select name="order_type" class="form-control select2">
                            <option value="">Select Order Type</option>
                            <?php foreach ($order_types as $key => $value): ?>
                                <?php
                                    if ($product->product_order_type == $key) {
                                        $select = 'selected';
                                    } else {
                                        $select = '';
                                    }
                                ?>
                                <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
        
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Size</label>
                    <div class="form-group">
                        <?php
                            $m_product_size = new Product_Size_Model();
                            $product_sizes = $m_product_size->get();
                        ?>
                        <select name="product_size_id" class="form-control select2">
                            <?php foreach ($product_sizes as $size): ?>
                                <?php
                                    if ($size->id == $product->productSizeId) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }                                                
                                ?>
                                <option value="<?=$size->id?>" <?= $select ?>><?=$size->title?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Discount</label>
                    <div class="form-group">
                        <input type="hidden" name="isDiscount" value="0">
                        <label class="checkbox-inline"><input type="checkbox" name="isDiscount" id="isDiscount" value="1" <?= $product->isDiscount == 1 ? 'checked' : '' ?>>Exclude Discount</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Table Price</label>
                    <div class="form-group">
                        <input class="form-control" type="text" value="<?= $product->tablePrice ?>" id="table_price" name="table_price" placeholder=" Table Price">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Takeaway Price</label>
                    <div class="form-group">
                        <input class="form-control" type="text" value="<?= $product->takeawayPrice ?>" id="takeaway_price" name="takeaway_price" placeholder=" Takeaway Price">
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Bar Price</label>
                    <div class="form-group">
                        <input class="form-control" type="text" value="<?= $product->barPrice ?>" id="bar_price" name="bar_price" placeholder=" Bar Price">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Vat Rate</label>
                    <div class="form-group">
                        <input class="form-control" type="text" value="<?= $product->vatRate ?>" id="vat_rate" name="vat_rate" placeholder="Vat Rate" >

                        <input type="checkbox" class="form-check-input" id="vat_included" name="vat_included" <?= $product->vatStatus == 1 ? 'checked':''?>>
                        <span class="">Vat Included</span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Unit</label>
                    <div class="form-group">
                        <?php
                            $units=array(
                                'Per Piece' => 'Per Piece',
                                'Per Pound' => 'Per Pound',
                                'Per Kg' => 'Per Kg',
                                'Per Letter' => 'Per Letter',
                            );
                        ?>
                        <select id="unit" name="unit" class="form-control select2">
                            <option name="unit" value="">Please Select</option>
                            <?php foreach ($units as $key=>$value): ?>
                                <?php
                                    if ($product->itemUnit == $key) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }                                                        
                                ?>
                                <option name="unit" value="<?=$value?>" <?= $select ?>><?=$value?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Sort Order</label>
                    <div class="form-group">
                        <input class="form-control" type="number" value="<?= $product->SortOrder ?>" id="sort_order" name="sort_order" placeholder=" Sort Order">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php
                        $days = get_week_name_array();
                    ?>
                    <label>Availability</label>
                    <div class="form-group">
                        <select id="" name="availability[]" class="form-control select2 select2-multiple" multiple data-placeholder="Select Days">
                            <?php $availableDays = explode(',',$product->availability); ?>
                            <?php foreach ($days as $key => $value): ?>
                                <?php
                                    if (in_array($key,$availableDays)) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }                                                
                                ?>
                                <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Product Strength</label>
                    <div class="form-group">
                        <select id="" name="product_strength[]" class="form-control select2 select2-multiple" multiple data-placeholder="Select Strength">
                            <?php $foodItemStrengths = explode(',',$product->item_strength); ?>
                            <?php foreach ($fooditem_strength_list as $fooditem_strength): ?>
                                <?php
                                    if (in_array($fooditem_strength->strength_id,$foodItemStrengths)) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }                                                
                                ?>
                                <option value="<?= $fooditem_strength->strength_id ?>" <?= $select ?>><?= $fooditem_strength->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Description</label>
                    <div class="form-group">
                        <textarea name="description" class="form-control" rows="5"><?= $product->description ?></textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Printed Description</label>
                    <div class="form-group">
                        <textarea name="printed_description" class="form-control" rows="5"><?= $product->food_item_printed_description ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <a type="button" href="<?= base_url('admin/product') ?>" class="btn btn-danger">Cancel</a>
                    <!--  <button class="btn btn-warning" type="reset">Reset</button>-->
                    <button id="send" type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>