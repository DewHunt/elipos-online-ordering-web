<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/modifier_category/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Modifier Category</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table class="table table-striped table-bordered dt-responsive list-dt">
            <thead class="thead-default">
            <tr>
                <th width="20px">SN</th>
                <th width=""> Name</th>
                <th width="50px">Limit</th>
                <th width="70px">Sort Order</th>
                <th width="90px">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php if ($modifier_categories): ?>
                    <?php $count = 1; ?>
                    <?php foreach ($modifier_categories as $category): ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= ucfirst($category->ModifierCategoryName) ?></td>
                            <td><?= ucfirst($category->ModifierLimit) ?></td>
                            <td><?= ucfirst($category->SortOrder) ?></td>
                            <td class="text-center">
                                <a href="<?= base_url("admin/modifier_category/edit/$category->ModifierCategoryId") ?>" class="btn btn-sm btn-primary"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="<?= base_url("admin/modifier_category/delete/$category->ModifierCategoryId") ?>" class="btn btn-sm btn-danger"><i class=" fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>