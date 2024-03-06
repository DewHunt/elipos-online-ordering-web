<style>
    .process-loader{ margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; }
    .tile_count { margin-bottom: 0px; margin-top: 0px }
    .tile_count .tile_stats_count { padding: 0px 0px 10px 0px; }
    .modal-body { max-height: calc(100vh - 212px); overflow-y: auto }
    .failed-note { color: red; }
    .success-note { color: green; }
    @media (min-width: 992px) {
        .tile_count .tile_stats_count { margin-bottom: 0px; padding-bottom: 0px; }
    }
    .report-calender-form { display: inline-flex !important; float: right !important; }
    .report-calender { background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; text-align: center; }
</style>

<div class="container body">
    <div class="main_container">
        <?php
            $this->load->view('admin/navigation');
            $m_order_information = new Order_information_Model();
            $m_order_details = new Order_details_Model();
        ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="page-title">
                <div class="title_left"></div>
                <div class="clearfix"></div>
                <!-- top tiles -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row tile_count">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                                <span class="count_top"><center><i class="fa fa-user"></i>&nbsp;Total Orders</center></span>
                                <div class="count text-align-center"><?= get_total_number_of_orders(); ?></div>
                                <span class="count_bottom">
                                    <center>
                                        <i class="green">
                                            <i class="fa fa-sort-asc"></i>
                                            <?= get_total_number_of_orders_of_last_week(); ?>
                                        </i>
                                        &nbsp;<span>From last Week</span>
                                    </center>
                                </span>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                                <span class="count_top"><center><i class="fa fa-user"></i>&nbsp;Collection Orders</center></span>
                                <div class="count text-align-center"><?= get_total_number_of_orders_by_order_type('collection'); ?></div>
                                <span class="count_bottom">
                                    <center>
                                        <i class="green">                                                
                                            <i class="fa fa-sort-asc"></i>
                                            <?= get_total_number_of_orders_of_last_week_by_order_type('collection') ?>
                                        </i>
                                        &nbsp;<span>From last Week</span>
                                    </center>
                                </span>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                                <span class="count_top"><center><i class="fa fa-user"></i>&nbsp;Delivery Orders</center></span>
                                <div class="count text-align-center"><?= get_total_number_of_orders_by_order_type('delivery'); ?></div>
                                <span class="count_bottom">
                                    <center>
                                        <i class="green">
                                            <i class="fa fa-sort-asc"></i>
                                            <?= get_total_number_of_orders_of_last_week_by_order_type('delivery') ?>
                                        </i>
                                        &nbsp;<span>From last Week</span>
                                    </center>
                                </span>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                                <span class="count_top"><center><i class="fa fa-user"></i>&nbsp;Collection Amount</center></span>
                                <div class="count text-align-center"><center><?= number_format(get_total_orders_amount_by_order_type('collection'), 2); ?></center></div>
                                <span class="count_bottom">
                                    <center>
                                        <i class="green">
                                            <i class="fa fa-sort-asc"></i>
                                            <?= number_format(get_total_orders_amount_of_last_week_by_order_type('collection'), 2); ?>
                                        </i>
                                        &nbsp;<span>From last Week</span>
                                    </center>
                                </span>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                                <span class="count_top"><center><i class="fa fa-user"></i>&nbsp;Delivery Amount</center></span>
                                <div class="count text-align-center"><center><?= number_format(get_total_orders_amount_by_order_type('delivery'), 2) ?></center></div>
                                <span class="count_bottom">
                                    <center>
                                        <i class="green">
                                            <i class="fa fa-sort-asc"></i>
                                            <?= number_format(get_total_orders_amount_of_last_week_by_order_type('delivery'), 2); ?>
                                        </i>
                                        &nbsp;<span>From last Week</span>
                                    </center>
                                </span>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                                <span class="count_top"><center><i class="fa fa-user"></i>&nbsp;Total</center></span>
                                <div class="count text-align-center"><?= number_format(get_total_order_amount(), 2) ?></div>
                                <span class="count_bottom">
                                    <center>
                                        <i class="green">
                                            <i class="fa fa-sort-asc"></i>
                                            <?= number_format(get_total_order_amount_of_last_week(), 2); ?>
                                        </i>
                                        &nbsp;<span>From last Week</span>
                                    </center>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /top tiles -->

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="dashboard_graph">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <form id="dashboard-date-select-form" class="report-calender-form" action="<?=base_url('admin/dashboard/get_by_date')?>" method="post">
                                        <div id="reportrange-new" class="report-calender">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                                            <div class="date-to-form">
                                                <input id="to_date_id" type="hidden" name="to_date" value="">
                                                <input id="from_date_id" type="hidden" name="from_date" value="">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary " style=" margin-bottom: 0;margin-left: 10px">Submit</button>
                                    </form>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <div class="last-n-days-order-graph-block"><?=$last_n_days_order?></div>
                                    <img class="process-loader" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 bg-white">
                                    <div class="top-five-products"><?= $top_five_product?></div>
                                    <img class="process-loader"  src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="latest-order-block"><?= $latest_order ?></div>
                        <img class="process-loader"  src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="top-customer-block"><?= $top_customer;?></div>
                        <img class="process-loader"  src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="account-summery-block"><?= $account_summary; ?></div>
                        <img class="process-loader"  src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="login-activities-div">
                            <?= $login_activity ?>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><h2>Login/Logout Report</h2></h4>
                            </div>
                            <div class="modal-body">
                                <?= $all_login_activity; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('admin/footer'); ?>
        <div class="clearfix"></div>
        <br>
        <br>
        <br>
        <!-- /page content -->
    </div>
</div>

<script type="text/javascript">
    var start = moment();
    var end = moment();
    function cb(start, end) {
        $('#reportrange-new .date-to-form input[name="to_date"]').val(end.format('YYYY-MM-DD'));
        $('#reportrange-new .date-to-form input[name="from_date"]').val(start.format('YYYY-MM-DD'));
        $('#reportrange-new span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange-new').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);

    $("#dashboard-date-select-form").submit(function (event) {
        event.preventDefault();
        $('.process-loader').css('display','block');

        $('.last-n-days-order-graph-block').css('display','none');
        $('.top-five-products').css('display','none');
        $('.latest-order-block').css('display','none');
        $('.top-customer-block').css('display','none');
        $('.account-summery-block').css('display','none');
        $.post($(this).attr('action'), $(this).serialize(), function (data) {
            $('.process-loader').css('display','none');

            $('.last-n-days-order-graph-block').css('display','block');
            $('.last-n-days-order-graph-block').html(data['last_n_days_order']);

            $('.top-five-products').html(data['top_five_product']);
            $('.top-five-products').css('display','block');

            $('.latest-order-block').html(data['latest_order']);
            $('.latest-order-block').css('display','block');

            $('.top-customer-block').html(data['top_customer']);
            $('.top-customer-block').css('display','block');

            $('.account-summery-block').html(data['account_summary']);
            $('.account-summery-block').css('display','block');
        });
    });

    // $(document).on('click','.view-all-login-report',function() {
    // });
</script>