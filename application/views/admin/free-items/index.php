<style>
    /*.content { position: relative; }*/
    /*.overlay { position: absolute; left: 0; top: 0; right: 0; bottom: 0; z-index: 2; background-color: rgba(255, 255, 255, 0.8; }*/
    /*.overlay-content { position: absolute; transform: translateY(-50%); -webkit-transform: translateY(-50%); -ms-transform: translateY(-50%); top: 50%; left: 0; right: 0; text-align: center; color: #555; }*/
    .label-design { font-size: 18px; padding-right: 8px }
    .input-width-height { width: 80px; height: 29px; text-align: right; }
    .btn-width-height { width: 120px; height: 29px; }
    .active-status-color { color: green }
    .deactive-status-color { color: red }
</style>

<?php
    $check = '';
    if ($enabled_free_item) {
        $check = 'checked';
    }
    $fooditem_model = new Fooditem_Model();
    $selection_items_model = new Selectionitems_Model();
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info btn-md" href="<?= base_url('admin/free_items/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Frre Item</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <label class="label-design">
                    <input type="checkbox" name="enabled_free_item" id="enabled_free_item" <?= $check ?>>&nbsp;Enabled
                </label>
                
                <label class="label-design">Limit:</label>&nbsp;<input type="number" step="1" name="free_item_limit" class="input-width-height" id="free-item-limit" value="<?=$free_item_limit?>">
                &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary btn-sm btn-width-height" id="save-settings">Save</button>
                &nbsp;&nbsp;&nbsp;<span id="save-message"></span>
            </div>
        </div>
        <br>
        <table class="table table-striped table-bordered list-dt" id="freeItems-table">
            <thead>
                <tr>
                    <th class="text-center" width="20px">SN</th>
                    <th class="text-center" width="300px">Description</th>
                    <th class="text-center">Selected Products</th>
                    <th class="text-center" width="50px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($free_items): ?>
                    <?php $count = 1; ?>
                    <?php foreach ($free_items as $freeItem): ?>
                        <?php
                            $status = 'Deactive';
                            $color = 'deactive-status-color';
                            if ($freeItem->status) {
                                $status = 'Active';
                                $color = 'active-status-color';
                            }
                            $product_ids = get_property_value('product_ids',$freeItem);
                            $sub_product_ids = get_property_value('sub_products_ids',$freeItem);
                            if ($product_ids) {
                                $product_ids = json_decode($product_ids);
                            } else {
                                $product_ids = array();
                            }

                            if ($sub_product_ids) {
                                $sub_product_ids = json_decode($sub_product_ids);
                            } else {
                                $sub_product_ids = array();
                            }
                            $products = $fooditem_model->get_products_by_ids($product_ids);
                            if ($products) {
                                $products = array_column($products, 'foodItemName');
                                $products = implode(', ', $products);
                            }

                            $sub_products = $selection_items_model->get_sub_products_by_ids($sub_product_ids);
                            if ($sub_products) {
                                $sub_products = array_column($sub_products, 'selectiveItemName');
                                $sub_products = implode(', ', $sub_products);
                            }
                        ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td>
                                <b>Description:</b> <?= $freeItem->description; ?><br>
                                <b>Amount:</b> <?= $freeItem->amount ?><br>
                                <b>Status:</b> <span class="<?= $color ?>"><?= $status ?></span>
                            </td>
                            <td class="text-justify">
                                <b>Products:</b> <?= $products ?><br><br>
                                <b>Sub Products:</b> <?= $sub_products ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url("admin/free_items/edit/$freeItem->id") ?>" class="btn btn-primary btn-sm"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="<?= base_url("admin/free_items/view/$freeItem->id") ?>" class="btn btn-primary btn-sm"><i class=" fa fa-eye" aria-hidden="true"></i></a>
                                <a href="<?= base_url("admin/free_items/delete/$freeItem->id") ?>" class="btn btn-primary btn-sm"><i class=" fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal add Notification -->
<div class="modal fade" id="product" tabindex="-1" role="dialog" aria-labelledby="product">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Product</h4>
            </div>
            <div class="modal-body" data-id="" style="margin-bottom: 35px"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="sub-product" tabindex="-1" role="dialog" aria-labelledby="product">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Sub Product</h4>
            </div>
            <div class="modal-body" data-id="" style="margin-bottom: 35px"></div>
        </div>
    </div>
</div>