<?php
    $stripe_details = get_stripe_settings();
    $display_name = '';
    $publishable_key = '';
    $secret_key = '';
    if (!empty($stripe_details)) {
        $display_name = property_exists($stripe_details,'display_name') ? $stripe_details->display_name : '';
        $publishable_key = property_exists($stripe_details,'publishable_key') ? $stripe_details->publishable_key : '';
        $secret_key = property_exists($stripe_details,'secret_key') ? $stripe_details->secret_key : '';
    }
?>

<div class="panel panel-default">
    <div class="panel-heading"><h4><?= $title ?></h4></div>

    <div class="panel-body">
        <div class="error"><?= validation_errors(); ?></div>
        <form id="paypal-settings-form" method="post" action="<?= base_url($this->admin . '/settings/stripe_settings_insert') ?>">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= get_stripe_settings_id() ?>">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="fornt-end-display-name">Front-End Display Name</label>
                        <input class="form-control" type="text" name="display_name" id="display-name" placeholder="Front-End Display Name" value="<?= $display_name ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="col-lg-8 col-md-9 col-sm-9 col-xs-12">Secret key</label>
                        <input class="form-control" type="text" name="secret_key" id="secret_key" placeholder="Secret key" value="<?=$secret_key?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="publication-key">Publishable key</label>
                        <input class="form-control" type="text" id="secret_key" name="publishable_key" placeholder="  Publishable key" value="<?=$publishable_key?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <button id="send" type="submit" class="btn btn-success">Save Change</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>