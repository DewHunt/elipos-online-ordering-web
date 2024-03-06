<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-9"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/settings/opening_and_closing') ?>">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> List
                </a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="add-timing-form" action="<?= base_url('admin/settings/shop_timing_insert') ?>" method="post">
            <!--<input type="hidden" name="name" class="form-control" id="name" value="shop_timing">-->
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Day</label>
                    <div class="form-group">
                        <select class="form-control" name="day_id" id="day-id">
                            <option value="">Please Select</option>
                            <?php
                            foreach (get_days_of_week() as $day_id => $day_name) {
                                ?>
                                <option  value="<?= $day_id ?>"><?= $day_name ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Order Type</label>
                    <div class="form-group">
                        <select class="form-control" name="order_type" id="order_type">
                            <option value="">Please Select</option>
                            <?php

                            $orderTypes=array(
                                'collection',
                                'delivery'
                            );
                            foreach ($orderTypes as $orderType) {
                                ?>
                                <option  value="<?= $orderType?>"><?= ucfirst($orderType)?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Sort Order</label>
                    <div class="form-group">
                        <input class="form-control" type="number" id="sort_order" name="sort_order" placeholder="">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Open Time</label>
                    <div class="form-group">
                        <input class="form-control" type="time" id="open_time" name="open_time" placeholder="">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Close Time</label>
                    <div class="form-group">
                        <input class="form-control" type="time" id="close_time" name="close_time" placeholder="">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Collection/Delivery Time (Minute)</label>
                    <div class="form-group">
                        <input class="form-control" type="number" min="1" id="collection_delivery_time" name="collection_delivery_time" value="1">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button id="send" type="submit" class="btn btn-success">Save Change</button>
                </div>
            </div>
        </form>
    </div>
</div>