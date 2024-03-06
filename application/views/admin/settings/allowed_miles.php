<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/settings/add_allowed_miles') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Allowed Miles</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive list-dt">
                <thead class="thead-default">
                    <tr>
                        <th class="font-width width-table">Serial No</th>
                        <th class="font-width">Delivery Radius(Mile)</th>
                        <th class="font-width">Delivery Charge</th>
                        <th class="font-width">Min Order For Delivery</th>
                        <th class="font-width">Min Amount For Free Delivery Charge</th>
                        <th class="font-width width-action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allowed_miles_list as $allowed_miles): ?>
                        <tr>
                            <td><?= $allowed_miles->id ?></td>
                            <td><?= $allowed_miles->delivery_radius_miles ?></td>
                            <td><?= $allowed_miles->delivery_charge ?></td>
                            <td><?= $allowed_miles->min_order_for_delivery ?></td>
                            <td><?= $allowed_miles->min_amount_for_free_delivery_charge ?></td>
                            <td>
                                <a href="<?= base_url("admin/settings/edit_allowed_miles/$allowed_miles->id") ?>" class="btn btn-primary"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="<?= base_url("admin/settings/allowed_miles_delete/$allowed_miles->id") ?>" class="btn btn-danger"><i class=" fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




