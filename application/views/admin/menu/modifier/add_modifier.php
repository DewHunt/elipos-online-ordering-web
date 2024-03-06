<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4>Add Modifier Information</h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/modifier'); ?>"><i class="fa fa-reply" aria-hidden="true"></i> All Modifier</a>
            </div>
        </div>
        
    </div>

    <div class="panel-body">
        <form class="form-horizontal form-label-left" id="modifier_save_form" name="modifier_save_form" method="post" action="<?= base_url('admin/modifier/save') ?>">
            <div class="error error-message"><?php echo validation_errors(); ?></div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="modifier-category">Modifier Category</label>
                    <div class="form-group">
                        <select class="form-control select2 mod-category" id="ModifierCategoryId" name="ModifierCategoryId">
                            <option  value="">Please Select</option>
                            <?php foreach ($modifier_categories as $category): ?>
                                <option value="<?= $category->ModifierCategoryId ?>"><?= $category->ModifierCategoryName ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="modifier-name">Modifier Name</label>
                    <div class="form-group">
                        <input class="form-control" type="text" value="" id="modifier_name" name="modifier_name" placeholder=" Modifier Name">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="menu-price">Menu Price</label>
                    <div class="form-group">
                        <input class="form-control" type="number" min="0" value="0" id="menu_price" name="menu_price" placeholder="Menu Price">
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="vat-rate">Vat Rate</label>
                    <div class="form-group">
                        <input class="form-control" type="number" min="0" value="0" id="vat_rate" name="vat_rate" placeholder="Vat Rate">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="unit">Unit</label>
                    <div class="form-group">
                        <?php
                            $unit_array = array('Pics'=>'Pics','Kg'=>'Kg','Litre'=>'Litre','Dozzon'=>'Dozzon');
                        ?>
                        <select id="unit" name="unit" class="form-control select2">
                            <option value="">Please Select</option>
                            <?php foreach ($unit_array as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="sort-order">Sort Order</label>
                    <div class="form-group">
                        <input class="form-control sort-order" id="sort_order" type="number" min="1" name="sort_order" placeholder="Sort Order" value="1">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <a type="button" href="<?= base_url('admin/modifier') ?>" class="btn btn-danger">Cancel</a>
                        <button id="send" type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
