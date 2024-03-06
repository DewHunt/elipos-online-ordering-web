<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info btn-md" href="<?= base_url('admin/buy_and_get/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Buy X Get Y</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table class="table table-striped table-bordered dt-responsive list-dt">
            <thead>
                <tr>
                    <th width="20px" class="text-center">Sl</th>
                    <th width="100px" class="text-center">Title</th>
                    <th width="120px" class="text-center">Buy X Get Y</th>
                    <th width="150px" class="text-center">Categories</th>
                    <th width="150px" class="text-center">Items</th>
                    <th width="70px" class="text-center">Date</th>
                    <th width="120px" class="text-center">Validity</th>
                    <th width="100px" class="text-center">Order Type</th>
                    <th width="60px" class="text-center">Status</th>
                    <th width="100px" class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $sl = 1; ?>
                <?php foreach ($buy_get_list as $buy_get): ?>
                    <?php
                        $availability = explode(',', $buy_get->availability);
                        $availability = ucwords(implode(', ', $availability));
                    ?>
                    <tr>
                        <td class="text-center"><?= $sl++; ?></td>
                        <td class="text-center"><?= $buy_get->title ?></td>
                        <td class="text-center">Buy <?= $buy_get->buy_qty ?> Get <?= $buy_get->get_qty ?></td>
                        <td class="text-center"><?= $buy_get->category_id ?></td>
                        <td class="text-center"><?= $buy_get->item_id ?></td>
                        <td class="text-center"><?= $buy_get->start_date?><br>To<br><?= $buy_get->end_date ?></td>
                        <td class="text-center">
                            <?= getDaysText($buy_get->validity_days) ?><br>
                            <?php if ($availability): ?>
                                And Available in <br><?= $availability ?>
                            <?php endif ?>
                        </td>
                        <td style="text-transform: capitalize" class="text-center"><?= $buy_get->order_type ?></td>
                        <td class="text-center"><?= $buy_get->status == 1 ? 'Active' : 'Inactive' ?></td>
                        <td class="text-center">
                            <a href="<?= base_url("admin/buy_and_get/edit/$buy_get->id") ?>" class="btn btn-primary btn-sm"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a onclick="return confirm('Are you sure to delete?');" href="<?= base_url("admin/buy_and_get/delete/$buy_get->id") ?>" class="btn btn-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>