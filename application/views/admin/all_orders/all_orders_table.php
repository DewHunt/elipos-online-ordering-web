<?php if ($orders_information): ?>
    <?php
        list($total_collection,$total_delivery,$total_cash,$total_card,$total_rejected,$total_web,$total_android,$total_ios,$total_sale) = $total_information;
    ?>
    <style type="text/css">
        .view, .view-order{ cursor: pointer; }
        .text-ver-mid { vertical-align: middle !important; }
        .total-info-div { margin-top: 10px; margin-bottom: 20px; }
        .info-content { padding: 5px; }
        .info-head, .info-body { text-align: center; padding: 5px; }
        .info-head { background-color: #2a3f54; color: #fff; font-size: 12px; }
        .info-body { border: 1px solid #2a3f54; font-weight: bold; color: #000; }
        .hide { display: none !important;}
        .show { display: block !important;}
        .platform-text,.payment-method-text {
            color: #ffffff;
            font-size: 8px;
            padding: 2px 5px;
        }
        .platform-text { background: #008000; }
        .payment-method-text { background: #0000ff; }
    </style>

    <div class="web-view">
        <div class="row total-info-div">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="parent-div">
                    <div class="child-div">
                        <div class="info-head">Total Collection</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_collection,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Delivery</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_delivery,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Sale</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_sale,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Cash</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_cash,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Card</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_card,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Rejected</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_rejected,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Web</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_web,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Android</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_android,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total iOS</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_ios,2) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-view">
        <div class="row total-info-div">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="parent-div">
                    <div class="child-div">
                        <div class="info-head">Total Collection</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_collection,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Delivery</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_delivery,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Sale</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_sale,2) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row total-info-div">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="parent-div">
                    <div class="child-div">
                        <div class="info-head">Total Cash</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_cash,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Card</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_card,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Rejected</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_rejected,2) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row total-info-div">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="parent-div">
                    <div class="child-div">
                        <div class="info-head">Total Web</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_web,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total Android</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_android,2) ?></div>
                    </div>
                    <div class="child-div">
                        <div class="info-head">Total iOS</div>
                        <div class="info-body"><?= get_currency_symbol()." ".number_format($total_ios,2) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-container order-table-admin">
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive nowrap">
                <thead class="thead-default">
                    <tr>
                        <th rowspan="2" class="text-center text-ver-mid" width="40px">SN</th>
                        <th rowspan="2" class="text-center text-ver-mid" width="150px">Customer</th>
                        <th colspan="2" class="text-center text-ver-mid">Time</th>
                        <th colspan="3" class="text-center text-ver-mid">Order</th>
                        <th rowspan="2" class="text-center text-ver-mid" width="60px">Payment Method</th>
                        <th rowspan="2" class="text-center text-ver-mid" width="80px">
                            Total(<?= get_currency_symbol() ?>)
                        </th>
                        <th rowspan="2" class="text-center text-ver-mid" width="100px">Action</th>
                    </tr>
                    <tr>
                        <th width="130px" class="text-center">Order</th>
                        <th width="100px" class="text-center">Delivery</th>
                        <th class="text-center" width="70px">Type</th>
                        <th class="text-center">Note</th>
                        <th class="text-center" width="50px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count = 1;
                        $all_order_order_total = 0;
                    ?>
                    <?php foreach ($orders_information as $order): ?>
                        <?php
                            $all_order_order_total += (double) $order->order_total;
                            $customer = $this->Customer_Model->get($order->customer_id, true);

                            $customer_name = ucfirst(get_customer_full_name($customer));
                            $delivery_address = get_customer_delivery_address_with_post_code($customer);
                            if ($delivery_address) {
                                $delivery_address = "(".$delivery_address.")";
                            }
                        ?>
                        <tr>
                            <td class="text-right"><?= $count++ ?></td>
                            <td><b><?= $customer_name ?></b><br><?= $delivery_address ?></td>
                            <td style="width: 30px"><?= date("D jS \of M y H:i:s A", strtotime($order->order_time)); ?></td>
                            <td><?= ($order->delivery_time != '0000-00-00 00:00:00') ? date('h:i:s A', strtotime($order->delivery_time)) : 'ASAP'; ?></td>
                            <td class="text-center">
                                <?= (ucfirst($order->order_type)) ?>
                                <br>
                                <span class="platform-text"><?= (ucfirst($order->platform)) ?></span>
                            </td>
                            <td><?= $order->notes; ?></td>
                            <td class="text-center">
                                <?php
                                    if ($order->order_status == 'reject') {
                                        echo 'Rejected<p>('.$order->order_comments.')</p>';
                                    } else if ($order->order_status == 'accept') {
                                        echo 'Accepted';
                                    } else if ($order->order_status == 'pending') {
                                        echo 'Pending';
                                    } else if ($order->order_status == 'refund') {
                                        echo "refunded";
                                    }
                                ?>                            
                            </td>
                            <td class="text-center">
                                <?php if ($order->payment_method == 'cash'): ?>
                                    Cash
                                <?php else: ?>
                                    Card
                                    <span class="payment-method-text"><?= ucfirst($order->payment_method); ?></span>
                                <?php endif ?>
                            </td>
                            <td class="text-right"><?= number_format($order->order_total, 2) ?></td>
                            <td class="text-center">
                                <a data-id="<?= $order->id ?>" data-action="<?= base_url($this->admin."/all_orders/order_information_show_in_modal") ?>" class="btn btn-sm btn-primary view view-order">
                                    <i class=" fa fa-eye" aria-hidden="true"></i></a>
                                <a data-id="<?= $order->id ?>" data-action="<?= base_url($this->admin."/all_orders/delete") ?>" class="btn btn-danger btn-sm delete-order">
                                    <i class=" fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td colspan="8" class="text-right"><strong>Grand Total</strong></td>
                        <td class="text-right"><strong><?= number_format($all_order_order_total, 2) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <?php echo '<h6>There is No Data in Order Table</h6>'; ?>
<?php endif ?>