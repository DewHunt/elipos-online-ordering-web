<?php
    $time = date('H:m',strtotime($order_information->order_time));
    $accept_data = array('id'=>$order_information->id,'time'=>$time,'data'=>'accept','message'=>'');
    $reject_data = array('id'=>$order_information->id,'time'=>$time,'data'=>'reject','message'=>'');
    $accept_data = json_encode($accept_data);
    $reject_data = json_encode($reject_data);
?>

<style type="text/css">
    .info-div { background-color: #e6e6e6; border-radius: .2rem; }
    .h4, .h5, .h6, h4, h5, h6 { margin-top: 0px; margin-bottom: 0px }
    .tab-mr { margin: 0px 0px 0px 0px; }
    .customer-head-width { width: 125px; }
</style>

<div class="modal fade view-modal" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="text-xs-center"  style="font-size:2rem">Order Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">                        
                        <?php
                            $payment_method = $order_information->payment_method;
                            if ($payment_method != 'cash'){
                                $payment_method = 'card';
                            }
                        ?>

                        <?php if ($customer): ?>
                            <?php $name = get_customer_full_name($customer); ?>                        
                            <table class="table table-sm table-hover table-bordered info-div">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center"><h4>Customer Information</h4></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="customer-head-width">ID</th>
                                        <td><?= $customer->id ?></td>
                                    </tr>
                                    <tr>
                                        <th class="customer-head-width">Name</th>
                                        <td><?= $name ?></td>
                                    </tr>
                                    <tr>
                                        <th class="customer-head-width">Billing Address</th>
                                        <td><?= $customer->billing_address_line_1 ?></td>
                                    </tr>
                                    <tr>
                                        <th class="customer-head-width">Delivery Address</th>
                                        <td><?= $customer->delivery_address_line_1 ?></td>
                                    </tr>
                                    <tr>
                                        <th class="customer-head-width">Telephone</th>
                                        <td><?= $customer->mobile ?></td>
                                    </tr>
                                    <tr>
                                        <th class="customer-head-width">Email</th>
                                        <td><?= $customer->email ?></td>
                                    </tr>
                                    <tr>
                                        <th class="customer-head-width">Billing Postcode</th>
                                        <td><?= $customer->billing_postcode ?></td>
                                    </tr>
                                    <tr>
                                        <th class="customer-head-width">Delivery Postcode</th>
                                        <td><?= $customer->delivery_postcode ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php endif ?>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">                        
                        <table class="table table-sm table-hover table-bordered info-div">
                            <thead>
                                <tr>
                                    <th colspan="4" class="text-center"><h4>Order Information</h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Order Id</th>
                                    <td colspan="3"><?= $order_information->id ?></td>
                                </tr>
                                <tr>
                                    <th>Order Time</th>
                                    <td colspan="3"><?= date('l jS \of F Y h:i:s A', strtotime($order_information->order_time)) ?></td>
                                </tr>
                                <tr>
                                    <th>Delivery  Time</th>
                                    <td colspan="3"><?= ($order_information->delivery_time == '0000-00-00 00:00:00') ? "ASAP" : date('l jS \of F Y h:i:s A', strtotime($order_information->delivery_time)) ?></td>
                                </tr>
                                <tr>
                                    <th>Order Type</th>
                                    <td colspan="3"><?= ucfirst($order_information->order_type) ?></td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td colspan="3"><?= ucfirst($payment_method) ?></td>
                                </tr>
                                <tr>
                                    <th>Order Note</th>
                                    <td colspan="3"><?= $order_information->notes ?></td>
                                </tr>
                                <tr>
                                    <th>Reject Cause</th>
                                    <td colspan="3"><?= $order_information->order_comments ?></td>
                                </tr>
                                <tr>
                                    <th>Order Status</th>
                                    <td><?= $order_information->order_status?></td>
                                    <th>Is Pre-Order</th>
                                    <td><?=($order_information->is_pre_order)?'Yes':'No'?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-sm table-hover table-bordered info-div tab-mr">
                            <tr><th class="text-center"><h4>Order Details</h4></th></tr>
                        </table>
                        
                        <?php $this->load->view('order/order_details_table',$this->data); ?>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="modal-footer">
                <?php if ($is_show_btn == 'true'): ?>
                    <?php if ($order_information->payment_method == 'sagepay' AND $order_information->is_refunded == 0 AND $order_information->order_status == 'pending'): ?>
                        <span class="btn btn-warning btn-sagepay-refund" transaction-id='<?= $order_information->transaction_id ?>' order-information-id="<?= $order_information->id ?>" total-amount="<?= $order_information->order_total ?>">Refund</span>
                        <img id="order-status-loader" style="display: none; float: right" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                    <?php endif ?>
                    <?php if ($order_information->order_status == 'pending'): ?>
                        <span class="btn btn-success btn-accept" accept-data='<?= $accept_data ?>' order-information-id="<?= $order_information->id ?>">Accept</span>
                        <span class="btn btn-danger btn-reject">Reject</span>
                        <img id="order-status-loader" style="display: none; float: right" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                    <?php endif ?>
                    <?php if ($is_order_in_new_order && $order_information->order_status == 'pending'): ?>
                        <button type="button" id="mark-as-new-order" data-id="<?= $order_information->id ?>" class="btn btn-primary">Mark As New Order</button>
                        <img id="mark-as-new-order-loader" style="display: none; float: right" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                    <?php endif ?>
                <?php endif ?>
                <button type="button" id="btn-modal-close" style="float: right" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade reject-msg-modal" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group text-center" style="font-size: 20px;">
                    <label class="text-center">Write Reason For Reject</label>
                    <textarea rows="3" class="form-control reason_for_reject" name="reason_for_reject"></textarea>
                </div>
                <button type="button" class="btn btn-success reject-action" reject-data='<?= $reject_data ?>' order-information-id="<?= $order_information->id ?>">Okay</button>
                <button type="button" id="btn-modal-close" style="float: right" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>