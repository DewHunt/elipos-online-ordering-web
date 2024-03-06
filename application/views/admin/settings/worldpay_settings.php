<div class="panel panel-default">
    <div class="panel-heading"><h4><?= $title ?></h4></div>

    <div class="panel-body">
        <div class="error"><?= validation_errors(); ?></div>
        <form id="worldpay-settings-form" method="post" action="<?= base_url($this->admin.'/settings/worldpay_settings_insert') ?>">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= get_worldpay_settings_id() ?>">
            <input type="hidden" name="name" class="form-control" id="name" value="worldpay_settings">

            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="worldpay_status">
                            <option value="1" <?= get_worldpay_status() == 1 ? 'selected' : '' ?> >Yes</option>
                            <option value="0" <?= get_worldpay_status() == 0 ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label>Application Id</label>
                        <input class="form-control" type="text" name="worldpay_application_id" value="<?= get_worldpay_application_id() ?>" id="worldpay_application_id" placeholder="Application Id">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label>Currency</label>
                        <input class="form-control" type="text" name="worldpay_currency" value="<?= get_worldpay_currency() ?>" id="worldpay_currency" placeholder="Currency">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 text-right">
                    <button id="send" type="submit" class="btn btn-success">Save Change</button>
                </div>
            </div>
        </form>
    </div>
</div>