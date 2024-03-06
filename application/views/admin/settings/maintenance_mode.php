<?php
    $maintenance_mode_settings = get_maintenance_mode_settings();
    $maintenance_mode_settings_value = (!empty($maintenance_mode_settings)) ? $maintenance_mode_settings->value : array();
    $maintenance_mode_settings_value = (!empty($maintenance_mode_settings_value)) ? json_decode($maintenance_mode_settings_value,true) : array();

    $maintenance_id = get_property_value('id',$maintenance_mode_settings);
    $environment = get_array_key_value('environment',$maintenance_mode_settings_value);
    $is_maintenance = get_array_key_value('is_maintenance',$maintenance_mode_settings_value);
    $is_app_maintenance = get_array_key_value('is_app_maintenance',$maintenance_mode_settings_value);
    $message = trim(get_array_key_value('message',$maintenance_mode_settings_value));
    $image = trim(get_array_key_value('image',$maintenance_mode_settings_value,'assets/no-imgee.jpg'));
    $is_for_today = get_array_key_value('is_for_today',$maintenance_mode_settings_value);
    $is_for_tomorrow = get_array_key_value('is_for_tomorrow',$maintenance_mode_settings_value);
?>

<style>
    .progress[value] { color: green; width: 100%; }
</style>
<?php
    $medias = '';
    if (!empty($social_media)) {
        $medias = json_decode($social_media->value);
    }
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>

    <div class="panel-body">
        <div class="error"><?php echo validation_errors(); ?></div>
        <form id="nochecx-settings-form" action="<?= base_url($this->admin.'/settings/maintenance_settings_insert') ?>" method="post">
            <input type="hidden" name="id" value="<?= $maintenance_id ?>">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="maintenance-mode-web">Maintenance Mode Web</label>
                                <select class="form-control" name="is_maintenance">
                                    <option value="0" <?= ($is_maintenance == 0) ? 'selected' : '' ?>>No</option>
                                    <option value="1" <?= ($is_maintenance == 1) ? 'selected' : '' ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="maintenance-mode-app">Maintenance Mode App</label>
                                <select class="form-control" name="is_app_maintenance">
                                    <option value="0" <?= ($is_app_maintenance == 0) ? 'selected' : '' ?>>No</option>
                                    <option value="1" <?= ($is_app_maintenance == 1) ? 'selected' : '' ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="environment-mode">Environment Mode</label>
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="radio" id="environmentModeTest" name="environment" placeholder="Environment mode" value="test" <?= ($environment == 'test') ? 'checked' : '' ?>> Test
                                </label>
                                <label class="radio-inline">
                                    <input class="" type="radio" id="environmentModeLive" name="environment" placeholder="Environment mode" value="live" <?= ($environment == 'live') ? 'checked' : '' ?>> Live
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top: 20px;">
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <?php
                                        $check = '';
                                        if ($is_for_today && $is_for_today['status'] == 1) {
                                            $check = 'checked';
                                        }
                                    ?>
                                    <input name="is_for_today" type="checkbox" value="1" <?= $check ?>>Is For Today
                                </label>
                                <label class="checkbox-inline">
                                    <?php
                                        $check = '';
                                        if ($is_for_tomorrow && $is_for_tomorrow['status'] == 1) {
                                            $check = 'checked';
                                        }
                                    ?>
                                    <input name="is_for_tomorrow" type="checkbox" value="1" <?= $check ?>>Is For Tomorrow
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" class="form-control" rows="4"><?= $message ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <!-- <label for="message">Image</label> -->
                    <div class="form-group">
                        <input type="hidden" name="image" id="maintenance_image" value="<?= $image ?>">
                        <span class="btn btn-primary btn-md btn-block" id="btn_show_images"><i class="fa fa-check-square-o" aria-hidden="true"></i> Select Image</span>
                    </div>
                    <div class="form-group">
                        <img class="img-thumbnail" src="<?= base_url($image); ?>" style="width: 160px; height: 120px;">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <button id="send" type="submit" style="float: right" class="btn btn-success">Save Change</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="modal fade" id="imageModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">All Mainetenance Images</h4>
                    </div>
                    <div class="modal-body">
                        <div id="images-div"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="btn-save-maintenance-image" data-dismiss="modal">Okay</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>