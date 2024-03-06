<style type="text/css">
    .inactive { color:red; font-weight:bold; }
    .active { color:green; font-weight:bold; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/vouchers/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Vouchers</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive list-dt">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Order Type</th>
                        <th>Min Order Amount</th>
                        <th>Discount</th>
                        <th width="150px">Validity</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $sl = 1; ?>
                    <?php foreach ($vouchers as $voucher): ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td><?= $voucher->title ?></td>
                            <td><?= $voucher->description ?></td>
                            <td style="text-transform: capitalize"><?= $voucher->order_type ?></td>
                            <td><?= $voucher->min_order_amount ?></td>
                            <td style="text-transform: capitalize">
                                <p>Type: <b><?= $voucher->discount_type ?></b></p>
                                <p>Amount: <b><?= $voucher->discount_amount ?></b></p>
                                <p>Max Amount: <b><?= $voucher->max_discount_amount ?></b></p>
                            </td>
                            <td class="text-center">
                                <?=$voucher->start_date?> To <?= $voucher->end_date ?>
                                <br>
                                <?= $this->Voucher_Model->getVoucherDaysText($voucher->validity_days); ?>
                                <br>
                                <?php if ($voucher->status == 0): ?>
                                    <div class="inactive">(Inactive)</div>
                                <?php else: ?>
                                    <div class="active">(Active)</div>
                                <?php endif ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url("admin/vouchers/edit/$voucher->id") ?>" class="btn btn-primary btn-sm"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a onclick="return confirm('Are you sure to delete?');" href="<?= base_url("admin/vouchers/delete/$voucher->id") ?>" class="btn btn-danger btn-sm"><i class=" fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>