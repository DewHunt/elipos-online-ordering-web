<?php //dd($product_list_details) ?>
<style type="text/css">
    .active_btn { width: 60px; }
    .orderable_btn { width: 80px; }
    .highlighted_btn { width: 95px; }
    .btn-group-sm > .btn, .btn-sm { padding: 5px 5px; }
    .btn-default { color: #fff; background-color: #aaa; }
    .btn-success { color: #fff; background: #5cb85c }
</style>

<table id="product-table" class="table table-striped table-bordered list-dt sorting product-list product-tab">
    <thead class="thead-default">
        <th width="20px">SN</th>
        <th width="120px">Category Name</th>
        <th width="120px">Product Name</th>
        <th>All Description</th>
        <th width="70px">Prices (<?= get_currency_symbol(); ?>)</th>
        <th width="50px">Sorted</th>
        <th width="120px">Action</th>
    </thead>

    <tbody>
        <?php $count = 1; ?>
        <?php if (!empty($product_list_details)): ?>
            <?php foreach ($product_list_details as $product): ?>
                <?php
                    $product_name = $product->foodItemName;
                    if ($product->active == 1) {
                        $activeButtonName = 'Active';
                        $activeButtonClass = 'btn-success';
                    } else {
                        $activeButtonName = 'Deactive';
                        $activeButtonClass = 'btn-danger';
                    }

                    if ($product->orderable == 1) {
                        $orderableButtonName = 'Orderabled';
                        $orderableButtonClass = 'btn-success';
                    } else {
                        $orderableButtonName = 'Unorderable';
                        $orderableButtonClass = 'btn-danger';
                    }

                    if ($product->isHighlight == 1) {
                        $highlitedButtonName = 'Highlited';
                        $highlitedButtonClass = 'btn-primary';
                    } else {
                        $highlitedButtonName = 'Not Highlited';
                        $highlitedButtonClass = 'btn-default';
                    }                    
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= $product->categoryName ?></td>
                    <td><?= $product_name ?></td>
                    <td>
                        <b>Description: </b><p><?= $product->description ?></p>
                        <b>Printed. Description: </b><p><?= $product->food_item_printed_description ?></p>
                    </td>
                    <td>
                        <p><b>Table: </b><?= $product->tablePrice ?></p>
                        <p><b>Bar: </b><?= $product->barPrice ?></p>
                        <p><b>Takeway: </b><?= $product->takeawayPrice ?></p>
                    </td>
                    <td class="text-right"><?= $product->SortOrder ?></td>
                    <td class="text-center">
                        <a class="btn btn-primary btn-sm" href="<?= base_url("admin/product/edit_product/$product->foodItemId") ?>">
                            <i class=" fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                        </a>
                        <span data-id="<?=$product->foodItemId?>" class="btn btn-danger btn-sm btn-delete">
                            <i class=" fa fa-times" aria-hidden="true"></i> Delete
                        </span>
                        <span onclick="active_or_deactive(<?= $product->foodItemId ?>,<?= $product->active ?>,1)" id="active_or_deactive_<?= $product->foodItemId ?>" class="btn <?= $activeButtonClass ?> btn-sm active_btn">
                            <?= $activeButtonName ?>
                        </span>
                        <span onclick="orderable_or_unorderable(<?= $product->foodItemId ?>,<?= $product->orderable ?>,2)" id="orderable_or_unorderable_<?= $product->foodItemId ?>" class="btn <?= $orderableButtonClass ?> btn-sm orderable_btn">
                            <?= $orderableButtonName ?>
                        </span>
                        <span onclick="highlighted_or_not_highlighted_modal(<?= $product->foodItemId ?>,<?= $product->isHighlight ?>,3,'<?= $product->highlight_color ?>')" id="highlighted_or_not_highlighted_<?= $product->foodItemId ?>" class="btn <?= $highlitedButtonClass ?> btn-sm highlighted_btn">
                            <?= $highlitedButtonName ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="highlightedColorModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Highlight Color Modal</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <label for="select-color">Select Highlight Color</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="color" name="highlightColor" value="" placeholder="Highlight Color" readonly>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <label for=""></label>
                        <div class="form-group" style="margin-top: 5px;">
                            <span id="highlight_color" class="btn btn-primary btn-md btn-block">OK
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>