<?php
    // echo "<pre>"; print_r($pay360_settings); exit();
    $pay360_settings_id = '';
    $pay360_merchant_id = '';
    $pay360_isv_id = '';
    $pay360_api_id = '';
    $pay360_api_key = '';
    $pay360_payment_api_key = '';
    $pay360_jwt = '';
    $pay360_description = '';
    $pay360_payment_mode = '';
    
    if ($pay360_settings) {
        $pay360_value = json_decode($pay360_settings->value);
        if (isset($pay360_settings->id)) {
            $pay360_settings_id = $pay360_settings->id;
        }

        if (isset($pay360_value->pay360_merchant_id)) {
            $pay360_merchant_id = $pay360_value->pay360_merchant_id;
        }

        if (isset($pay360_value->pay360_isv_id)) {
            $pay360_isv_id = $pay360_value->pay360_isv_id;
        }

        if (isset($pay360_value->pay360_api_id)) {
            $pay360_api_id = $pay360_value->pay360_api_id;
        }

        if (isset($pay360_value->pay360_api_key)) {
            $pay360_api_key = $pay360_value->pay360_api_key;
        }

        if (isset($pay360_value->pay360_payment_api_key)) {
            $pay360_payment_api_key = $pay360_value->pay360_payment_api_key;
        }

        if (isset($pay360_value->pay360_jwt)) {
            $pay360_jwt = $pay360_value->pay360_jwt;
        }

        if (isset($pay360_value->pay360_description)) {
            $pay360_description = $pay360_value->pay360_description;
        }

        if (isset($pay360_value->pay360_payment_mode)) {
            $pay360_payment_mode = $pay360_value->pay360_payment_mode;
        }

    }
?>
<div class="panel panel-default">
    <div class="panel-heading"><h4><?= $title ?></h4></div>

    <div class="panel-body">
        <div class="error"><?= validation_errors(); ?></div>
        <form id="pay360-settings-form" action="<?= base_url($this->admin.'/settings/pay360_settings_insert') ?>" method="post">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= $pay360_settings_id ?>">
            <input type="hidden" name="name" class="form-control" id="name" value="pay360_settings">

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Merchant ID</label>
                        <input class="form-control" type="text" name="pay360_merchant_id" id="pay360_merchant_id" value="<?= $pay360_merchant_id ?>" placeholder="Pay360 Merchant ID">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>ISV ID</label>
                        <input class="form-control" type="text" name="pay360_isv_id" id="pay360_isv_id" value="<?= $pay360_isv_id ?>" placeholder="Pay360 ISV ID">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Payment Mode</label>
                        <br>
                        <label class="radio-inline">
                            <input type="radio" name="pay360_payment_mode" value="0" <?= $pay360_payment_mode == 0 ? 'checked' : '' ?>>Test Mode
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="pay360_payment_mode" value="1" <?= $pay360_payment_mode == 1 ? 'checked' : '' ?>>Live Mode
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>API ID</label>
                        <input class="form-control" type="text" name="pay360_api_id" id="pay360_api_id" value="<?= $pay360_api_id ?>" placeholder="Pay30 API ID">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>API Key</label>
                        <input class="form-control" type="text"name="pay360_api_key" id="pay360_api_key" value="<?= $pay360_api_key ?>" placeholder="Pay360 API Key">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Payment API Key</label>
                        <input class="form-control" type="text" name="pay360_payment_api_key" id="pay360_payment_api_key" value="<?= $pay360_payment_api_key ?>" placeholder="Pay360 API Key">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>JWT</label>
                        <input class="form-control" type="text" name="pay360_jwt" id="pay360_jwt" value="<?= $pay360_jwt ?>" placeholder="Pay30 JWT">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Pay360 Description</label>
                        <textarea class="form-control" name="pay360_description" id="pay360_description" rows="3" placeholder="Pay360 Description"><?= $pay360_description ?></textarea>
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