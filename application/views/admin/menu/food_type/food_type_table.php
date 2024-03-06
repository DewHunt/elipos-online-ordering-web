<table class="table table-striped table-bordered dt-responsive food-type-tab list-dt">
    <thead class="thead-default">
        <tr>
            <th class="font-width width-table">Serial No</th>
            <th class="font-width">Food Type Name</th>
            <th class="font-width width-action">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($food_type_list)): ?>
            <?php $count = 1; ?>
            <?php foreach ($food_type_list as $food_type): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($food_type->foodTypeName) ?></td>
                    <td>
                        <a href="<?= base_url("admin/food_type/edit_food_type/$food_type->foodTypeId") ?>" class="btn btn-primary"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>

                        <a href="<?= base_url("admin/food_type/delete/$food_type->foodTypeId") ?>" class="btn btn-danger"><i class=" fa fa-times" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>