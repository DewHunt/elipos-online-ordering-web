<table id="modifier-table" class="table table-striped table-bordered dt-responsive list-dt">
    <thead class="thead-default">
        <tr>
            <th class="font-width width-table">SN</th>
            <th class="font-width">Modifier Name</th>
            <th class="font-width"> Category</th>
            <th class="font-width">Menu Price</th>
            <th class="font-width">Unit</th>
            <th class="font-width">Vat Rate (%)</th>
            <th class="font-width">Sort Order</th>
            <!-- <th class="font-width">Sort Order</th> -->
            <th class="font-width width-action">Action</th>
        </tr>
    </thead>

    <tbody>
        <?php if ($modifier_list): ?>
            <?php $count = 1; ?>
            <?php foreach ($modifier_list as $modifier): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($modifier->SideDishesName) ?></td>
                    <td><?= ucfirst($modifier->ModifierCategoryName) ?></td>
                    <td><?= $modifier->UnitPrice ?></td>
                    <td><?= $modifier->Unit ?></td>
                    <td><?= $modifier->VatRate ?></td>
                    <td><?= $modifier->SortOrder ?></td>
                    <!-- <td><?= $modifier->SortOrder ?></td> -->
                    <td>
                        <a href="<?= base_url("admin/modifier/edit_modifier/$modifier->SideDishesId") ?>" class="btn btn-primary"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="<?= base_url("admin/modifier/delete/$modifier->SideDishesId") ?>" class="btn btn-danger"><i class=" fa fa-times" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>