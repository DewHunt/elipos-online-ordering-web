<?php
    $selected_from_date = $this->session->userdata('from_date');
    $selected_to_date = $this->session->userdata('to_date');
    $selected_category_id = $this->session->userdata('category_id');
    $selected_product_id = $this->session->userdata('product_id');
?>

<div class="panel panel-default">
    <div class="panel-heading"><h4><?= $title ?></h4></div>

    <div class="panel-body">
        <form class="form-label-left" id="search-orders-form" name="search-orders-form" method="post" action="<?= base_url('admin/sell_items_report/index') ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <div id="reportrange-new" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; ">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                            <div class="date-to-form">
                                <input id="to_date_id" type="hidden" name="to_date" value="">
                                <input id="from_date_id" type="hidden" name="from_date" value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="order-status">Category</label>
                        <select class="form-control select2 category" name="category_id[]" multiple>
                            <?php if ($categories): ?>
                                <?php
                                    $all_option_select = "";
                                    if (is_array($selected_category_id) && in_array('all', $selected_category_id)) {
                                        $all_option_select = "selected";
                                    }
                                ?>
                                <option value="all" <?= $all_option_select ?>>All</option>
                                <?php foreach ($categories as $category): ?>
                                    <?php
                                        $select = "";
                                        if (is_array($selected_category_id) && in_array('all', $selected_category_id) == false && in_array($category->categoryId, $selected_category_id)) {
                                            $select = "selected";
                                        }
                                    ?>
                                    <option value="<?= $category->categoryId ?>" <?= $select ?>><?= $category->categoryName ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="order-status">Product</label>
                        <div class="product-div">
                            <select class="form-control select2 product" name="product_id[]" multiple>
                                <option value="">Select Products</option>
                                <?php if ($products): ?>
                                    <?php
                                        $all_option_select = "";
                                        if (is_array($selected_product_id) && in_array('all', $selected_product_id)) {
                                            $all_option_select = "selected";
                                        }
                                    ?>
                                    <option value="all" <?= $all_option_select ?>>All</option>
                                    <?php foreach ($products as $product): ?>
                                        <?php
                                            $select = "";
                                            if (is_array($selected_product_id) && in_array('all', $selected_product_id) == false && in_array($product->foodItemId, $selected_product_id)) {
                                                $select = "selected";
                                            }
                                        ?>
                                        <option value="<?= $product->foodItemId ?>" <?= $select ?>><?= $product->foodItemName ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button id="send" type="submit" class="btn btn-success">Show</button>
                    <img class="process-loader" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-stripe table-sm item-report">
                    <thead>
                        <tr>
                            <th class="text-center" width="20px">SL</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center" width="80px">Price</th>
                            <th class="text-center" width="80px">Quantity</th>
                            <th class="text-center" width="80px">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $sl = 1; ?>
                        <?php if ($reports): ?>
                            <?php foreach ($reports as $report): ?>
                                <tr>
                                    <td class="text-center"><?= $sl++ ?></td>
                                    <td><?= $report->product_name ?> (<?= $report->product_id ?>)</td>
                                    <td class="text-right"><?= $report->price ?></td>
                                    <td class="text-right"><?= $report->quantity ?></td>
                                    <td class="text-right"><?= $report->total_amount ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <!-- <th></th>
                            <th></th>
                            <th></th> -->
                            <th colspan="4" class="text-right">Total</th>
                            <!-- <th class="text-right"></th> -->
                            <th class="text-right"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </form>
    </div>
</div>