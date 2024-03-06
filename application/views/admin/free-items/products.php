<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h2 class="text-center">Select Product</h2></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <input class="form-control" type="text" id="productSearch" onkeyup="myFunction('product-table','productSearch')" placeholder="Search by Name.." title="Type in a name">
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body product" style="max-height: 300px; overflow-y: scroll">
        <?php if ($products): ?>
            <table class="table table-striped table-bordered" id="product-table">
                <thead>
                    <th><input type="checkbox" id="productCheckAll" name="product_check_all">&nbsp;&nbsp;All</th>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <?php
                            $check = '';
                            if ($product_ids && in_array($product->foodItemId,$product_ids)) {
                                $check = 'checked';
                            }
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="product_item_checkbox" value="<?= $product->foodItemId ?>" name="product_ids[]" <?= $check ?>>
                                &nbsp;<?= $product->foodItemName ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>
