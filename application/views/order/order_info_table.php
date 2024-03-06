<?php
	// echo "<pre>"; print_r($order_information); exit();
	$order_will_be = '';
	$delivery_time = $order_information->delivery_time;
	$payment_method = $order_information->payment_method;
	$table_number = null;

	if ($order_information->order_type == 'collection') {
	    $order_will_be = 'Collected';
	} elseif ($order_information->order_type == 'delivery'){
	    $order_will_be = 'Delivered';
	} else {
	    $order_will_be = 'Dine-In';
	}

	if ($table_info) {
		$table_number = $table_info->table_number;
	}

	if($payment_method != 'cash'){
	    $payment_method = 'card';
	}
	$delivery_time = ((strtotime($delivery_time)>0))?date("d-m-Y h:i:s A", strtotime($order_information->delivery_time)):'ASAP';
	$total = $order_information->order_total;
?>

<table class="" style="width: 100%">
    <tr>
    	<td colspan="2"><h4 style="margin: 0">Order Reference: <strong><?= $order_information->id ?></strong></h4></td>
    </tr>

    <tr>
    	<td style="width: 200px">Order date</td>
    	<td><?= get_formatted_time($order_information->order_time,'d-m-Y h:i:s A') ?></td>
    </tr>

    <tr>
    	<td style="width: 200px">Delivery time</td>
    	<td><?= $delivery_time ?></td>
    </tr>

    <tr>
    	<td style="width: 200px">Total</td>
    	<td><?= get_price_text(number_format($total,2)) ?></td>
    </tr>

    <tr style="background-color: green; color: white">
    	<td style="width: 200px">&nbsp;&nbsp;&nbsp;Order will be</td>
    	<td><strong>&nbsp;&nbsp;&nbsp;<?= $order_will_be ?></strong></td>
    </tr>

    <?php if ($order_will_be == 'Dine-In'): ?>
    	<tr style="background-color: green; color: white">
    		<td style="width: 200px">&nbsp;&nbsp;&nbsp;Table No</td>
    		<td><strong>&nbsp;&nbsp;&nbsp;<?= $table_number ?></strong></td>
    	</tr>    	
    <?php endif ?>

    <tr>
    	<td style="width: 200px">Payment method</td>
    	<td><?= ucfirst($payment_method) ?></td>
    </tr>
</table>