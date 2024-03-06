<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h2 class="text-center">Select Sub Product </h2></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <input class="form-control" type="text" id="subProductSearch" onkeyup="myFunction('sub-product-table','subProductSearch')" placeholder="Search by Name.." title="Type in a name">
                </div>
            </div>
        </div>        
    </div>

    <div class="panel-body sub-product" style="max-height: 300px;overflow-y: scroll">
        <?php if ($subProducts): ?>
            <table class="table table-striped table-bordered" id="sub-product-table">
                <thead>
                    <th><input type="checkbox" id="subProductCheckAll" name="subProductCheckAll">&nbsp;&nbsp;All</th>
                </thead>
                <tbody>
                    <?php foreach ($subProducts as $subProduct): ?>
                        <?php
                            $check = '';
                            if ($sub_product_ids && in_array($subProduct->selectiveItemId ,$sub_product_ids)) {
                                $check = 'checked';
                            }
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="sub_product_item_checkbox" value="<?= $subProduct->selectiveItemId ?>" name="sub_product_ids[]" <?= $check ?>>&nbsp;&nbsp;<?= $subProduct->selectiveItemName ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>

