<style>
    .label-design { font-size: 22px; padding-right: 8px }
    .input-width-height { width: 80px; height: 29px; text-align: right; }
    .btn-width-height { width: 120px; height: 29px; }
    #save-message { font-size: 16px; font-weight: bold; color: green; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/coupons/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Coupons</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <?php
            $i = 1;
        ?>
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 text-right">
                <?php
                    $check = '';
                    if ($isCouponIsEnabled) {
                        $check = 'checked';
                    }
                ?>
                <label class="label-design">
                    <input type="checkbox" name="isCouponEnabled" id="isCouponEnabled" <?= $check ?>>&nbsp;Enabled
                </label>
                <label class="label-design">
                    <button type="button" class="btn btn-primary btn-sm btn-width-height" id="save-settings">Save</button>
                </label>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <span id="save-message"></span>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-striped table-bordered list-dt">
                <thead>
                    <tr>
                        <th class="text-center" width="20px">SL</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Title</th>
                        <th class="text-center" width="60px">Order Type</th>
                        <th class="text-center" width="50px">Min Amount</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center" width="50px">Max Usage</th>
                        <th class="text-center" width="70px">Expired Date</th>
                        <th class="text-center" width="100px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($coupons as $coupon): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $coupon->code ?></td>
                            <td><?= $coupon->title ?></td>
                            <td style="text-transform: capitalize" class="text-center"><?= $coupon->order_type ?></td>
                            <td class="text-center"><?= $coupon->min_order_amount ?></td>
                            <td class="text-center">
                                <?php
                                    $discount_text = get_price_text($coupon->discount_amount);
                                    if ($coupon->discount_type == 'percent') {
                                        $discount_text = $coupon->discount_amount."%<br>Up To <br>".get_price_text($coupon->max_discount_amount);
                                    }
                                ?>
                                <?= $discount_text ?>
                            </td>
                            <td class="text-center"><?= $coupon->remaining_usages ?></td>
                            <td class="text-center"><?= getFormatDateTime($coupon->expired_date,'d-m-y') ?></td>
                            <td class="text-center">
                                <a href="<?= base_url("admin/coupons/edit/$coupon->id") ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a onclick="return confirm('Are you sure to delete?');" href="<?= base_url("admin/coupons/delete/$coupon->id") ?>" class="btn btn-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>