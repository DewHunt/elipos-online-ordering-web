<?php
    $m_order_information = new Order_information_Model();
    $m_order_details = new Order_details_Model();
    if ((isset($from_date) && !empty($from_date)) && (isset($to_date) && !empty($to_date))) {
        $latest_orders = $m_order_information->get_latest_orders(5,$from_date,$to_date);
    } else {
        $latest_orders = $m_order_information->get_latest_orders(5,null,null);
    }
?>

<div class="panel panel-default">
    <div class="panel-heading"><h2>Latest <?= count($latest_orders) ?> Accepted Orders</h2></div>
    <div class="panel-body">
        <table class="table table-bordered table-sm">
            <thead>
                <th class="text-center">Qty</th>
                <th class="text-center">Order Type</th>
                <th class="text-right">Amount</th>
            </thead>

            <tbody>
                <?php foreach ($latest_orders as $latest_order): ?>
                    <?php
                        $order_id = $latest_order->id;
                        $order_type = $latest_order->order_type;
                        $amount = get_price_text($latest_order->order_total);
                        $quantity = $m_order_details->get_total_quantity_by_order_id($order_id);
                    ?>
                    <tr>
                        <td class="text-center"><?= $quantity ?></td>
                        <td class="text-center"><?= ucfirst($order_type) ?></td>
                        <td class="text-right"><?= $amount ?></td>

                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>
        <?php if (isset($this->admin)): ?>                    
            <a href="<?=base_url($this->admin.'/all_orders')?>">View All</a>
        <?php endif ?>
    </div>
</div>