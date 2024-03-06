<?php
    $statusArray = array('pending'=>'Pending','accept'=>'Accepted','reject'=>'Rejected',);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4>Daywise Booking</h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/booking_customer/add') ?>">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add New Booking
                </a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-horizontal form-label-left" id="search-booking-form" name="search-orders-form" method="post" action="<?= base_url('admin/booking_customer/get_booking') ?>">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="booking-date">Bokking Date</label>
                        <div id="reportrange-new" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                            <div class="date-to-form">
                                <input id="to_date_id" type="hidden" name="to_date" value="">
                                <input id="from_date_id" type="hidden" name="from_date" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control select2 status" id="status" name="status">
                            <option value="">Select Status</option>
                            <?php foreach ($statusArray as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>                                
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <button id="send" type="submit" class="btn btn-success btn-block" style="margin-top: 23px;">Show</button>
                        <img class="process-loader" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-block"><?php $this->load->view('admin/booking/table_data'); ?></div>
    </div>
</div>

<div class="modal fade booking-view-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="text-xs-center"  style="font-size:2rem">Booking Details</h4>
            </div> -->
            <div class="view-data"></div>
        </div>
    </div>
</div>