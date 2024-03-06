<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/food_type/add_food_type') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Food Type</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="parent-category">Parent Catrgory:</label>
                    <select id="parentCategoryId" name="parentCategoryId" class="form-control select2">
                        <?php $parent_category_id_session = $this->session->userdata('parent_category_id_session'); ?>
                        <option value="">All</option>
                        <?php if ($parent_category_list): ?>
                            <?php foreach ($parent_category_list as $parent_category): ?>
                                <?php
                                    $select = '';
                                    if ($parent_category_id_session == $parent_category->parentCategoryId) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?= $parent_category->parentCategoryId ?>" <?= $select ?>><?= $parent_category->parentCategoryName ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 24px;">
                <div class="form-group">
                    <button id="btn-show" type="submit" class="btn btn-success btn-block">Show</button>
                </div>
            </div>
        </div>

        <div id="food-type-table"><?= $food_type_table ?></div>
    </div>
</div>