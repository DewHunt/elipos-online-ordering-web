<?php
    $desktop_data_settings = get_desktop_data_settings();
    $desktop_data_settings_value = (!empty($desktop_data_settings)) ? $desktop_data_settings->value : array();
    $desktop_data_settings_value = (!empty($desktop_data_settings_value)) ? json_decode($desktop_data_settings_value,true) : array();
    $desktop_data_id = get_property_value('id',$desktop_data_settings);
// dd($desktop_data_id);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-horizontal" id="menu_file_form" action="<?= base_url('admin/settings/set_menu_file_info_in_session'); ?>" method="POST" enctype="multipart/form-data" name="form">
            <div class="row">
                <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
                    <label for="upload-file">Upload File</label>
                    <div class="form-group">
                        <input class="form-control" type="file" id="menu_file" name="menu_file" required />
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 text-right" style="margin-top: 5px;">
                    <label></label>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-md btn-block" id="btn_menu_file">Upload</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="modal fade" id="user_authentication" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">User Authentication</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="user_authentication_form" action="<?= base_url('admin/settings/menu_upload_action'); ?>" method="POST" enctype="multipart/form-data" name="form">
                            <input class="form-control" type="hidden" name="file_data" id="file_data">
                            <input class="form-control" type="hidden" name="desktop_data_id" id="desktop_data_id" value="<?= $desktop_data_id ?>">
                            <div class="row">
                                <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
                                    <label for="password">Password</label>
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="password" id="password">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 text-right" style="margin-top: 5px;">
                                    <label></label>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-md btn-block">Okay</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="btn-save-maintenance-image" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>