<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/modifier_category') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Modifier Categories</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-horizontal form-label-left" id="category_save_form" name="modifier_category_save_form" method="post" action="<?= base_url('admin/modifier_category/update') ?>">
            <input type="hidden" name="ModifierCategoryId" value="<?= $modifier_category->ModifierCategoryId ?>">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" id="ModifierCategoryName" name="ModifierCategoryName" placeholder="Name" value="<?= $modifier_category->ModifierCategoryName ?>">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="limit">Limit</label>
                        <input class="form-control" type="number" id="ModifierLimit" name="ModifierLimit" placeholder="Limit" value="<?= $modifier_category->ModifierLimit ?>">
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sort-order">Sort Order</label>
                        <input class="form-control" type="number" id="SortOrder" name="SortOrder" placeholder="Sort Order" value="<?= $modifier_category->SortOrder ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <a type="button" href="<?= base_url('admin/Modifier_category') ?>" class="btn btn-danger">Cancel</a>
                        <button id="send" type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

