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
        <form class="form-horizontal form-label-left" id="product_save_form" name="product_save_form" method="post" action="<?= base_url('admin/product/save') ?>">
            <?php
                $product_category_food_type = $this->session->userdata('product_category_food_type');
                $form_data = $this->session->userdata('product_form_data');
                // dd($product_category_food_type);
            ?>
            <div class="error error-message"><?php echo validation_errors(); ?></div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Category</label>
                    <div class="form-group">
                        <select id="category_id" name="category_id" class="form-control select2">
                            <option value="">Please Select</option>
                            <?php if (!empty($category_list)): ?>
                                <?php foreach ($category_list as $category): ?>
                                    <?php
                                        $select = '';
                                        if (get_array_key_value('categoryId',$form_data) == $category->categoryId) {
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
                        <input class="form-control" type="text" value="" id="product_name" name="product_name" placeholder="Product Short Name">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Product Full Name</label>
                    <div class="form-group">
                        <input class="form-control" type="text" value="" id="product_full_name" name="product_full_name" placeholder="Product Full Name">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <?php
                        $order_types = get_order_type_array();
                        $product_order_type = get_array_key_value('product_order_type',$form_data);
                    ?>
                    <label>Order Type</label>
                    <div class="form-group">
                        <select name="order_type" class="form-control select2">
                            <option value="">Select Order Type</option>
                            <?php foreach ($order_types as $key => $value): ?>
                                <?php
                                    $select = '';
                                    if ($key == 'delivery,collection,dine_in') {
                                        $select = 'selected';
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
                            $product_sizes = $m_product_size->get_all_product_size();
                            $productSizeId = get_array_key_value('productSizeId',$form_data);
                        ?>
                        <select name="product_size_id" class="form-control select2">
                            <?php foreach ($product_sizes as $size): ?>
                                <?php
                                    $select = '';
                                    if ($size->id == $productSizeId) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?=$size->id?>" <?= $select ?>><?= $size->title ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <?php
                        $check = '';
                        $isDiscount = get_array_key_value('isDiscount',$form_data);
                        if ($isDiscount == 1) {
                            $check = 'checked';
                        }
                    ?>
                    <label>Discount</label>
                    <div class="form-group">
                        <input type="hidden" name="isDiscount" value="0">
                        <label class="checkbox-inline"><input type="checkbox" name="isDiscount" id="isDiscount" value="1" <?= $check ?>>Exclude Discount</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Table Price</label>
                    <div class="form-group">
                        <input class="form-control" type="number" min="0" value="0" id="table_price" name="table_price" placeholder=" Table Price">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Takeaway Price</label>
                    <div class="form-group">
                        <input class="form-control" type="number" min="0" value="0" id="takeaway_price" name="takeaway_price" placeholder=" Takeaway Price">
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Bar Price</label>
                    <div class="form-group">
                        <input class="form-control" type="number" min="0" value="0" id="bar_price" name="bar_price" placeholder=" Bar Price">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Vat Rate</label>
                    <div class="form-group">
                        <?php
                            $varRate = get_array_key_value('vatRate',$form_data);
                            $check = "";
                            if (empty($vatRate)) {
                                $vatRate = 0;
                            }
                            if (get_array_key_value('vatStatus',$form_data) == 1) {
                                $check = "checked";
                            }
                        ?>
                        <input class="form-control" type="number" min="0" value="<?= $vatRate ?>" id="vat_rate" name="vat_rate" placeholder="Vat Rate">
                        <input type="checkbox" class="form-check-input" id="vat_included" name="vat_included" <?= $check ?>>
                        <span class="">&nbsp;Vat Included</span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Unit</label>
                    <div class="form-group">
                        <?php
                            $units = array('Per Piece'=>'Per Piece','Per Pound'=>'Per Pound','Per Kg'=>'Per Kg','Per Letter'=>'Per Letter',);
                            $itemUnit = get_array_key_value('itemUnit',$form_data);
                        ?>
                        <select id="unit" name="unit" class="form-control select2">
                            <option name="unit" value="">Please Select</option>
                            <?php foreach ($units as $key => $value): ?>
                                <?php
                                    $select = '';
                                    if ($key == 'Per Piece') {
                                        $select = 'selected';
                                    }
                                ?>
                                <option name="unit" value="<?=$value?>" <?= $select ?>><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <?php
                        $SortOrder = get_array_key_value('SortOrder',$product_category_food_type);
                        if ($SortOrder) {
                            $SortOrder = $SortOrder + 1;
                        } else {
                            $SortOrder = 1;
                        }
                    ?>
                    <label>Sort Order</label>
                    <div class="form-group">
                        <input class="form-control" type="number" min="0" value="<?= $SortOrder ?>" id="sort_order" name="sort_order" placeholder="Sort Order">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php
                        $days = get_week_name_array();
                        $availability = get_array_key_value('availability',$form_data);
                        if ($availability) {
                            $availability = explode(',', $availability);
                        }
                    ?>
                    <label>Availability</label>
                    <div class="form-group">
                        <select id="" name="availability[]" class="form-control select2 select2-multiple" multiple data-placeholder="Select Days">
                            <?php foreach ($days as $key => $value): ?>
                                <?php
                                    $select = '';
                                    if ($key == 'sunday,monday,tuesday,wednesday,thursday,friday,saturday') {
                                        $select = 'selected';
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
                    <?php
                        $item_strength = get_array_key_value('item_strength',$form_data);
                        if ($item_strength) {
                            $item_strength = explode(',', $item_strength);
                        }
                    ?>
                    <label>Product Strength</label>
                    <div class="form-group">
                        <select id="" name="product_strength[]" class="form-control select2 select2-multiple" multiple data-placeholder="Select Strength">
                            <?php foreach ($fooditem_strength_list as $fooditem_strength): ?>
                                <?php
                                    $select = '';
                                    if (is_array($item_strength)) {
                                        if (in_array($fooditem_strength->strength_id, $item_strength)) {
                                            $select = 'selected';
                                        }
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
                        <textarea name="description" class="form-control" rows="5"><?= get_array_key_value('description',$form_data) ?></textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Printed Description</label>
                    <div class="form-group">
                        <textarea name="printed_description" class="form-control" rows="5"><?= get_array_key_value('printed_description',$form_data) ?></textarea>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <a type="button" href="<?= base_url('admin/product') ?>" class="btn btn-danger">Cancel</a>
                    <!--  <button class="btn btn-warning" type="reset">Reset</button>-->
                    <button id="send" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>