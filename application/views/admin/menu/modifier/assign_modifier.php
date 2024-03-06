<style type="text/css">
    .modifier-limit-input{ width: 80px; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4>Assign Modifier</h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/modifier'); ?>"><i class="fa fa-reply" aria-hidden="true"></i> All Modifier</a>
            </div>
        </div>        
    </div>

    <div class="panel-body">
        <form class="form-horizontal" id="product_list_form" name="product_list_form" method="post" action="<?= base_url('admin/modifier/assign_modifier_save') ?>">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category_id" name="category_id" class="form-control select2">
                            <option value="">Please Select</option>
                            <?php if (!empty($category_list)): ?>
                                <?php foreach ($category_list as $category): ?>
                                    <?php
                                        $select = '';
                                        if ($session_category_id == $category->categoryId) {
                                            $select = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $category->categoryId ?>" <?= $select ?> ><?= $category->categoryName ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="product">Product</label>
                        <div class="product_id">
                            <select id="product_id" name="product_id" class="form-control select2">
                                <option value="">Please Select </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sub-product">Sub Product</label>
                        <div class="sub_product_id">
                            <select id="sub_product_id" name="sub_product_id" class="form-control select2">
                                <option value="">Please Select</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-default">
                            <tr>
                                <th width="50px">SL</th>
                                <th width="50px" class="text-center">
                                    <input type="checkbox" class="select_all" name="select_all">
                                </th>
                                <th class="font-width">Name</th>
                                <th width="100px">Limit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($modifier_categories): ?>
                                <?php $count = 1; ?>
                                <?php foreach ($modifier_categories as $modifier_category): ?>
                                    <tr>
                                        <td><?= $count++; ?></td>
                                        <td class="text-center">
                                            <input class="modifier_id_class item-checkbox" type="checkbox" id="modifier_id_<?= $modifier_category->ModifierCategoryId ?>" name="ModifierCategoryIds[]" value="<?= $modifier_category->ModifierCategoryId ?>">
                                        </td>
                                        <td><?= ucfirst($modifier_category->ModifierCategoryName) ?></td>
                                        <td><input name="<?=$modifier_category->ModifierCategoryId?>" id="modifier_limit_<?= $modifier_category->ModifierCategoryId?>" type="number" min="1" value="<?=intval($modifier_category->ModifierLimit)?>" class="form-control modifier-limit-input text-right"></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <a type="button" href="<?= base_url('admin/modifier') ?>" class="btn btn-danger">Cancel</a>
                    <button id="send" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>