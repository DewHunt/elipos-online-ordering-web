<?php
    $d2 = date('Y-m-d', strtotime('-30 days'));
    $today = date("Y-m-d",strtotime('2 day'));
    $begin = new DateTime($d2);
    $end = new DateTime($today);

    if (isset($from_date) && !empty($from_date)) {
        $begin = new DateTime($from_date);
    }

    if (isset($to_date) && !empty($to_date)) {
        $to_date = date($to_date,strtotime('2 day'));
        $end = new DateTime($to_date);
    }

    $m_order_information = new Order_information_Model();
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);
    $latest_30_days_orders_data_arrays = array();

    foreach($period as $dt) {
        $date = $dt->format("Y-m-d");
        $order_details = $m_order_information->get_order_by_date($date);
        // $order_date=$order_details->order_date;
        // var_dump($order_details);

        $amount = (!empty($order_details))?$order_details->total_amount:0;
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
        $data['years'] = date('Y', strtotime($date));
        $data['month'] = date('m', strtotime($date));
        $data['day'] = date('d', strtotime($date));
        $data['amount'] = $amount;
        $order_details = null;
        array_push($latest_30_days_orders_data_arrays,$data);
    }
    // echo '<pre>';
    // print_r(json_decode(json_encode($latest_30_days_orders_data_arrays),true));
    // echo '</pre>';
?>


<div class="panel panel-default">
    <div class="panel-heading"><h3>Last 30 Days Orders</h3></div>
    <div class="panel-body"><div id="last-30-days-order-chart" class="demo-placeholder"></div></div>
</div>

<script type="text/javascript">
    last_30_days_orders_chart();
    function last_30_days_orders_chart(){
        var settings = {
            series: {
                lines: {
                    show: false,
                    fill: true
                },
                splines: {
                    show: true,
                    tension: 0.4,
                    lineWidth: 1,
                    fill: 0.4
                },
                points: {
                    radius: 0,
                    show: true
                },
                shadowSize: 0
            },
            grid: {
                verticalLines: true,
                hoverable: true,
                clickable: true,
                tickColor: "#d5d5d5",
                borderWidth: 1,
                color: '#fff'
            },
            colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
            xaxis: {
                tickColor: "rgba(51, 51, 51, 0.06)",
                mode: "time",
                tickSize: [1, "day"],
                //tickLength: 10,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10
            },
            yaxis: {
                min:0,
                ticks: 10,
                tickColor: "rgba(51, 51, 51, 0.06)",
            },
            tooltip: false
        };

        var arr_data = <?=json_encode($latest_30_days_orders_data_arrays)?>;

        var new_arr_data = [];
        $.each( arr_data, function( key, value ) {
            data = [];
            data.push(gd(value.years,value.month,value.day));
            data.push(value.amount);
            console.log(value.amount);
            new_arr_data.push(data);
        });

        if ($("#last-30-days-order-chart").length) {
            $.plot( $("#last-30-days-order-chart"), [new_arr_data],  settings );
        }
    }
</script>