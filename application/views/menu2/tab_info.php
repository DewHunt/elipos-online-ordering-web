<?php
    $payment_method = get_payment_method();
    $dine_in = get_dine_in();
    if ($payment_method == '' && $dine_in != '') {
        $payment_method == $dine_in;
    }
    $payment_method_text = '';

    if ($payment_method == 'cash' || $payment_method == 'both') {
        $payment_method_text = 'Cash On Delivery';
    } elseif ($payment_method == 'online') {
        $payment_method_text = 'Card Only';
    }
    $today_shop_timing = get_today_shop_timing(date('w'));
    if ($today_shop_timing) {
        $open_time = get_formatted_time($today_shop_timing->open_time,'h:i A');
        $close_time = get_formatted_time($today_shop_timing->close_time,'h:i A');
    }
?>

<style>
.tab-table .table th, .tab-table .table td {
    padding: 0.75rem;
}
</style>

<div class="card" style="border-radius: 0">
    <div class="card-body">
        <div class="table-responsive tab-table">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="2">
                            <h4 class="text-left">Restaurant Overview</h4>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td width="25%">Address</td>
                        <td width="75%"><?= get_company_address() ?></td>
                    </tr>

                    <tr>
                        <td width="25%">Cuisines :</td>
                        <td width="75%"><?= get_company_food_type() ?></td>
                    </tr>

                    <tr>
                        <td width="25%">Pickup Time</td>
                        <td width="75%"><?= get_company_pickup_time() ?></td>
                    </tr>

                    <tr>
                        <td width="25%">Payment Method</td>
                        <td width="75%"><?= $payment_method_text ?></td>
                    </tr>
                    <?php if (!empty($today_shop_timing)): ?>
                        <tr>
                            <td colspan="2" class="text-center">
                                <?php if (is_shop_weekend_off()): ?>
                                    <span style="color: red; font-weight: bold;">We Are Closed</span>
                                <?php else: ?>
                                    Opening Hour <?= $open_time ?> - <?= $close_time ?>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
