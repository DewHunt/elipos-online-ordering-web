<div class="panel panel-default">
    <div class="panel-heading"><h4><?= $title ?></h4></div>

    <div class="panel-body">
        <form name="search-orders-form" method="post" action="<?= base_url('admin/coupons/coupon_reports') ?>">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <div id="reportrange-new" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; ">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                            <div class="date-to-form">
                                <input id="from_date_id" type="hidden" name="from_date" value="">
                                <input id="to_date_id" type="hidden" name="to_date" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="order-status">Coupos</label>
                        <select class="form-control order-status select2" name="coupon_id[]" multiple>
                            <?php foreach ($coupons as $coupon): ?>
                                <?php
                                    $select = "";
                                    if (is_array($coupon_id_array) AND in_array($coupon->id, $coupon_id_array)) {
                                        $select = "selected";
                                    }
                                ?>
                                <option value="<?= $coupon->id ?>" <?= $select ?>><?= $coupon->code ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <button id="send" type="submit" class="btn btn-success btn-block" style="margin-top: 25px;">Show</button>
                        <img class="process-loader" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive" style="margin-top: 10px;">
            <table class="table table-striped table-bordered dt-responsive nowrap list-dt">
                <thead class="thead-default">
                    <tr>
                        <th class="text-center" width="20px">SN</th>
                        <th class="text-center" width="200px">Code</th>
                        <th class="text-center" width="500px">Title</th>
                        <th class="text-center" width="80px">Can Be Used</th>
                        <th class="text-center" width="80px">Total Used Up</th>
                        <th class="text-center" width="80px">Expired Date</th>
                        <th class="text-center" width="100px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $sl = 1 ?>
                    <?php if (!empty($coupon_reports)): ?>
                        <?php foreach ($coupon_reports as $report): ?>
                            <tr id="row_<?= $report->id ?>">
                                <td class="text-center"><?= $sl++ ?></td>
                                <td class="text-center"><?= $report->code ?></td>
                                <td><?= $report->title ?></td>
                                <td class="text-center"><?= $report->remaining_usages + $report->total_coupon_usages ?></td>
                                <td class="text-center"><?= $report->total_coupon_usages ?></td>
                                <td class="text-center"><?= $report->expired_date ?></td>
                                <td class="text-center">
                                    <span class="btn btn-primary btn-sm view-report-details" coupon-id="<?= $report->id ?>">View Details</span>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>

        <div id="view-modal-block"></div>
    </div>
</div>