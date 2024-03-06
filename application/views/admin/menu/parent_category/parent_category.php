<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/parent_category/add_parent_category') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Parent Category</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table class="table table-striped table-bordered dt-responsive list-dt">
            <thead class="thead-default">
                <tr>
                    <th class="font-width" width="20px">SN</th>
                    <th class="font-width">Parent Category Name</th>
                    <th class="font-width" width="80px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($parent_category_list)): ?>
                    <?php $count = 1; ?>
                    <?php foreach ($parent_category_list as $parent_category): ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $parent_category->parentCategoryName ?></td>
                            <td>
                                <a href="<?= base_url("admin/parent_category/edit_parent_category/$parent_category->parentCategoryId") ?>" class="btn btn-primary"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                <a href="<?= base_url("admin/parent_category/delete/$parent_category->parentCategoryId") ?>" class="btn btn-danger"> <i class=" fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>