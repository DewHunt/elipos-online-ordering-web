<style type="text/css">
    .modifier-limit-input{ width: 100px; }
    .deals-item-head { background: #e1e1e2; color: #000000; font-weight: bold; text-align: center; padding:5px; margin-left: -10px; margin-right: -10px; }
    .product .form-group { padding: 3px; border: 1px solid; border-radius: 4px; margin-top: 4px; }
    .product .form-group:nth-child(even){ background-color: #eff5f7; }
    .product .form-group label{ padding: 5px; }
    .sub-product .form-group { padding: 3px; border: 1px solid; border-radius: 4px; margin-top: 4px; }
    .sub-product .form-group:nth-child(even){ background-color: #eff5f7; }
    .sub-product .form-group label{ padding: 5px; }
    .scroll-div { max-height: 300px; overflow-y: scroll }
    input[type="radio"], input[type="checkbox"] { margin: 4px 3px 0; }
</style>

<?php
    $lim_product = new Product();
    $deals_item_model = new Deals_Item_Model();
    $item_title = "";
    $item_limit = "";
    $item_description = "";
    $product_ids = array();
    $sub_product_ids = array();
    $modifier_limit_as_product = array();
    $modifier_limit_as_sub_product = array();
    $btn_text = "Add Item";
    $previous_category_id = 0;
    $product_head = '';
    $previous_product_id = 0;
    $sub_product_head = '';
    $products = $lim_product->get_products();
    $subProducts = $lim_product->get_all_sub_products();
    $deals_items = $deals_item_model->get_items_from_session();
    $session_is_half_and_half = $this->session->userdata('session_is_half_and_half');
    $disable = '';
    // dd(count($deals_items));

    if (!isset($index_key)) {
        $index_key = -1;
    }

    if (isset($editable_item) && $editable_item) {
        $item_title = $editable_item['title'];
        $item_limit = $editable_item['limit'];
        $item_description = $editable_item['description'];
        $product_ids = json_decode($editable_item['productIds']);
        $sub_product_ids = json_decode($editable_item['subProductIds']);
        $modifier_limit_as_product = json_decode($editable_item['productAsModifierLimit']);
        $modifier_limit_as_sub_product = json_decode($editable_item['subProductAsModifierLimit']);

        $modifier_limit_as_product = array_column($modifier_limit_as_product, 'limit','id');
        $modifier_limit_as_sub_product = array_column($modifier_limit_as_sub_product, 'limit','id');
        $disable = '';
        $btn_text = "Update Item";
    } else {
        if ($session_is_half_and_half || (isset($deal) && $deal->is_half_and_half == 1)) {
            if (count($deals_items) >= 1) {
                $disable = 'disabled';
            }
        }
    }
?>

<form id="addItemForm" method="post">
    <div class="panel panel-default">
        <div class="panel-heading text-center"><h2>Deals/Offers Item Details </h2></div>
        <div class="panel-body">
            <input type="hidden" class="form-control" name="index_key" value="<?= $index_key ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Item Title</label>
                        <input type="text" class="form-control" name="item_title" value="<?= $item_title ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Item Limit</label>
                        <input type="number" class="form-control" id="item_limit" name="item_limit" min="0" value="<?= $item_limit ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Item Description</label>
                        <textarea class="form-control" name="item_description" rows="4"><?= $item_description ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center"><h2>Select Product</h2></div>
                        <div class="panel-body product scroll-div">
                            <?php if (!empty($products)): ?>                        
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="productCheckAll" name="product_check_all">All
                                </label>
                                <?php foreach ($products as $product): ?>
                                    <?php
                                        $check = '';
                                        $limit = 1;
                                        if (in_array($product->foodItemId, $product_ids)) {
                                            $check = 'checked';
                                            if (array_key_exists($product->foodItemId, $modifier_limit_as_product)) {
                                                $limit = $modifier_limit_as_product[$product->foodItemId];
                                            }
                                        }
                                    ?>
                                    <?php if ($previous_category_id != $product->categoryId): ?>
                                        <?php
                                            $previous_category_id = $product->categoryId;
                                            $product_head = $product->categoryName;
                                        ?>
                                        <h5 class="deals-item-head"><?= $product_head ?></h5>
                                    <?php endif ?>
                                    <div class="form-group row">
                                        <label class="form-control-label">
                                            <input type="checkbox" value="<?= $product->foodItemId ?>" <?= $check ?> name="product_ids[]">&nbsp;<?= $product->foodItemName ?>
                                        </label>
                                        <input type="number" class="form-control modifier-limit-input text-right" min="0" name="product_<?= $product->foodItemId ?>" style="float: right" value="<?= $limit ?>"/>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center"><h2>Select Sub Product</h2></div>
                        <div class="panel-body sub-product scroll-div">
                            <?php if (!empty($subProducts)): ?>                        
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="subProductCheckAll" name="subProductCheckAll">All
                                </label>
                                <?php foreach ($subProducts as $subProduct): ?>
                                    <?php
                                        $check = '';
                                        $limit = 1;
                                        if (in_array($subProduct->selectiveItemId, $sub_product_ids)) {
                                            $check = 'checked';
                                            if (array_key_exists($subProduct->selectiveItemId, $modifier_limit_as_sub_product)) {
                                                $limit = $modifier_limit_as_sub_product[$subProduct->selectiveItemId];
                                            }
                                        }
                                    ?>
                                    <?php if ($previous_product_id != $subProduct->foodItemId): ?>
                                        <?php
                                            $previous_product_id = $subProduct->foodItemId;
                                            $sub_product_head = $subProduct->foodItemName;
                                        ?>
                                        <h5 class="deals-item-head"><?= $sub_product_head ?></h5>
                                    <?php endif ?>
                                    <div class="form-group row">
                                        <label class="form-control-label">
                                            <input type="checkbox" value="<?= $subProduct->selectiveItemId ?>" <?= $check ?> name="sub_product_ids[]">&nbsp;<?= $subProduct->selectiveItemName ?>
                                        </label>
                                        <input type="number" class="form-control modifier-limit-input text-right" name="subProduct_<?=$subProduct->selectiveItemId?>" min="0" style="float: right" value="<?= $limit ?>"/>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button type="button" id="addItemButton" class="btn btn-primary" <?= $disable ?>><?= $btn_text ?></button>
                </div>
            </div>
        </div>
    </div>
</form>
