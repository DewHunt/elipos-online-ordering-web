<table id="sub-product-table" class="table table-striped table-bordered dt-responsive sub-product-list list-dt">
    <thead class="thead-default">
        <tr>
            <th width="20px">SN</th>
            <th width="120px">Name</th>
            <th width="120px">Product Name</th>
            <th>All Description</th>
            <th width="60px">Price (<?= get_currency_symbol(); ?>)</th>
            <th width="60px">VAT Rate</th>
            <th width="60px">Sorted</th>
            <th width="50px">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($sub_product_list_details): ?>
            <?php $count = 1; ?>
            <?php foreach ($sub_product_list_details as $sub_product): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $sub_product->selectiveItemName ?></td>
                    <td><?= $sub_product->foodItemName ?></td>
                    <td>
                        <b>Description:</b>
                        <p><?= $sub_product->selection_item_description ?></p>
                        <b>Printed Description:</b>
                        <p><?= $sub_product->selection_item_printed_description ?></p>
                    </td>
                    <td>
                        <p><b>Table: </b><?= $sub_product->tablePrice ?></p>
                        <p><b>Takeway: </b><?= $sub_product->takeawayPrice ?></p>
                        <p><b>Bar: </b><?= $sub_product->barPrice ?></p>
                    </td>
                    <td><?= $sub_product->vatRate ?></td>
                    <td><?= $sub_product->SortOrder ?></td>
                    <td>
                        <a href="<?= base_url("admin/sub_product/edit_sub_product/$sub_product->selectiveItemId") ?>" class="btn btn-sm btn-block btn-primary">
                            <i class=" fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                        </a>
                        <a data-id="<?=$sub_product->selectiveItemId?>" class="btn btn-sm btn-danger btn-block btn-delete">
                            <i class=" fa fa-times" aria-hidden="true"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>