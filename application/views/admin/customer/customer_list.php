<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4>Customer List</h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info btn-lg right-side-view" href="<?= base_url('admin/customer/customer_create') ?>"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add New Customer</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive list-dt" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Delivery Address</th>
                        <th width="150px">Action</th>
                    </tr>
                </thead>
                <?php $count = 1; ?>
                <tbody>
                    <?php foreach ($customer_list as $customer): ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= ucwords($customer->title.' '.$customer->first_name.' '.$customer->last_name) ?></td>
                            <td><?= $customer->mobile ?></td>
                            <td><a href="mailto:<?=trim($customer->email)?>" ><?=$customer->email?></a></td>
                            <td><?= get_customer_delivery_address_with_post_code($customer) ?></td>
                            <td class="text-center">
                                <a href="<?= base_url("admin/customer/customer_update/$customer->id") ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a onclick="return confirm('Are You Sure ?')" href="<?= base_url("admin/customer/delete/$customer->id") ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                <a href="<?= base_url("admin/customer/orders/$customer->id") ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>