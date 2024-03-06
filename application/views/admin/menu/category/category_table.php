<div class="row">
    <div class="col-lg-12">
        <table id="category-table" class="table table-striped table-bordered dt-responsive category-tab list-dt">
            <thead class="thead-default">
                <tr>
                    <th>SN</th>
                    <th>Category Name</th>
                    <th>Parent Category</th>
                    <th>Food Type</th>
                    <th>Category Type</th>
                    <th>Sort Order</th>
                    <th width="320px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
                <?php if (!empty($category_list_details)): ?>
                    <?php foreach ($category_list_details as $category): ?>
                        <?php
                            if ($category->active == 1) {
                                $activeButtonName = 'Active';
                                $activeButtonClass = 'btn-success';
                            } else {
                                $activeButtonName = 'Deactive';
                                $activeButtonClass = 'btn-danger';
                            }

                            if ($category->orderable == 1) {
                                $orderableButtonName = 'Orderabled';
                                $orderableButtonClass = 'btn-success';
                            } else {
                                $orderableButtonName = 'Unorderable';
                                $orderableButtonClass = 'btn-danger';
                            }

                            if ($category->isHighlight == 1) {
                                $highlitedButtonName = 'Highlighted';
                                $highlitedButtonClass = 'btn-primary';
                            } else {
                                $highlitedButtonName = 'Not Highlighted';
                                $highlitedButtonClass = 'btn-default';
                            }
                        ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= ucfirst($category->categoryName) ?></td>
                            <td><?= ucfirst($category->parentCategoryName) ?></td>
                            <td><?= ucfirst($category->foodTypeName) ?></td>
                            <td><?= ((int)$category->categoryTypeId == 0 ? 'Food' : 'Non Food') ?></td>
                            <td><?= $category->SortOrder ?></td>
                            <td class="text-center">
                                <a href="<?= base_url("admin/category/edit_category/$category->categoryId") ?>" class="btn btn-primary btn-sm"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="<?= base_url("admin/category/delete/$category->categoryId") ?>" class="btn btn-danger btn-sm"><i class=" fa fa-times" aria-hidden="true"></i></a>
                                <span onclick="active_or_deactive(<?= $category->categoryId ?>,<?= $category->active ?>,1)" id="active_or_deactive_<?= $category->categoryId ?>" class="btn <?= $activeButtonClass ?> btn-sm active_btn">
                                    <?= $activeButtonName ?>
                                </span>
                                <span onclick="orderable_or_unorderable(<?= $category->categoryId ?>,<?= $category->orderable ?>,2)" id="orderable_or_unorderable_<?= $category->categoryId ?>" class="btn <?= $orderableButtonClass ?> btn-sm orderable_btn">
                                    <?= $orderableButtonName ?>
                                </span>
                                <span onclick="highlighted_or_not_highlighted_modal(<?= $category->categoryId ?>,<?= $category->isHighlight ?>,3,'<?= $category->highlight_color ?>')" id="highlighted_or_not_highlighted_<?= $category->categoryId ?>" class="btn <?= $highlitedButtonClass ?> btn-sm highlighted_btn">
                                    <?= $highlitedButtonName ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach ?>                    
                <?php else: ?>
                    <tr><td colspan="7" class="text-center error"><b>Category not found.</b></td></tr>                    
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
    </div>
</div>