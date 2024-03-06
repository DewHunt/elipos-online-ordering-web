<style type="text/css">
    #exTab1 .tab-content { padding : 2px; }
    /* remove border radius for the tab */
    #exTab1 .nav-pills > li > a { border-radius: 0; padding-right: 2px; padding-left: 2px; }
    #exTab1 .nav-pills > li > a { border-radius: 5px; padding: 12px; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>

    <div class="panel-body">
        <div id="exTab1">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <ul  class="nav nav-pills nav-stacked">
                        <li class="active"><a href="#new" data-toggle="tab" class="tab-btn">Composed Notification</a></li>
                        <li><a href="#sent" data-toggle="tab" class="tab-btn">Sent Notifications</a></li>
                        <li><a href="#trash" data-toggle="tab" class="tab-btn">Trash</a></li>
                    </ul>
                </div>

                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <div class="tab-content clearfix">
                        <div class="tab-pane active" id="new">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h2>Composed Notification</h2></div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <button type="button" class="btn btn-info btn-sm pull-right addNotificationFrom">Add New</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-table-panel draft-notification-table-div"><?= $draft_notification_table ?></div>
                                </div>
                            </div>                        
                        </div>

                        <div class="tab-pane" id="sent">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h2>Sent Notification</h2></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-table-panel sent-notification-table-div"><?= $sent_notification_table ?></div>
                                </div>
                            </div>                        
                        </div>

                        <div class="tab-pane" id="trash">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h2>Deleted Notification</h2></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-table-panel deleted-notification-table-div"><?= $deleted_notification_table ?></div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="view-modal-block"></div>

        <!-- Modal add Notification -->
        <div class="modal fade" id="addEditNotification" tabindex="-1" role="dialog" aria-labelledby="addNotification">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><span id="title-text">Add</span> Notification</h4>
                    </div>
                    <div class="modal-body">
                        <div class="add_edit_from_div"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal add Notification -->
        <div class="modal fade" id="sent-notification-modal" tabindex="-1" role="dialog" aria-labelledby="sent-notification-modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Notification</h4>
                    </div>

                    <div class="modal-body">
                        <div class="message-box">
                            <h4 class="title"></h4>
                            <hr>
                            <p class="message"></p>
                        </div>
                        <input type="hidden" id="notification-id" name="id" value="">
                    </div>

                    <div class="modal-footer">
                        <div class="row message-report" style="text-align: left !important; display: none">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: left !important">
                                <h2>Total Sent: <span id="sent-amount"></span></h2>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h2>Total Failed: <span id="failed-amount"></span></h2>
                            </div>
                        </div>
                        <div class="row sent-notification-btn-div">
                            <div class="right-side-view right-side-magin">
                                <button id="sent-notification-button" type="submit" class="btn btn-success">Sent</button>
                                <div id="sent-notification-loader" style="display: none"><img src="<?=base_url('assets/admin/loader/loader.gif')?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>