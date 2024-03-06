<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/sub_product_files/add_item') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Sub Product Files Item</a>
                <a class="btn btn-info" href="<?= base_url('admin/sub_product_files/assign') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Assign/Remove Sub Product Files Item</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table id="sub-product-files-table" class="table table-striped table-bordered dt-responsive product-files-item list-dt">
            <thead class="thead-default">
                <tr>
                    <th class="font-width" width="20px">SN</th>
                    <th class="font-width" width="300px">Item Name</th>
                    <th class="font-width" width="300px">Item Full Name</th>
                    <th class="font-width" width="120px">Table Price</th>
                    <th class="font-width" width="150px">Takeaway Price</th>
                    <th class="font-width" width="100px">Bar Price</th>
                    <th class="font-width" width="100px">Vat Rate</th>
                    <th class="font-width" width="110px">Sort Order</th>
                    <th class="font-width" width="110px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
                <?php if ($sub_product_list_details): ?>
                    <?php foreach ($sub_product_list_details as $sub_product): ?>                        
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $sub_product->selectiveItemName ?></td>
                            <td><?= $sub_product->selectiveItemFullName ?></td>
                            <td><?= $sub_product->tablePrice ?></td>
                            <td><?= $sub_product->takeawayPrice ?></td>
                            <td><?= $sub_product->barPrice ?></td>
                            <td><?= $sub_product->vatRate ?></td>
                            <td><?= $sub_product->SortOrder ?></td>
                            <td class="text-center">
                                <a href="<?= base_url("admin/sub_product_files/edit_item/$sub_product->selectiveItemId") ?>" class="btn btn-sm btn-primary"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="<?= base_url("admin/sub_product_files/delete_item/$sub_product->selectiveItemId") ?>" onclick="return confirm('Are You Sure to Delete ?');" class="btn btn-sm btn-danger"><i class=" fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>