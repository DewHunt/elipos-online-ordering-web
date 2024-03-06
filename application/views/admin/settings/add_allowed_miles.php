<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/settings/allowed_miles') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Allowed Miles</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="allowed-miles-add-settings-form" action="<?= base_url('admin/settings/allowed_miles_save') ?>" method="post">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="delivery-radius-mile">Delivery Radius (Mile)</label>
                        <input class="form-control" type="text" value="" id="delivery_radius_miles" name="delivery_radius_miles" placeholder="Delivery Radius (Mile)">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="delivery-charge">Delivery Charge</label>
                        <input class="form-control" type="text" value="" id="delivery_charge" name="delivery_charge" placeholder="Delivery Charge">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="min-order-for-delivery">Min Order For Delivery</label>
                        <input class="form-control" type="text" value="" id="min_order_for_delivery" name="min_order_for_delivery" placeholder="Min Order For Delivery">
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Minimum Amount For Free Delivery Charge</label>
                        <input class="form-control" type="text" value="" id="min_amount_for_free_delivery_charge" name="min_amount_for_free_delivery_charge" placeholder="Minimum Amount For Free Delivery Charge">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="form-group">
                        <p>Min order value for delivery to this Distance. If left to 0 the value under "Delivery Options" tab will take place.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <button id="send" type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


