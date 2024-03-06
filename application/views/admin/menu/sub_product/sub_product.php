<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/sub_product/add_sub_product') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Sub Product</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="sub_product_list_form" name="sub_product_list_form" method="post" action="<?= base_url('admin/sub_product') ?>">
            <div class="row">                
                <?php
                    $category_id_for_sub_product_session = $this->session->userdata('category_id_for_sub_product_session');
                ?>
                <div class="col-lg-5 col-md-5 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category_id" name="category_id" class="form-control select2">
                            <option value="">Please Select</option>
                            <?php if ($category_list): ?>
                                <option value="-1" selected>All</option>
                                <?php foreach ($category_list as $category): ?>
                                    <?php
                                        $select = '';
                                        if ($category->categoryId == $session_category_id) {
                                            $select = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $category->categoryId ?>" <?= $select ?>>
                                        <?= $category->categoryName ?>
                                    </option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-5 col-md-5 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="food-item">Food Item</label>
                        <div class="product_id">
                            <select id="product_id" name="product_id" class="form-control select2">
                                <option value="">Please Select</option>
                                <?php
                                    $all_option_select = "";
                                    if ($session_food_item_id <= 0) {
                                        $all_option_select = "selected";
                                    }
                                ?>
                                <option value="-1" <?= $all_option_select ?>>All</option>
                                <?php if ($product_list): ?>
                                    <?php foreach ($product_list as $product): ?>
                                        <?php
                                            $select = '';
                                            if ($product->foodItemId == $session_food_item_id) {
                                                $select = 'selected';
                                            }
                                        ?>
                                        <option value="<?= $product->foodItemId ?>" <?= $select ?>>
                                            <?= $product->foodItemName ?>
                                        </option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 23px;">
                    <div class="form-group">
                        <button id="send" type="submit" class="btn btn-success btn-block">Show</button>
                    </div>
                </div>
            </div>

            <center>
                <img align="middle" class="loader" style="display: none" src="<?=base_url('assets/admin/loader/loader.gif')?>">
            </center>
        </form>
        <div class="form-container table-data-block"><?= $table_data ?></div>
    </div>
</div>