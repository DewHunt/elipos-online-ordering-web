<style>
    label { color: #000; margin-bottom: 0px; }
    .cust-head { font-weight: 700; color: #73879c; }
    .view, .view-order{ cursor: pointer; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">        
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4>Customer Order List</h4></div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                    <a class="btn btn-info btn-lg right-side-view" href="<?= base_url('admin/customer') ?>"><i class="fa fa-reply" aria-hidden="true"></i>&nbsp;All Customer</a>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <?php if ($customer): ?>
            <?php $name = get_customer_full_name($customer); ?>
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <tr class="text-center">
                        <td>
                            <div class="cust-head">Customer ID</div>
                            <label><?= $customer->id ?></label>
                        </td>
                        <td>
                            <div class="cust-head">Customer Name</div>
                            <label><?= $name ?></label>
                        </td>
                        <td>
                            <div class="cust-head">Total Orders</div>
                            <label><?= count($orders_information) ?></label>                            
                        </td>
                        <td>
                            <div class="cust-head">Grand Total</div>
                            <label><?= number_format($grand_total,2) ?></label>                            
                        </td>
                    </tr>
                </table>
            </div>

            <?php if ($orders_information): ?>
                <div class="form-container">
                    <table class="table table-striped table-bordered dt-responsive list-dt" cellspacing="0" width="100%">
                        <thead class="thead-default">
                            <tr>
                                <th>SN</th>
                                <th>Customer</th>
                                <th>Order Time</th>
                                <th>Delivery Time</th>
                                <th>Order Type</th>
                                <th>Payment Method</th>
                                <th>Order Note</th>
                                <th>Reject Causes</th>
                                <th>Order Status</th>
                                <th>Total(<?= get_currency_symbol() ?>)</th>
                                <th width="60px">Action</th>
                            </tr>
                        </thead>
                        <?php $count = 1; ?>
                        <tbody>
                            <?php foreach ($orders_information as $order): ?>
                                <?php
                                    $payment_method = $order->payment_method;
                                    if ($payment_method != 'cash') {
                                        $payment_method = 'card';
                                    }
                                    $order_time = $order->order_time ? date('d M Y', strtotime($order->order_time)).'<br>'.date('h:i:s A', strtotime($order->order_time)) : '';
                                    $delivery_time = $order->delivery_time ? date('d M Y', strtotime($order->delivery_time)).'<br>'.date('h:i:s A', strtotime($order->delivery_time)) : '';

                                    $customer = $this->Customer_Model->get($order->customer_id, true);
                                    $customer_name = ucfirst(get_customer_full_name($customer));
                                    $delivery_address = get_customer_delivery_address_with_post_code($customer);
                                ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><b><?= $customer_name ?></b><?= $delivery_address ?></td>
                                    <td><?= $order_time ?></td>
                                    <td><?= $delivery_time ?></td>
                                    <td><?= (ucfirst($order->order_type)) ?></td>
                                    <td><?= ucfirst($payment_method); ?></td>
                                    <td><?= $order->notes; ?></td>
                                    <td><?= $order->order_comments; ?></td>
                                    <td>
                                        <?php
                                            if ($order->order_status == 'reject') {
                                                echo 'Rejected';
                                            } else if ($order->order_status == 'accept') {
                                                echo 'Accepted';
                                            } else if ($order->order_status == 'pending') {
                                                echo 'Pending';
                                            };
                                        ?>
                                    </td>
                                    <td class="text-right"><?= number_format($order->order_total, 2) ?></td>
                                    <td >
                                        <a data-id="<?= $order->id ?>" data-action="<?= base_url($this->admin . "/all_orders/order_information_show_in_modal") ?>" class="btn btn-sm btn-primary view view-order">
                                            <i class=" fa fa-eye" aria-hidden="true"></i></a>
                                        <a data-id="<?= $order->id ?>" data-action="<?= base_url($this->admin . "/all_orders/delete") ?>" class="btn btn-danger btn-sm delete-order">
                                            <i class=" fa fa-times" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <?php echo '<h6>There is No Data in Order Table</h6>'; ?>
            <?php endif ?>
        <?php else: ?>
            <div class="alert alert-info"><strong>No such customer is found</strong></div>              
        <?php endif ?>
    </div>
</div>

<div class="view-modal-block"></div>