<div class="panel panel-default">
    <div class="panel-heading"><h4><?= $title ?></h4></div>

    <div class="panel-body">
        <div class="error"><?= validation_errors(); ?></div>

        <form id="sagepay-settings-form" method="post" action="<?= base_url($this->admin . '/settings/sagepay_settings_insert') ?>">
            <input type="hidden" class="form-control" id="id" name="id" value="<?= get_sagepay_settings_id() ?>">
            <input type="hidden" class="form-control" id="name" name="name" value="sagepay_settings">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="vendor-name">Front-End Display Name</label>
                        <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Front-End Vendor Name" value="<?= get_sagepay_display_name() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <?php $environment = get_sagepay_environment(); ?>                    
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
                    <div class="form-group">
                        <label for="vendor-name">Vendor Name</label>
                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="Vendor Name" value="<?= get_sagepay_vendor_name() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sucess-url">Sandbox Server</label>
                        <input type="url" class="form-control" id="sandbox_server" name="sandbox_server" placeholder="Sandbox server (uses test data, not connected to banks)" value="<?= get_sagepay_sandbox_server() ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="failur-url">Production Server</label>
                        <input type="url" class="form-control" id="production_server" name="production_server" placeholder="Production server (uses live data)" value="<?= get_sagepay_production_server() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sandbox-integration-key">Sandbox Integration Key</label>
                        <input type="text" class="form-control" id="sandbox_integration_key" name="sandbox_integration_key" placeholder="Sandbox Integration Key" value="<?= get_sagepay_sandbox_integration_key() ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="production-integration-key">Production Integration Key</label>
                        <input type="text" class="form-control" id="production_integration_key" name="production_integration_key" placeholder="Production Integration Key" value="<?= get_sagepay_production_integration_key() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sandbox-integration-password">Sandbox Integration Password</label>
                        <input type="text" class="form-control" id="sandbox_integration_password" name="sandbox_integration_password" placeholder="Sandbox Integration Password" value="<?= get_sagepay_sandbox_integration_password() ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="production-integration-password">Production Integration Password</label>
                        <input type="text" class="form-control" id="production_integration_password" name="production_integration_password" placeholder="Production Integration Password" value="<?= get_sagepay_production_integration_password() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Sagepay Description"><?= get_sagepay_description() ?></textarea>
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