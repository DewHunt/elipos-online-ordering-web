<?php
    $m_order_information = new Order_information_Model();
    $m_customer = new Customer_Model();
    if ((isset($from_date) && !empty($from_date)) && (isset($to_date) && !empty($to_date))) {
        $top_customers_order_details = $m_order_information->get_top_customer_by_order_totals(5,$from_date,$to_date);
        $total_order_amount = $m_order_information->get_total_order_amount($from_date,$to_date);
    } else {
        $top_customers_order_details = $m_order_information->get_top_customer_by_order_totals();
        $total_order_amount = $m_order_information->get_total_order_amount();
    }

    $total_amount = $total_order_amount->total_amount;
    $total_top_customer = count($top_customers_order_details);
    $color_array[0] = 'blue';
    $color_array[1] = 'green';
    $color_array[2] = 'purple';
    $color_array[3] = 'aero';
    $color_array[4] = 'yellow';
    $color_array[5] = 'red';

    $total_customer_percentage = 0;
    $color_index = 5 - $total_top_customer;
    $order_percentage_array = array();
    $customer_color_percentage = array();
    $top_order_customer_name_array = array();
?>

<div class="panel panel-default">
    <div class="panel-heading"><h2>Top <?=$total_top_customer?> Customers</h2></div>

    <div class="panel-body">
        <table class="" style="width:100%">
            <tr>
                <th style="width:37%;">
                    <p>Top <?= $total_top_customer ?></p>
                </th>
                <th>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 text-center"><p class="">Customer</p></div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-center"><p class="">Total(%)</p></div>
                </th>
            </tr>
            <tr>
                <td><canvas class="canvasDoughnutTopCustomer" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas></td>
                <td>
                    <table class="tile_info" style="width: 100%;">
                        <?php foreach ($top_customers_order_details as $order_detail): ?>
                            <?php
                                $customer = $m_customer->get($order_detail->customer_id);
                            ?>
                            <?php if ($customer): ?>                                
                                <?php
                                    $customer_percentage = 0;
                                    if ($total_amount > 0) {
                                        $customer_percentage = round(100 * $order_detail->total_amount / $total_amount,2);
                                    }
                                    $total_customer_percentage += $customer_percentage;
                                    array_push($order_percentage_array,$customer_percentage);
                                    array_push($top_order_customer_name_array,$customer->first_name);
                                ?>
                                <tr>
                                    <td>
                                        <p><i class="fa fa-square <?= $color_array[$color_index] ?>"></i><?= $customer->first_name ?> </p>
                                    </td>
                                    <td style="text-align:right"><?= $customer_percentage ?>%</td>
                                </tr>
                            <?php endif ?>
                            <?php
                                $color_index++;
                            ?>
                        <?php endforeach ?>
                        <?php
                            $total_others_percentage = 100 - $total_customer_percentage;
                            array_push($order_percentage_array,$total_others_percentage);
                            array_push($top_order_customer_name_array,'Others');
                        ?>

                        <tr>
                            <td><p><i class="fa fa-square red "></i>Others</p></td>
                            <td style="text-align:right"><?= round($total_others_percentage,2) ?>%</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>    
    </div>
</div>




<script type="text/javascript">
    var dataCustomerOrderPercentage = <?= json_encode($order_percentage_array) ?>;
    var dataCustomerName = <?= json_encode($top_order_customer_name_array) ?>;
    init_chart_doughnut_top_customer(dataCustomerOrderPercentage,dataCustomerName);

    function init_chart_doughnut_top_customer(dataCustomerOrderPercentage,dataCustomerName){

        if( typeof (Chart) === 'undefined'){ return; }

        console.log('init_chart_doughnut');
        if ($('.canvasDoughnutTopCustomer').length){
            var chart_doughnut_settings = {
                type: 'doughnut',
                tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                data: {
                    labels: dataCustomerName,
                    datasets: [{
                        data: dataCustomerOrderPercentage,
                        // backgroundColor: ["#BDC3C7","#9B59B6","#E74C3C","#26B99A","#FFFF00","#3498DB"],
                        backgroundColor: ["blue","green","purple","aero","yellow","red"],
                        hoverBackgroundColor: ["#CFD4D8","#B370CF","#E95E4F","#36CAAB",'#FFF000',"#49A9EA"]
                    }]
                },
                options: {
                    legend: false,
                    responsive: false
                }
            }

            $('.canvasDoughnutTopCustomer').each(function(){
                var chart_element = $(this);
                console.log("Chart Element = ",chart_element);
                var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);
            });
        }
    }
</script>