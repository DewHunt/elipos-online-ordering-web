<div class="panel panel-default">
    <div class="panel-heading"><h4>All Orders</h4></div>

    <div class="panel-body">
        <form class="form-label-left" id="search-orders-form" name="search-orders-form" method="post" action="<?= base_url('admin/all_orders/get_orders') ?>">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <div id="reportrange-new" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; ">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                            <div class="date-to-form">
                                <input id="to_date_id" type="hidden" name="to_date" value="">
                                <input id="from_date_id" type="hidden" name="from_date" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="order-status">Order Status</label>
                        <select class="form-control order-status select2" name="order_status">
                            <option value="all">All</option>
                            <option value="pending">Pending</option>
                            <option value="accept">Accepted</option>
                            <option value="reject">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="order-status">Platform</label>
                        <select class="form-control platform select2" name="platform">
                            <option value="all">All</option>
                            <option value="web">From Web</option>
                            <option value="android">From Android</option>
                            <option value="ios">From iOS</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <button id="send" type="submit" class="btn btn-success btn-block" style="margin-top: 25px;">Show</button>
                        <img class="process-loader" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                    </div>
                </div>
            </div>
        </form>
        <div class="form-table-panel"><?= $order_table ?></div>

        <div class="view-modal-block"></div>
    </div>
</div>