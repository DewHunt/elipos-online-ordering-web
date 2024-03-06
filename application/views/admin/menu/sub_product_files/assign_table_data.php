<table id="sub-product-files-table" class="table table-striped table-bordered dt-responsive  product-files-item">
    <thead class="thead-default">
        <tr>
            <th class="font-width" width="3rem">SN</th>
            <th class="font-width table-width" width="1rem">
                <input type="checkbox" class="select_all" name="select_all" <?= $all_check ?>>
            </th>
            <th class="font-width ">Sub Product Name</th>
            <th class="font-width ">Sub Product Full Name</th>
        </tr>
    </thead>

    <tbody>
        <?php if ($sub_product_list_details): ?>
            <?php
                $m_sub_product = new Selectionitems_Model();
                $count = 1;
            ?>
            <?php foreach ($sub_product_list_details as $sub_product): ?>
                <?php
                    $assigned_product = $m_sub_product->get_by(array('SelectionItemFilesId'=>$sub_product->selectiveItemId,'foodItemId'=>$foodItemId),true);
                    $is_prev_assigned = empty($assigned_product) ? false : true;
                    $check = '';
                    if ($is_prev_assigned) {
                        $check = 'checked';
                    }
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td class="assign-sub-product-file-item">
                        <input type="checkbox" class="item-checkbox" name="product_file_id" data-is-prev-checked="<?= $is_prev_assigned ?>" value="<?= $sub_product->selectiveItemId ?>" <?= $check ?>>
                    </td>
                    <td><?= $sub_product->selectiveItemName ?></td>
                    <td><?= $sub_product->selectiveItemFullName ?></td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>

<?php if ($sub_product_list_details): ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
            <img class="loader-image" src="<?=base_url('assets/admin/loader/loader.gif')?>" style="float: left; width: 38px;">
            <button class="btn btn-primary btn-info assign-button width-150">Assign</button>
        </div>
    </div>
<?php endif ?>
