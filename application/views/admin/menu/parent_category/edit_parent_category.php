<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/parent_category') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Parent Category</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-horizontal form-label-left" id="parent_category_update_form" name="parent_category_update_form"  method="post" action="<?= base_url('admin/parent_category/update') ?>">
            <input class="form-control" type="hidden" value="<?= $parent_category->parentCategoryId ?>" id="parentCategoryId" name="parentCategoryId">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="parent-category-name">Parent Category Name</label>
                        <input class="form-control" type="text" value="<?= $parent_category->parentCategoryName ?>" id="parentCategoryName" name="parentCategoryName" placeholder="Parent Category Name">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <a type="button" href="<?= base_url('admin/parent_category') ?>" class="btn btn-danger">Cancel</a>
                        <button id="send" type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
