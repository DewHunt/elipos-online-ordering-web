<?php
    $payPalSettings = get_paypal_settings();
    $environment = get_property_value('environment',$payPalSettings);
?>

<div class="panel panel-default">
    <div class="panel-heading"><h4><?= $title ?></h4></div>

    <div class="panel-body">
        <div class="error"><?= validation_errors(); ?></div>
        <form id="paypal-settings-form" method="post"
              action="<?= base_url($this->admin . '/settings/paypal_settings_insert') ?>">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= get_paypal_settings_id() ?>">
            <input type="hidden" name="name" class="form-control" id="name" value="paypal_settings">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="fornt-end-display-name">Front-End Display Name</label>
                        <input class="form-control" type="text" name="display_name" id="display-name" placeholder="Front-End Display Name" value="<?= get_property_value('display_name',$payPalSettings) ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="environment-mode">Environment Mode</label>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input  type="radio" id="environmentModeSandBox" name="environment" placeholder="Environment mode" value="sandbox" <?= ($environment == 'sandbox') ? 'checked' : '' ?>>SandBox
                        </label>
                        <label class="radio-inline">
                            <input class="" type="radio" id="environmentMode" name="environment" placeholder="Environment mode" value="live" <?= ($environment == 'live') ? 'checked' : '' ?>> Live
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="currency">Select Currency *</label>
                        <select class="form-control" name="currency">
                            <?php
                                $currency_array = get_currency_array();
                            ?>
                            <?php foreach ($currency_array as $key => $value): ?>
                                <?php
                                    $select = '';
                                    if (get_property_value('currency',$payPalSettings) == $key) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?=$key?>" <?= $select ?>><?= $value ?></option>                                    
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="paypal-api-username">Paypal API Username</label>
                        <input class="form-control" type="text" name="paypal_api_username" id="paypal-api-username" placeholder="Paypal API Username" value="<?= get_paypal_api_username() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sandbox-client-id">Sandbox Client Id *</label>
                        <input class="form-control" type="text" id="sandbox_client_id" name="sandbox_client_id" placeholder="Sandbox Client id" value="<?= get_property_value('sandbox_client_id',$payPalSettings) ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sandbox-client-secrect">Sandbox Client Secret*</label>
                        <input class="form-control" type="password" id="sandbox_client_secret" name="sandbox_client_secret" placeholder="Sandbox Client Secret" value="<?= get_property_value('sandbox_client_secret',$payPalSettings) ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="production-client-id">Production Client Id *</label>
                        <input class="form-control" type="text" id="production_client_id"name="production_client_id" placeholder="Production Client id"value="<?= get_property_value('production_client_id',$payPalSettings) ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="production-client-secrect">Production  Client Secret *</label>
                        <input class="form-control" type="password" id="production_client_secret" name="production_client_secret" placeholder="Production Client Secret" value="<?= get_property_value('production_client_secret',$payPalSettings) ?>">
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