<style type="text/css">
    .active_btn { width: 60px; }
    .orderable_btn { width: 80px; }
    .highlighted_btn { width: 95px; }
    .btn-group-sm > .btn, .btn-sm { padding: 5px 5px; }
    .btn-default { color: #fff; background-color: #aaa; }
    .btn-success { color: #fff; background: #5cb85c }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/category/add_category') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Category</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-5">
                <label>Parent Category</label>
                <div class="form-group">
                    <select id="parent_category_id" name="parent_category_id" class="form-control select2">
                        <?php
                            $parent_category_id_for_category_session = $this->session->userdata('parent_category_id_for_category_session');
                        ?>
                        <option value="">All</option>
                        <?php if (!empty($parent_category_list)): ?>
                            <?php foreach ($parent_category_list as $parent_category): ?>
                                <?php
                                    if ((int) $parent_category_id_for_category_session == (int) $parent_category->parentCategoryId) {
                                        $select = 'selected';
                                    } else {
                                        $select = '';
                                    }                                                    
                                ?>
                                <option value="<?= $parent_category->parentCategoryId ?>" <?= $select ?>><?= $parent_category->parentCategoryName ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-5">
                <label>Food Type</label>
                <div class="form-group">
                    <select id="food_type_id" name="food_type_id" class="form-control select2">
                        <?php $food_type_id_for_category_session = $this->session->userdata('food_type_id_for_category_session'); ?>
                        <option id="food_type_id" name="food_type_id" value="">All</option>
                        <?php if (!empty($food_type)): ?>
                            <?php foreach ($food_type as $food): ?>
                                <?php
                                    if ((int) $food_type_id_for_category_session == (int) $food->foodTypeId) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }                                                    
                                ?>
                                <option id="food_type_id" name="food_type_id" value="<?= $food->foodTypeId ?>" <?= $select ?>><?= $food->foodTypeName ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <label></label>
                <div class="form-group" style="padding-top: 5px;">
                    <button id="btn-show" type="submit" class="btn btn-block btn-success">Show</button>
                </div>
            </div>
        </div>
        
        <div id="category-table">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table id="category-table" class="table table-striped table-bordered dt-responsive list-dt">
                            <thead class="thead-default">
                                <tr>
                                    <th>SN</th>
                                    <th width="120px">Category Name</th>
                                    <th width="120px">Parent Category</th>
                                    <th width="120px">Food Type</th>
                                    <th width="120px">Category Type</th>
                                    <th>All Description</th>
                                    <th>Sort Order</th>
                                    <th width="120">Action</th>
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
                                            <td><?= $category->category_description ?></td>
                                            <td><?= $category->SortOrder ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url("admin/category/edit_category/$category->categoryId") ?>" class="btn btn-primary btn-sm">
                                                    <i class=" fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                </a>
                                                <a href="<?= base_url("admin/category/delete/$category->categoryId") ?>" class="btn btn-danger btn-sm">
                                                    <i class=" fa fa-times" aria-hidden="true"></i> Delete
                                                </a>
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
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>

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
        </div>
    </div>
</div>