<div class="panel panel-default">
    <div class="panel-heading"><h4><?= $title ?></h4></div>

    <div class="panel-body">
        <div class="error"><?= validation_errors(); ?></div>
        <form id="nochecx-settings-form" action="<?= base_url($this->admin . '/settings/nochecx_settings_insert') ?>" method="post">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= get_nochecx_settings_id() ?>">
            <input type="hidden" name="name" class="form-control" id="name" value="nochecx_settings">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="fornt-end-display-name">Front-End Display Name</label>
                        <input class="form-control" type="text" name="display_name" id="display-name" placeholder="Front-End Display Name" value="<?= get_nochecx_display_name() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="nochecx-merchant-email">Nochex Merchant Email</label>
                        <input class="form-control" type="email" name="nochecx_merchant_email" value="<?= get_nochecx_merchant_email() ?>" id="nochecx-merchant-email" placeholder="Nochex Merchant Email">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="nochecx-callback-url">Nochex Callback Url</label>
                        <input class="form-control" type="url" value="<?= get_nochecx_callback_url()?>" id="nochecx-callback-url" name="nochecx_callback_url" placeholder="Nochex callback url">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="nochecx-success-url">Nochex Success url</label>
                        <input class="form-control" type="url" value="<?= get_nochecx_success_url() ?>" id="nochecx-success-url" name="nochecx_success_url" placeholder="Nochex success url">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="nochecx-cancel-url">Nochex Cancel url</label>
                        <input class="form-control" type="url" value="<?= get_nochecx_cancel_url()?>" id="nochecx-cancel-url" name="nochecx_cancel_url" placeholder="Nochex Cancel url">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="nochecx-description">Nochex Description</label>
                        <textarea class="form-control" type="text" id="nochecx-description" rows="3" name="nochecx_description" placeholder="Nochex Description"><?= get_nochecx_description() ?></textarea>
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