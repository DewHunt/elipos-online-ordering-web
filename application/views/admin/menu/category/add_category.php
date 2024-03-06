<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/category') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Category</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-horizontal form-label-left" id="category_save_form" name="category_save_form" method="post" action="<?= base_url('admin/category/save') ?>">
            <div class="error error-message"><?php echo validation_errors(); ?></div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Parent Category</label>
                    <div class="form-group">
                        <select class="form-control select2" id="parent_category_id" name="parent_category_id">
                            <option id="parent_category_id" name="parent_category_id" value="">Please Select</option>
                            <?php if (!empty($parent_category_list)): ?>
                                <?php foreach ($parent_category_list as $parent_category): ?>
                                    <option id="parent_category_id" name="parent_category_id" value="<?= $parent_category->parentCategoryId ?>"><?= $parent_category->parentCategoryName ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Fooed Type</label>
                    <div class="form-group">
                        <select class="form-control select2" id="food_type_id" name="food_type_id">
                            <option id="food_type_id" name="food_type_id" value="">Please Select</option>
                            <?php if (!empty($food_type_list)): ?>
                                <?php foreach ($variable as $key => $value): ?>
                                    <!-- <option id="food_type_id" name="food_type_id" value="<?= $food_type->foodTypeId ?>"><?= $food_type->foodTypeName ?></option> -->
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Category Type</label>
                    <div class="form-group">
                        <select class="form-control select2" id="category_type_id" name="category_type_id">
                            <option id="category_type_id" name="category_type_id" value="">Please Select</option>
                            <option id="category_type_id" name="category_type_id" value="0">Food</option>
                            <option id="category_type_id" name="category_type_id" value="1">Non Food</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Category Name</label>
                    <div class="form-group">
                        <input class="form-control" type="text" value="" id="category_name" name="category_name" placeholder="Category Name">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Sort Order</label>
                    <div class="form-group">
                        <input class="form-control" type="number" value="<?= $sort_order ?>" id="sort_order" name="sort_order" placeholder=" Sort Order">
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label>Offers/Deals</label>
                    <div class="form-group">
                        <select class="form-control select2" id="category_type_id" name="is_offers_or_deals">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label>Package</label>
                    <div class="form-group">
                        <select class="form-control select2" id="" name="isPackage">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <?php
                        $days = get_week_name_array();
                    ?>
                    <label>Availability</label>
                    <div class="form-group">
                        <select class="form-control select2 select2-multiple" id="" name="availability[]" multiple data-placeholder="Select Days">
                            <?php foreach ($days as $key => $value): ?>
                                <?php
                                    $select = "";
                                    if ($key == 'sunday,monday,tuesday,wednesday,thursday,friday,saturday') {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Order Type</label>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" value="collection" id="order_type" name="order_type" >Collection Only
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="delivery" id="order_type" name="order_type" >Delivery Only
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="both" id="order_type" name="order_type" checked>Both
                        </label>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Discount</label>
                    <div class="form-group">
                        <input type="hidden" name="isDiscount" value="0">
                        <label class="checkbox-inline"><input type="checkbox" name="isDiscount" id="isDiscount" value="1">Exclude Discount</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Descirption</label>
                    <div class="form-group">
                        <textarea class="form-control" rows="5" name="description"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 text-right">
                    <a type="button" href="<?= base_url('admin/category') ?>"
                       class="btn btn-danger">Cancel</a>
                    <!--  <button class="btn btn-warning" type="reset">Reset</button>-->
                    <button id="send" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>