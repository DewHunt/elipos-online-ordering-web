<div class="panel panel-default">
    <div class="panel-heading"><h4><?= $title ?></h4></div>

    <div class="panel-body">
        <div class="error">
            <?php
                echo validation_errors();
                $payment_gateways = get_payment_gateways();
            ?>
        </div>
        <form id="payment_settings_form" method="post" action="<?= base_url($this->admin . '/settings/payment_settings_insert') ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= get_payment_settings_id() ?>">
            <input type="hidden" name="name" class="form-control" id="name" value="payment_settings">

            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <label for="payment-gateway">Payment gateway</label>
                    <div class="form-group">
                        <label for="payment_gateway-paypal" class="checkbox-inline">
                            <input type="checkbox" name="payment_gateway[]" id="payment_gateway-paypal" value="paypal" <?=(!empty($payment_gateways)) ? in_array('paypal', $payment_gateways) ? 'checked' : '':'' ?>> PayPal
                        </label>

                        <label for="payment_gateway-stripe" class="checkbox-inline">
                            <input type="checkbox" name="payment_gateway[]" id="payment_gateway-stripe" value="stripe" <?= (!empty($payment_gateways)) ? in_array('stripe', $payment_gateways) ? 'checked' : '':'' ?>> Stripe
                        </label>

                        <label for="payment_gateway-nochex" class="checkbox-inline">
                            <input type="checkbox" name="payment_gateway[]" id="payment_gateway-nochex" value="nochex" <?= (!empty($payment_gateways)) ? in_array('nochex', $payment_gateways) ? 'checked' : '':'' ?>> Nochex
                        </label>

                        <!-- <label for="payment_gateway-pay360" class="checkbox-inline">
                            <input type="checkbox" name="payment_gateway[]" id="payment_gateway-pay360" value="pay360" <?= (!empty($payment_gateways)) ? in_array('pay360', $payment_gateways) ? 'checked' : '':'' ?>> Pay360
                        </label> -->

                        <!-- <label for="payment_gateway-barclays" class="checkbox-inline">
                            <input type="checkbox" name="payment_gateway[]" id="payment_gateway-barclays" value="barclays" <?= in_array('barclays', $payment_gateways) ? 'checked' : '' ?> class="list"> Barclays
                        </label> -->

                        <!-- <label for="payment_gateway-worldpay" class="checkbox-inline">
                            <input type="checkbox" name="payment_gateway[]" id="payment_gateway-worldpay" value="worldpay" <?= (!empty($payment_gateways)) ? in_array('worldpay', $payment_gateways) ? 'checked' : '' : '' ?> class="list">Worldpay
                        </label> -->

                        <label for="payment_gateway-sagepay" class="checkbox-inline">
                            <input type="checkbox" name="payment_gateway[]" id="payment_gateway-sagepay" value="sagepay" <?= (!empty($payment_gateways)) ? in_array('sagepay', $payment_gateways) ? 'checked' : '' : '' ?> class="list">Sagepay
                        </label>

                        <label for="payment_gateway-cardstream" class="checkbox-inline">
                            <input type="checkbox" name="payment_gateway[]" id="payment_gateway-cardstream" value="cardstream" <?= (!empty($payment_gateways)) ? in_array('cardstream', $payment_gateways) ? 'checked' : '' : '' ?> class="list">Cardstream
                        </label>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <label for="payment-mode">Payment Mode</label>
                    <div class="form-group">
                        <!-- <label class="radio-inline">
                            <input class="form-check-inline" type="radio" name="payment_mode" <?= get_payment_mode() == 0 ? 'checked' : '' ?> id="payment_mode-1" value="0"> Test mode
                        </label> -->

                        <label class="radio-inline">
                            <input checked="checked" class="form-check-input" type="radio" name="payment_mode" <?= get_payment_mode() == 1 ? 'checked' : '' ?> id="payment_mode-2" value="1"> Live mode
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="order-type">Order Type</label>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input class="form-check-inline" type="radio" name="order_type" id="delivery_options-0" value="delivery_and_collection" <?= (get_order_type() == 'delivery_and_collection') ? 'checked' : '' ?>>Delivery And Collection
                        </label>
                        
                        <label class="radio-inline">
                            <input class="form-check-inline" type="radio" name="order_type" id="delivery_options-0" value="delivery_collection_and_dinein" <?= (get_order_type() == 'delivery_collection_and_dinein') ? 'checked' : '' ?>>Delivery, Collection And Dine-In
                        </label>

                        <label class="radio-inline">
                            <input class="form-check-inline" type="radio" name="order_type" id="delivery_options-1" value="dinein_and_collection" <?= (get_order_type() == 'dinein_and_collection') ? 'checked' : '' ?>>Dine-In And Collection
                        </label>

                        <label class="radio-inline">
                            <input class="form-check-inline" type="radio" name="order_type" id="delivery_options-2" value="delivery" <?= (get_order_type() == 'delivery') ? 'checked' : '' ?>> Delivery Only
                        </label>

                        <label class="radio-inline">
                            <input class="form-check-inline" type="radio" name="order_type" id="delivery_options-3" value="collection" <?= (get_order_type() == 'collection') ? 'checked' : '' ?>> Collection Only
                        </label>

                        <label class="radio-inline">
                            <input class="form-check-inline" type="radio" name="order_type" id="delivery_options-4" value="dine_in" <?= (get_order_type() == 'dine_in') ? 'checked' : '' ?>> Dine-In Only
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="payment-method">Payment Method</label>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input class="form-check-inline" type="radio" name="payment_method" id="payment_method-BOTH" value="both" <?= get_payment_method() == 'both' ? 'checked' : '' ?>> Cash and Online
                        </label>

                        <label class="radio-inline">
                            <input class="form-check-inline" type="radio" name="payment_method" id="payment_method-CASH" value="cash" <?= get_payment_method() == 'cash' ? 'checked' : '' ?>> Cash only
                        </label>

                        <label class="radio-inline">
                            <input class="form-check-inline" type="radio" name="payment_method" id="payment_method-ONLINE" value="online" <?= get_payment_method() == 'online' ? 'checked' : '' ?>> Online only
                        </label>
                        &nbsp;&nbsp;&nbsp;
                        <label class="checkbox-inline">
                            <input type="hidden" name="dine_in" id="dine_in" value="no_cash">
                            <input type="checkbox" name="dine_in" id="dine_in" value="cash" <?= get_dine_in() == 'cash' ? 'checked' : '' ?>> Cash Payment Available On Dine-In
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="payment-method">Reservation Payment</label>
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="hidden" name="reservation" value="no">
                            <input type="checkbox" class="reservation" name="reservation" value="yes" <?= get_reservation() == 'yes' ? 'checked' : '' ?>> Payment Available
                        </label>
                        &nbsp;&nbsp; 
                        <input type="number" step="1" min="0" name="reservation_amount" class="reservation_amount" placeholder="Reservation Amount" value="<?= get_reservation_amount() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="payment-method">Discount Settings</label>
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="hidden" name="tips_for_card" id="tips_for_card" value="no">
                            <input type="checkbox" name="tips_for_card" id="tips_for_card" value="yes" <?= get_tips_for_card() == 'yes' ? 'checked' : '' ?>> Tips For Card
                        </label>
                        &nbsp;&nbsp;&nbsp;
                        <label class="checkbox-inline">
                            <input type="hidden" name="tips_for_cash" id="tips_for_cash" value="no">
                            <input type="checkbox" name="tips_for_cash" id="tips_for_cash" value="yes" <?= get_tips_for_cash() == 'yes' ? 'checked' : '' ?>> Tips For Cash
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="credit-card-surcharge">Credit Card Surcharge (£):</label>
                        <input type="number" min="0" step=".01" name="surcharge" class="form-control" id="surcharge" value="<?= get_surcharge() ?>">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="display: none;">
                    <div class="form-group">
                        <label for="loyalty-point-status">Loyalty Point Status</label>
                        <select name="lp_status" id="lp_status" class="form-control">
                            <option value="0" label="No" <?= get_loyalty_point_status() ? '' : 'selected' ?>>No</option>
                            <option value="1" label="Yes" <?= get_loyalty_point_status() ? 'selected' : '' ?>>Yes</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="display: none;">
                    <div class="form-group">
                        <label for="loyalty-point-earn-rate">Loyalty Point Earn Rate</label>
                        <input type="number" min="0" name="lp_earn_rate" class="form-control" id="lp_earn_rate" value="<?= get_loyalty_point_earn_rate() ?>">
                        <p class="help-block">Amount that will be earned by customer(%)</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button type="submit" class="btn btn-success">Save Change</button>
                </div>
            </div>
        </form>
    </div>
</div>