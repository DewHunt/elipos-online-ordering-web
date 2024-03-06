<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/coupons') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Coupons</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="coupon-form" method="post" action="<?= base_url('admin/coupons/update') ?>">
            <input type="hidden" name="id" value="<?= $coupon->id; ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="code">Code</label>
                    <div class=" form-group">
                        <input type="text" class="form-control" id="code" pattern=".{6,}" required title="6 alpha numeric minimum" name="code" value="<?= $coupon->code; ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="title">Title</label>
                    <div class=" form-group">
                        <input type="text" class="form-control" id="title" name="title" value="<?= $coupon->title; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="min-order-amount">Min Order Amount</label>
                    <div class="form-group">
                        <input type="number" class="form-control" id="min-order-amount" name="min_order_amount" value="<?= get_property_value('min_order_amount',$coupon,1); ?>">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class=" form-group">
                        <label for="validity-days">Validity</label>
                        <div id="reportrange-new" class="pull-right calender-block">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                            <div class="date-to-form">
                                <input id="from_date" type="hidden" name="start_date" value="<?= $coupon->start_date ?>">
                                <input id="to_date" type="hidden" name="expired_date" value="<?= $coupon->expired_date ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="discount-type">Discount Type</label>
                    <div class=" form-group">
                        <select class="form-control select2" name="discount_type" id="discount-type">
                            <?php foreach ($discount_type_array as $key => $value): ?>
                                <?php
                                    $select = '';
                                    if ($key == $coupon->discount_type) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="discount-amount">Discount Amount</label>
                    <div class="form-group">
                        <input type="number" class="form-control" name="discount_amount" id="discount-amount" value="<?= get_property_value('discount_amount',$coupon,0); ?>">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="discount-amount-up-to">Amount Up to </label>
                    <div class=" form-group">
                        <input type="number" class="form-control" name="max_discount_amount" id="discount-amount-up-to" value="<?=get_property_value('max_discount_amount',$coupon,0);?>">
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="order_type">Order Type</label>
                    <div class=" form-group">
                        <select class="form-control select2" name="order_type" id="order-type">
                            <?php foreach ($order_type_array as $key => $value): ?>
                                <?php
                                    $select = '';
                                    if ($key == $coupon->order_type) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="order_type_to_use">Order Type To Use</label>
                    <div class=" form-group">
                        <select class="form-control select2" name="order_type_to_use" id="order_type_to_use">
                            <?php foreach ($order_type_to_use_array as $key => $value): ?>
                                <?php
                                    $select = '';
                                    if ($key == $coupon->order_type_to_use) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="remaining_usages">Maximum Time Usage</label>
                    <div class=" form-group">
                        <input type="number" min="0" class="form-control" name="remaining_usages" id="remaining_usages" value="<?=get_property_value('remaining_usages',$coupon,0);?>">
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="status">Status</label>
                    <div class=" form-group">
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1" <?= get_property_value('status', $coupon,1) == 1 ? 'checked' : '' ?>>
                            Active
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0" <?= get_property_value('status', $coupon,1) == 0 ? 'checked' : '' ?>>
                            In Acive
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="message">Description</label>
                    <div class=" form-group">
                        <textarea class="form-control" value="" id="message" name="description" placeholder="Description" rows="4"><?= $coupon->description; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button  id="send" type="submit" class="btn btn-primary" style="float: right">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>