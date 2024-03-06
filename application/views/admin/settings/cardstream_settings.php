<?php
    $environment = get_cardstream_environment();
    $url_mode = get_cardstream_url_mode();
    // dd($url_mode);
?>

<div class="panel panel-default">
    <div class="panel-heading"><h4><?= $title ?></h4></div>

    <div class="panel-body">
        <div class="error"><?= validation_errors(); ?></div>

        <form id="sagepay-settings-form" method="post" action="<?= base_url($this->admin . '/settings/cardstream_settings_insert') ?>">
            <input type="hidden" class="form-control" id="id" name="id" value="<?= get_cardstream_settings_id() ?>">
            <input type="hidden" class="form-control" id="name" name="name" value="cardstream_settings">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label for="vendor-name">Front-End Display Name</label>
                        <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Front-End Vendor Name" value="<?= get_cardstream_display_name() ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label for="signature-key">Signature Key/Merchant Secret</label>
                        <input type="text" class="form-control" id="signature_key" name="signature_key" placeholder="Signature Key/Merchant Secrect" value="<?= get_cardstream_signature_key() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="environment">Environment</label>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" id="test_mode" name="environment" value="test" <?= ($environment == 'test') ? 'checked' : '' ?>>Test Mode
                        </label>
                        <label class="radio-inline">
                            <input type="radio" id="live_mode" name="environment" value="live" <?= ($environment == 'live') ? 'checked' : '' ?>> Live Mode
                        </label>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="payment-url">Payment URL</label>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" id="hosted_url" name="url_mode" value="hosted_url" <?= ($url_mode == 'hosted_url') ? 'checked' : '' ?>>Hosted URL
                        </label>
                        <label class="radio-inline">
                            <input type="radio" id="direct_url" name="url_mode" value="direct_url" <?= ($url_mode == 'direct_url') ? 'checked' : '' ?>>Direct URL
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="vendor-name">Marchant Account ID</label>
                        <input type="text" class="form-control" id="marchant_account_id" name="marchant_account_id" placeholder="Marchant Account ID" value="<?= get_cardstream_marchant_account_id() ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="vendor-name">Redirect URL</label>
                        <input type="text" class="form-control" id="redirect_url" name="redirect_url" placeholder="Redirect URL" value="<?= get_cardstream_redirect_url() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sucess-url">Test Hosted URL</label>
                        <input type="url" class="form-control" id="test_hosted_url" name="test_hosted_url" placeholder="Test Hosted URL (uses test data, not connected to banks)" value="<?= get_cardstream_test_hosted_url() ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="failur-url">Live Hosted URL</label>
                        <input type="url" class="form-control" id="live_hosted_url" name="live_hosted_url" placeholder="Live Hosted URL (uses live data)" value="<?= get_cardstream_live_hosted_url() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sucess-url">Test Direct URL</label>
                        <input type="url" class="form-control" id="test_direct_url" name="test_direct_url" placeholder="Test Direct URL (uses test data, not connected to banks)" value="<?= get_cardstream_test_direct_url() ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="failur-url">Live Direct URL</label>
                        <input type="url" class="form-control" id="live_direct_url" name="live_direct_url" placeholder="Live Direct URL (uses live data)" value="<?= get_cardstream_live_direct_url() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Sagepay Description"><?= get_cardstream_description() ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group"><button id="send" type="submit" class="btn btn-success">Save Change</button></div>
                </div>
            </div>
        </form>
    </div>
</div>