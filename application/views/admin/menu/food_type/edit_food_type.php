<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/food_type') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Food Type</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-label-left" id="food_type_update_form" name="food_type_update_form" method="post" action="<?= base_url('admin/food_type/update') ?>">
            <?php if (!empty($this->session->flashdata('save_error_message'))): ?>                            
                <div class="form-group row error-message text-align-center">
                    <label for="" class="col-sm-3 col-xs-12 col-form-label"></label>
                    <div class="col-sm-9 col-xs-12"><?= $this->session->flashdata('save_error_message'); ?></div>
                </div>
            <?php endif ?>

            <input type="hidden" id="foodTypeId" name="foodTypeId" value="<?= $food_type->foodTypeId ?>">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="parent-category-name">Parent Category Name</label>
                        <select id="parentCategoryId" name="parentCategoryId" class="form-control">
                            <option name="parentCategoryId" value="">Please Select</option>
                            <?php if (!empty($parent_category_list)): ?>
                                <?php foreach ($parent_category_list as $parent_category): ?>
                                    <?php
                                        $select = '';
                                        if ($food_type->parentCategoryId == $parent_category->parentCategoryId) {
                                            $select = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $parent_category->parentCategoryId ?>" <?= $select ?>><?= $parent_category->parentCategoryName ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="food-type-name">Food Type Name</label>
                        <input class="form-control" type="text" value="<?= $food_type->foodTypeName ?>" id="foodTypeName" name="foodTypeName" placeholder="Food Type Name">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <a type="button" href="<?= base_url('admin/food_type') ?>" class="btn btn-danger">Cancel</a>
                        <!--  <button class="btn btn-warning" type="reset">Reset</button>-->
                        <button id="send" type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>