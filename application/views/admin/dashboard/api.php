
<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('admin/head',$this->data);


    $this->load->view('admin/script_page');
    ?>

</head>

<body class="nav-md footer_fixed" style="font-family: 'Lato';background: #ffffff">
<style>
    .process-loader{
        margin: auto;
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;

    }
</style>

<div class="container body">
    <div class="main_container">
        <?php

        $m_order_information=new Order_information_Model();
        $m_order_details=new Order_details_Model();

        ?>

        <!-- page content -->
                <div class="page-title">
                    <div class="title_left"></div>
                    <!-- top tiles -->
                    <div class="row tile_count">
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><center><i class="fa fa-user"></i> Total Orders</center></span>

                            <div class="count text-align-center"><?= get_total_number_of_orders(); ?></div>
                            <span class="count_bottom"><i class="green"><center><?= get_total_number_of_orders_of_last_week(); ?></i><span> From last Week</span></center></span>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><center><i class="fa fa-user"></i> Collection Orders</center></span>

                            <div class="count text-align-center"><?= get_total_number_of_orders_by_order_type('collection'); ?></div>
                            <span class="count_bottom"><center><i class="green"><i class="fa fa-sort-asc"></i><?= get_total_number_of_orders_of_last_week_by_order_type('collection') ?></i> From last Week</center></span>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><center><i class="fa fa-user"></i> Delivery Orders</center></span>

                            <div class="count text-align-center"><?= get_total_number_of_orders_by_order_type('delivery'); ?></div>
                            <span class="count_bottom"><center><i class="green"><i class="fa fa-sort-asc"></i><?= get_total_number_of_orders_of_last_week_by_order_type('delivery') ?></i> From last Week</center></span>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><center><i class="fa fa-user"></i> Collection Amount</center></span>

                            <div class="count text-align-center"><center><?= number_format(get_total_orders_amount_by_order_type('collection'), 2); ?></center></div>
                            <span class="count_bottom"><center><i class="green"><i class="fa fa-sort-asc"></i><?= number_format(get_total_orders_amount_of_last_week_by_order_type('collection'), 2); ?></i> From last Week</center></span>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><center><i class="fa fa-user"></i> Delivery Amount</center></span>

                            <div class="count text-align-center"><center><?= number_format(get_total_orders_amount_by_order_type('delivery'), 2) ?></center></div>
                            <span class="count_bottom"><center><i class="green"><i class="fa fa-sort-asc"></i><?= number_format(get_total_orders_amount_of_last_week_by_order_type('delivery'), 2); ?></i> From last Week</center></span>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><center><i class="fa fa-user"></i> Total</center></span>

                            <div class="count text-align-center"><?= number_format(get_total_order_amount(), 2) ?></div>
                            <span class="count_bottom"><center><i class="green"><i class="fa fa-sort-asc"></i><?= number_format(get_total_order_amount_of_last_week(), 2); ?></i> From last Week</center></span>
                        </div>
                    </div>
                    <!-- /top tiles -->
                    <div class="row">


                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="dashboard_graph" style="margin: 0;padding: 2px">

                                <div class="row x_title">
                                    <h3>&nbsp;&nbsp;Last 7 Days Orders
                                        <small></small>
                                    </h3>

                                </div>

                                <div class="col-md-9 col-sm-9 col-xs-12 "  >
                                    <div class="x_panel" style="min-height: 300px;">
                                        <div class="last-n-days-order-graph-block">
                                            <?=$last_n_days_order?>

                                        </div>
                                    </div>


                                    <img class="process-loader"  src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>


                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 bg-white " >
                                    <div class="x_panel" style="min-height: 300px;">
                                        <div class="top-five-products">
                                            <?php echo $top_five_product?>

                                        </div>
                                        <img class="process-loader"  src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>


                                    </div>




                                </div>

                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 2px">
                            <div class="x_panel tile fixed_height_320">
                                <div class="latest-order-block">
                                    <?=$latest_order?>


                                </div>


                                <img class="process-loader"  src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>

                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="x_panel tile fixed_height_320 overflow_hidden">

                                <div class="top-customer-block">
                                    <?php echo $top_customer;?>

                                </div>
                                <img class="process-loader"  src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>


                            </div>
                        </div>


                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="x_panel tile fixed_height_320">
                                <div class="account-summery-block">

                                    <?php echo $account_summary; ?>
                                </div>
                                <img class="process-loader"  src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>

                            </div>
                        </div>
                    </div>




                </div>
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


            $('.top-five-products').html(data['to_five_product']);
            $('.top-five-products').css('display','block');

            $('.latest-order-block').html(data['latest_order']);
            $('.latest-order-block').css('display','block');

            $('.top-customer-block').html(data['top_customer']);
            $('.top-customer-block').css('display','block');

            $('.account-summery-block').html(data['account_summary']);
            $('.account-summery-block').css('display','block');










        });

    });
</script>



</body>
</html>



