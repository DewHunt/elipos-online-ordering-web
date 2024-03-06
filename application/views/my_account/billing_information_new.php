<style>
    .process-order-loader { margin-top: -8px; display: none; }
    .overlay-content img { width: 100px; height: 100px; }
    iframe { min-height: auto; }    
    .sr-root {
        display: flex;
        flex-direction: row;
        width: 100%;
        max-width: 980px;
        padding: 48px;
        align-content: center;
        justify-content: center;
        height: auto;
        min-height: 100vh;
        margin: 0 auto;
    }
    .sr-input:focus, input[type="text"]:focus, button:focus, .focused {
        box-shadow: 0 0 0 1px rgba(50, 151, 211, 0.3), 0 1px 1px 0 rgba(0, 0, 0, 0.07), 0 0 0 4px rgba(50, 151, 211, 0.3);
        outline: none;
        z-index: 9;
    }
    .sr-input::placeholder, input[type="text"]::placeholder { color: var(--gray-light); }
    .content{ position: relative; }
    .overlay {
        position: absolute;
        left: 0; top: 0; right: 0; bottom: 0;z-index: 2;
        background-color: rgba(255,255,255,0.8);
    }
    .overlay-content {
        position: absolute;
        transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        top: 50%;
        left: 0;
        right: 0;
        text-align: center;
        color: #555;
    }
    /* the container must be positioned relative: */
    .autocomplete { position: relative; display: inline-block; }
    input { border: 1px solid transparent; background-color: #f1f1f1; padding: 10px; font-size: 16px; }
    input[type=text] { background-color: #f1f1f1; width: 100%; }
    input[type=submit] { background-color: DodgerBlue; color: #fff; cursor: pointer; }
    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }
    .autocomplete-items div { padding: 10px; cursor: pointer; background-color: #fff;  border-bottom: 1px solid #d4d4d4; }
    /* when hovering an item: */
    .autocomplete-items div:hover { background-color: #e9e9e9; }
    /* when navigating through the items using the arrow keys: */
    .autocomplete-active { background-color: DodgerBlue !important;  color: #ffffff; }
    .btn-processpayment { padding: 0px; width: 100%; }
    .btn-col-pad { padding: 2px 3px 2px 3px; }
    .btn-row-mar { margin: 0px 0px 0px 0px; }
    .payment-label { font-weight: bold; font-size: 20px; line-height: 22px; }
    /* Update Part Start */
    .display-show { display: block; }
    .display-none { display: none; }
    .error-style { color: red; font-weight: bold; text-align: center; margin-top: 6px; }
    /* Update Part End */
</style>

<script src="<?= base_url('assets/jquery/additional-methods.min.js') ?>"></script>

<?php
    $login_type = $this->session->userdata('login_type');
    $is_loggedIn = $this->session->userdata('is_loggedIn');
    $acc_dill_display = 'block';
    if ($login_type == 'guest' && $is_loggedIn == true) {
        $acc_dill_display = 'none';
    }
?>

<div id="content-wrap">
    <div id="content-block">
        <div class="content-cartspan">
            <div class="card" style="border-radius: 0;" id="scolling-content-cart">
                <div class="cart-title">My Order</div>
                <div class="card-body cart-body">
                    <div class="product-cart-block"><?= $product_cart ?></div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12 no-padding">
            <div class="card content " style="padding: .5rem">
                <div class="overlay" style="display: none">
                    <div class="overlay-content">
                        <img src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="Loading..."/>
                    </div>
                </div>

                <!-- Update Part Start -->
                <?php
                    $flash_messages = get_flash_message();
                    $alert_class = "display-show";
                    if (empty($flash_messages)) {
                        $alert_class = 'display-none';
                    }
                ?>

                <div class="alert alert-danger error-msg <?= $alert_class ?>" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h6 class="text-xs-center error-msg-text" style="text-align: center"><?= $flash_messages ?></h6>
                </div>
                <!-- Update Part End -->

                <form action="<?= base_url('order/order_process') ?>" method="post" name="order_process_form" id="order_process_form">
                    <?php if (!empty($this->session->flashdata('email_error_meaage'))) { ?>
                        <div class="error"><?php echo $this->session->flashdata('email_error_meaage'); ?></div>
                    <?php } ?>

                    <?php if (!empty($this->session->flashdata('first_name_error_message'))) { ?>
                        <div class="error"><?php echo $this->session->flashdata('first_name_error_message'); ?></div>
                    <?php } ?>

                    <?php if (!empty($this->session->flashdata('mobile_error_meaage'))) { ?>
                        <div class="error"><?php echo $this->session->flashdata('mobile_error_meaage'); ?></div>
                    <?php } ?>

                    <input type="hidden" name="id" id="id" value="<?= $this->session->userdata('customer_id'); ?>">
                    <input type="hidden" id="as_new_add" name="as_new_add" value="0">
                    <div class="row">
                        <div class="col-lg-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div style="display: <?= $acc_dill_display ?>;">
                                <h4 class="color_green"><strong>ACCOUNT AND BILLING DETAILS</strong></h4>
                                <div class="form-group">
                                    <label>First Name<span class="error">*</span></label>
                                    <input type="text" id="first_name" name="first_name" class="input1" value="<?= !empty($customer) ? $customer->first_name : '' ?>">
                                </div>

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" id="last_name" name="last_name" class="input1" value="<?= !empty($customer) ? $customer->last_name : '' ?>">
                                </div>

                                <div class="form-group">
                                    <label>Email<span class="error">*</span></label>
                                    <input type="email" class="input1" id="email" name="email" value="<?= !empty($customer) ? $customer->email : '' ?>">
                                </div>

                                <div class="form-group">
                                    <label>Mobile<span class="error">*</span></label>
                                    <input type="text" class="input1" id="mobile" name="mobile" value="<?= !empty($customer) ? $customer->mobile : '' ?>">
                                </div>
                            </div>

                            <h4 class="color_green"><strong>PAYMENT METHOD</strong></h4>
                            <label>Please select the preferred payment method to use on this order.</label>

                            <?php
                                $payment_method = $this->session->userdata('payment_method');
                                $payment_gateways = get_payment_gateways();
                                $dine_in_gateways = get_dine_in();
                                $order_type_session = $this->session->userdata('order_type_session');
                                $cash_status = true;
                                $this->session->unset_userdata('payment_method');

                                if ($order_type_session == 'dine_in' && $dine_in_gateways == 'no_cash') {
                                    $cash_status = false;
                                }
                            ?>

                            <div class="form-group">
                                <div class="payment-method-block">
                                    <?php if ($this->payment_method == 'both'): ?>
                                        <?php if ($cash_status === true): ?>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="payment_method" id="cash" class="custom-control-input get_tips" value="cash" checked>
                                                <label class="custom-control-label payment-label" for="cash">Cash</label>
                                            </div>
                                            <div class="utp-details-input-fields"></div>
                                        <?php endif ?>

                                        <?php
                                            if (!empty($payment_gateways)) {
                                                if(in_array('paypal',$payment_gateways)){
                                                    $this->load->view('my_account/paypal',$this->data);
                                                }
                                                if(in_array('nochex',$payment_gateways)){
                                                    $this->load->view('my_account/nochex',$this->data);
                                                }
                                                if(in_array('stripe',$payment_gateways)){
                                                    $this->load->view('my_account/stripe',$this->data);
                                                }
                                                if(in_array('pay360',$payment_gateways)){
                                                    $this->load->view('my_account/pay360',$this->data);
                                                }
                                                if(in_array('worldpay',$payment_gateways)){
                                                    $this->load->view('my_account/worldpay',$this->data);
                                                }
                                                // Update Part Start
                                                if(in_array('sagepay',$payment_gateways)){
                                                    $this->load->view('my_account/sagepay',$this->data);
                                                }
                                                if(in_array('cardstream',$payment_gateways)){
                                                    $this->load->view('my_account/cardstream',$this->data);
                                                }
                                                // Update Part End
                                            }
                                        ?>
                                    <?php elseif ($this->payment_method == 'online'): ?>
                                        <?php
                                            if (!empty($payment_gateways)) {
                                                if (in_array('paypal',$payment_gateways)) {
                                                    $this->load->view('my_account/paypal',$this->data);
                                                }
                                                if (in_array('nochex',$payment_gateways)) {
                                                    $this->load->view('my_account/nochex',$this->data);
                                                }
                                                if (in_array('stripe',$payment_gateways)) {
                                                    $this->load->view('my_account/stripe',$this->data);
                                                }
                                                if (in_array('pay360',$payment_gateways)) {
                                                    $this->load->view('my_account/pay360',$this->data);
                                                }
                                                if (in_array('worldpay',$payment_gateways)) {
                                                    $this->load->view('my_account/worldpay',$this->data);
                                                }
                                                // Update Part Start
                                                if(in_array('sagepay',$payment_gateways)){
                                                    $this->load->view('my_account/sagepay',$this->data);
                                                }
                                                if(in_array('cardstream',$payment_gateways)){
                                                    $this->load->view('my_account/cardstream',$this->data);
                                                }
                                                // Update Part End
                                            }
                                        ?>
                                    <?php else: ?>
                                        <?php if ($cash_status === true): ?>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="payment_method" id="cash" class="custom-control-input get_tips" value="cash" checked>
                                                <label class="custom-control-label payment-label" for="cash">Cash</label>
                                            </div>
                                        <?php endif ?>
                                    <?php endif ?>
                                </div>
                            </div>

                            <div class="billing-address-block" style="display: none">
                                <div class="form-group">
                                    <label>Billing Address<span class="error">*</span></label>
                                    <textarea class="input1" name="billing_address_line_1" id="billing_address_line_1" rows="4" placeholder="Billing Address"><?= !empty($customer) ? $customer->billing_address_line_1 : '' ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Billing Postcode</label>
                                    <input type="text" class="input1" id="billing_postcode" id="billing_postcode" name="billing_postcode" value="<?= !empty($customer) ? $customer->billing_postcode : '' ?>">
                                </div>

                                <div class="form-group">
                                    <label> City</label>
                                    <input type="text" class="input1" id="billing_city" name="billing_city" value="<?= !empty($customer) ? $customer->billing_city : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <?php
                                $is_pre_order = is_pre_order();
                                $this->data['is_pre_order'] = $is_pre_order;
                                $table_number = '';
                                $session_dine_in_table_number_id = $this->session->userdata('dine_in_table_number_id');
                                if ($session_dine_in_table_number_id) {
                                    $table_number = '('.$this->session->userdata('dine_in_table_number').')';
                                }
                            ?>
                            
                            <div class="delivery-collection-time">
                                <?php $this->load->view('my_account/delivery_collection_time',$this->data); ?>
                            </div>

                            <div class="form-group">
                                <div class="order-type-block form-group">
                                    <h4 class="color_green"><strong>ORDER TYPE</strong></h4>
                                    <label>Please select the preferred order type to use on this order.</label>

                                    <?php if ($this->order_type == 'delivery_collection_and_dinein'): ?>
                                        <?php if ($order_type_session == 'dine_in'): ?>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="dinein_type" class="order_type custom-control-input" name="order_type" data-action="<?= base_url('menu/get_order_type_delivery_charge') ?>" value="dine_in"<?= !empty($order_type_session == 'dine_in') ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="dinein_type">Dine-In&nbsp;<?= $table_number ?></label>
                                            </div>
                                        <?php else: ?>                                            
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="c_type" class="order_type custom-control-input" name="order_type" data-action="<?= base_url('menu/get_order_type_delivery_charge') ?>" value="collection" <?= !empty($order_type_session == 'collection') ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="c_type">Collection</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="d_type" class="order_type custom-control-input" name="order_type" data-action="<?= base_url('menu/get_order_type_delivery_charge') ?>" value="delivery"<?= !empty($order_type_session == 'delivery') ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="d_type">Delivery</label>
                                            </div>
                                        <?php endif ?>
                                    <?php elseif ($this->order_type == 'delivery_and_collection'): ?>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="c_type" class="order_type custom-control-input" name="order_type" data-action="<?= base_url('menu/get_order_type_delivery_charge') ?>" value="collection" <?= !empty($order_type_session == 'collection') ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="c_type">Collection</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="d_type" class="order_type custom-control-input" name="order_type" data-action="<?= base_url('menu/get_order_type_delivery_charge') ?>" value="delivery"<?= !empty($order_type_session == 'delivery') ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="d_type">Delivery</label>
                                        </div>
                                    <?php elseif ($this->order_type == 'dinein_and_collection'): ?>
                                        <?php if ($order_type_session == 'dine_in'): ?>                                            
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="dinein_type" class="order_type custom-control-input" name="order_type" data-action="<?= base_url('menu/get_order_type_delivery_charge') ?>" value="dine_in"<?= !empty($order_type_session == 'dine_in') ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="dinein_type">Dine-In&nbsp;<?= $table_number ?></label>
                                            </div>
                                        <?php else: ?>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="c_type" class="order_type custom-control-input" name="order_type" data-action="<?= base_url('menu/get_order_type_delivery_charge') ?>" value="collection" <?= !empty($order_type_session == 'collection') ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="c_type">Collection</label>
                                            </div>
                                        <?php endif ?>
                                    <?php elseif ($this->order_type == 'delivery'): ?>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="d_type" class="order_type custom-control-input" name="order_type" data-action="<?= base_url('menu/get_order_type_delivery_charge') ?>" value="delivery"<?= !empty($order_type_session == 'delivery') ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="d_type">Delivery</label>
                                        </div>
                                    <?php elseif ($this->order_type == 'collection'): ?>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="c_type" class="order_type custom-control-input" name="order_type" data-action="<?= base_url('menu/get_order_type_delivery_charge') ?>" value="collection" <?= !empty($order_type_session == 'collection') ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="c_type">Collection</label>
                                        </div>
                                    <?php else: ?>                                            
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="dinein_type" class="order_type custom-control-input" name="order_type" data-action="<?= base_url('menu/get_order_type_delivery_charge') ?>" value="dine_in"<?= !empty($order_type_session == 'dine_in') ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="dinein_type">Dine-In&nbsp;<?= $table_number ?></label>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>

                            <?php $order_type_session = $this->session->userdata('order_type_session'); ?>
                            <div class="delivery-details-block" style="display: <?=($order_type_session == 'delivery') ? 'block' : 'none' ?>">
                                <?php $this->load->view('my_account/delivery_details',$this->data); ?>
                            </div>

                            <div class="form-group">
                                <label>Add Comments About Your Order</label>
                                <textarea rows="5" id="notes" name="notes" class="input1"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="clearfix"></div> -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: 5px;">
                            <div class="custom-control custom-checkbox" style="margin-bottom: 0px;">
                                <input type="checkbox" class="custom-control-input" id="terms_conditions" name="terms_conditions" style="margin-left: 2px;">
                                <label class="custom-control-label" for="terms_conditions">I have read and agree to the <a class="terms-and-conditions" href="<?= base_url('terms_and_conditions') ?>" target="_blank">Terms and Conditions</a></label>
                            </div>
                            <!-- Update Part Start -->
                            <input type="hidden" name="tips_id" id="selected_tips_id" value="0">
                            <!-- Update Part End -->
                        </div>
                    </div>

                    <div class="row btn-row-mar">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col btn-col-pad">
                            <div class="process-back-to-menu"><a class="btn btn-secondary btn-block" href="<?= base_url('menu') ?>">Back To Menu</a></div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col btn-col-pad">
                            <?php $process_btn_text = ($is_pre_order) ? 'Process Pre-Order' : 'Process Payment'; ?>

                            <?php if (!is_shop_maintenance_mode()): ?>
                                <!-- Update Part Start -->
                                <button type="button" class="btn btn-success btn-block btn-process-payment" onclick="get_tips()"><?= $process_btn_text ?></button>
                                <!-- Update Part End -->
                                <img class="process-order-loader" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                            <?php endif ?>
                        </div>
                        <span id="c-ip"></span>
                    </div>

                    <!-- Update Part Start -->
                    <!-- The Tips Modal -->
                    <div class="modal fade" id="tipsModal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Tip Your Delivery</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <div id="tip-modal-body"><?= $tips_options ?></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success btn-block btn-process-payment" style="margin-top: 0px;"><?= $process_btn_text ?> Without Tips</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Update Part End -->
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Part Start -->
<div class="modal fade orderTypeMissMatch" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h5></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="message text-center"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn common-btn" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- Update Part End -->

<?php
    $this->load->view('menu/order_type_not_change_able_modal',$this->data);
    $stripe_details = get_stripe_settings();
    $publishable_key = '';

    if (!empty($stripe_details)) {
        $publishable_key = property_exists($stripe_details,'publishable_key') ? $stripe_details->publishable_key : '';
    }
    // Update Part Start
    $this->load->view('my_account/sage_pay_form', $this->data);
    // Update Part End
?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
    Stripe.setPublishableKey('<?= $publishable_key ?>');
    var card;
    var stripe = Stripe('<?= $publishable_key ?>');

    function get_tips() {
        var tips_status = get_tips_status();

        if (tips_status == 'yes') {
            $('#tipsModal').modal('show');
        } else {
            $("form[name='order_process_form']").trigger('submit');
        }
    }

    // Update Part Start
    function get_tips_status() {
        var payment_method = get_payment_method();
        var tips_modal_status = "<?= $tips_modal_status ?>";
        var tips_status = 'no';
        if (tips_modal_status == 'yes') {
            if (payment_method == 'cash') {
                var tips_status = "<?= get_tips_status('tips_for_cash') ?>";
            } else {
                var tips_status = "<?= get_tips_status('tips_for_card') ?>";
            }
        }
        return tips_status;
    }
    // Update Part End

    $(document).on('click','.tips-btn',function() {
        var tips_id = $(this).attr('tips-id');
        var tips_status = get_tips_status();
        if (tips_id == "" || tips_status == 'no') { tips_id = 0; }
        $('#selected_tips_id').val(tips_id);
        $('#tipsModal').modal('hide');
    });

    $(document).on('input','#delivery_address_line_1',function() {
        let deliveryAddressLine = $(this).val();
        deliveryAddressLine = deliveryAddressLine.replace(/['"]/g, '');
        $(this).val(deliveryAddressLine);
    });

    $.validator.addMethod("alphanumeric", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\s.]+$/i.test(value);
    });

    $.validator.addMethod("numeric", function (value, element) {
        return this.optional(element) || /^[0-9]+$/i.test(value);
    });

    $("form[name='order_process_form']").validate({
        rules: {
            first_name: { required: true, alphanumeric: true },
            last_name: { alphanumeric: true },
            email: { required: true, email: true, },
            mobile: { required: true, minlength: 11, maxlength: 11, numeric: true },
            payment_method: { required: true },
            delivery_type: { required: true },
            terms_conditions: { required: true },
            delivery_time: { required: true },
            delivery_postcode: {
                required: <?= ($order_type_session && $order_type_session == 'delivery') ? 'true' : 'false' ?>,
                alphanumeric: true
            },
            delivery_address_line_1: {
                required: <?= ($order_type_session && $order_type_session == 'delivery') ? 'true' : 'false' ?>,
                alphanumeric: true
            },
            notes: { alphanumeric: true }
        },

        messages: {
            first_name: {
                required: "Please Enter First Name",
                alphanumeric: "Letters, numbers and space only please"
            },
            last_name: { alphanumeric: "Letters, numbers and space only please" },
            email: {
                required: "Please Enter Email",
                email: "Please Enter a Valid Email",
            },
            mobile: {
                required: "Please Enter Mobile Number",
                maxlength: "Mobile must be 11 digit long",
                minlength: "Mobile must be at least 11 digit long",
                numeric: "Numbers only please",
            },
            terms_conditions: { required: "You must agree to our Terms and Conditions." },
            payment_method: { required: "Please check Payment Method" },
            delivery_time: { required: "Please Select Delivery/Collection Time" },
            delivery_type: { required: "Please Check Delivery Type"},
            delivery_postcode: {
                required: "Please write your delivery postcode",
                alphanumeric: "Letters, numbers and space only please"
            },
            delivery_address_line_1: {
                required: "Please write your delivery address",
                alphanumeric: "Letters, numbers and space only please"
            },
            notes: { alphanumeric: "Letters, numbers and space only please" },
        },

        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "help-block" );

            if ( (element.prop( "type" ) === "checkbox") ) {
                error.insertAfter( element.parent( "div" ) );
            } else if(element.prop( "type" ) === "radio"){
                error.insertAfter( element.parent().nextAll().last( "div" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".error-message" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).parents( ".error-message" ).addClass( "has-success" ).removeClass( "has-error" );
        },

        submitHandler: function (form) {
            $('.btn-process-payment').css('display','none');
            $('.process-order-loader').css('display','block');

            var payment_method = get_payment_method();

            if (payment_method == 'stripe') {
                stripePayment(form);
            } else if (payment_method == 'sagepay') {   // Update Part Start
                sagepay_transaction(form);
            } else if (payment_method == 'cardstream') {
                form.submit();
            } else {
                form.submit();
            }
        }
    });

    function sagepay_transaction(form) {
        var terms_conditions =  $('#terms_conditions').val();
        var delivery_time = $('#delivery_time').val();
        var delivery_postcode = $('#delivery_postcode').val();
        var delivery_address_line_1 = $('#delivery_address_line_1').val();
        var tips_id = $('#selected_tips_id').val();

        var sagepay_card_number = $('#sagepay_card_number').val();
        var sagepay_expiry_mm = $('#sagepay_expiry_mm').val();
        var sagepay_expiry_yy = $('#sagepay_expiry_yy').val();
        var sagepay_security_code = $('#sagepay_security_code').val();

        var customer_id = $('#id').val();

        const post_data = {
            'customer_id' : customer_id,
            'terms_conditions' : terms_conditions,
            'delivery_time' : delivery_time,
            'delivery_postcode' : delivery_postcode,
            'delivery_address_line_1' : delivery_address_line_1,
            'tips_id' : tips_id,
            'sagepay_card_number' : sagepay_card_number.replace(/\s/g, ""),
            'sagepay_expiry_mm' : sagepay_expiry_mm,
            'sagepay_expiry_yy' : sagepay_expiry_yy,
            'sagepay_security_code' : sagepay_security_code,
        };
        
        $('#tipsModal').modal('hide');
        let formData = $('#order_process_form').serialize();
        // $('.btn-process-payment').css('display', 'none');
        // $('.process-order-loader').css('display', 'block');

        $.ajax({
            type: "POST",
            async: false,
            url: '<?= base_url('order/sagepay_transaction') ?>',
            data: {post_data,formData},
            success: function (response) {
                // console.log(response);
                const isValid = response.is_valid;
                if (isValid) {
                    const data = response.transaction_info;
                    // console.log('data', data);
                    if ('status' in data) {
                        const transaction_id = data.transactionId;
                        const status_code = data.statusCode;
                        const status = data.status;
                        $('#sagepay_status').val(status);
                        $('#sagepay_transaction_id').val(transaction_id);
                        if (status == 'Ok') {
                            form.submit();
                        } else if (status == '3DAuth') {
                            if ('paReq' in data) {
                                let pareq = data.paReq;
                                const acs_url = data.acsUrl;
                                formData = $('#order_process_form').serialize();
                                const termUrl = $('#sagePayFallbackForm input[name="TermUrl"]').val();

                                $('#sagePayFallbackForm').attr('action', acs_url);
                                $('#sagePayFallbackForm input[name="PaReq"]').val(pareq);
                                $('#sagePayFallbackForm input[name="MD"]').val(transaction_id);
                                $('#sagePayFallbackForm input[name="TermUrl"]').val(termUrl+formData)
                                $('#sagePayFallbackForm').submit();
                            } else if ('cReq' in data) {
                                let creq = data.cReq;
                                const acs_url = data.acsUrl;

                                $('#sagePayChallengeAuthenticationForm').attr('action', acs_url);
                                $('#sagePayChallengeAuthenticationForm input[name="creq"]').val(creq);
                                $('#sagePayChallengeAuthenticationForm input[name="threeDSSessionData"]').val(transaction_id);
                                $('#sagePayChallengeAuthenticationForm').submit();
                            }
                        } else if (status == 'Rejected') {
                            $('.error-msg').css('display','block');
                            $('.error-msg-text').html(data.statusDetail);
                        }
                    } else {
                        $('.error-msg').css('display','block');
                        $('.error-msg-text').html(data.description);
                    }
                } else {
                    if (response.error_layer == 1) {
                        $('.sagepay-error').html(response.msg);
                    } else if (response.error_layer == 2) {
                        location.reload();
                    } else if (response.error_layer == 3) {
                        $('.error-msg').css('display','block');
                        $('.error-msg-text').html(response.msg);
                    }
                }
                $('.btn-process-payment').css('display', 'block');
                $('.process-order-loader').css('display', 'none');
            },
            error: function (error) {
                // console.log("error occured",error);
                // alert('error');
            }
        });
    }

    function setupElements() {
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };
        card = elements.create("card", { hidePostalCode: true, style: style });
        card.mount("#card-element");
        return { stripe: stripe, card: card, };
    };

    function stripePayment(form) {
        $.ajax({
            type: "POST",
            url: '<?= base_url('order/create_payment_intent') ?>',
            data: $('#order_process_form').serialize(),
            success: function (data) {
                console.log('data: ',data.clientSecret);
                if (data.clientSecret != '' && data.isValid == true) {
                    // Initiate the payment. If authentication is required, 
                    // confirmCardPayment will automatically display a modal
                    stripe.confirmCardPayment(data.clientSecret,{ payment_method: { card: card } }).then(function(confirmResult) {
                        if (confirmResult.error) {
                            // Show error to your customer
                            showError(confirmResult.error.message);
                        } else {
                            // The payment has been processed!
                            stripe.retrievePaymentIntent(data.clientSecret).then(function(retrieveResult) {
                                var paymentIntent = retrieveResult.paymentIntent;
                                var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);
                                console.log('paymentIntent: ',paymentIntent);

                                if (paymentIntent.status == 'succeeded') {
                                    $('.stripe-card-payment #stripe-token').val(data.token);
                                    form.submit();
                                }
                            });
                        }
                    });
                } else {
                    form.submit();
                }
            },
            error: function (error) {
                console.log("error: ",error);
            }
        });
    }

    var showError = function(errorMsgText) {
        // changeLoadingState(false);
        var errorMsg = document.querySelector(".sr-field-error");
        errorMsg.textContent = errorMsgText;
        setTimeout(function() {errorMsg.textContent = "";}, 8000);
        $('.btn-process-payment').css('display','block');
        $('.process-order-loader').css('display','none');
    };

    $('#same_as_billing_address_line_1_checkbox').click(function () {
        if ($(this).is(":checked")) {
            var billing_address_line_1 = $('#billing_address_line_1').val();
            $('#delivery_address_line_1').val(billing_address_line_1);
        } else {
            $('#delivery_address_line_1').val('');
        }
    });

    $('.order_type').click(function () {
        //click order type to set a session
        var order_type = get_order_type();
        var delivery_postcode = $('#delivery_postcode').val();
        get_order_type_session(order_type,delivery_postcode);
    });

    $('.process-back-to-menu').click(function () {
        var login_type = '<?php echo $login_type; ?>';
        var is_loggedIn = '<?php echo $is_loggedIn; ?>';

        if (login_type == 'guest' && is_loggedIn == true) {
            window.location = 'my_account/logout';
            return false;
        }
    });

    function get_order_type_session(order_type,delivery_postcode) {
        $('.btn-process-payment').attr('disabled',true);
        $('.content .overlay').fadeIn();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url("menu/get_order_type_session"); ?>',
            data: {'order_type': order_type,delivery_postcode:delivery_postcode},
            success: function (data) {
                if (data['current_total_cart_item'] != data['previous_total_cart_item']) {
                    var message = "Some Items are not available for <span style='text-transform: capitalize'>"+data['order_type']+"</span> Order";
                    $('.orderTypeMissMatch .modal-body .message').html(message);
                    $('.orderTypeMissMatch').modal('show');
                }

                $('.product-cart-block').html(data['cart_summary']);
                $('.delivery-collection-time').empty();
                $('.delivery-collection-time').html(data['delivery_collection_time']);

                if (data['order_type'] == 'delivery') {
                    $("#d_type").prop("checked", true);
                    document.getElementById("delivery_postcode").required = true;
                    document.getElementById("delivery_address_line_1").required = true;
                    getDeliveryChargeByPostCode(order_type,delivery_postcode);
                    $('.invalid-post-code-message').css('display','block');
                    $('.delivery-details-block').css('display','block');
                } else if (data['order_type'] == 'collection') {
                    $("#c_type").prop("checked", true);
                    document.getElementById("delivery_postcode").required = false;
                    document.getElementById("delivery_address_line_1").required = false;
                    let delPost = $('#delivery_postcode').val();
                    let delAdd = $('#delivery_address_line_1').val();
                    $('#delivery_postcode').val(delPost.replace(/[^a-z0-9\s.]/gi, '').replace(/[_]/g, ' '));
                    $('#delivery_address_line_1').val(delAdd.replace(/[^a-z0-9\s.]/gi, '').replace(/[_]/g, ' '));
                    $('.invalid-post-code-message').empty();
                    $('.invalid-post-code-message').css('display','none');
                    $('.delivery-details-block').css('display','none');
                } else {
                    $("#dinein_type").prop("checked", true);
                    document.getElementById("delivery_postcode").required = false;
                    document.getElementById("delivery_address_line_1").required = false;
                    let delPost = $('#delivery_postcode').val();
                    let delAdd = $('#delivery_address_line_1').val();
                    $('#delivery_postcode').val(delPost.replace(/[^a-z0-9\s.]/gi, '').replace(/[_]/g, ' '));
                    $('#delivery_address_line_1').val(delAdd.replace(/[^a-z0-9\s.]/gi, '').replace(/[_]/g, ' '));
                    $('.invalid-post-code-message').empty();
                    $('.invalid-post-code-message').css('display','none');
                    $('.delivery-details-block').css('display','none');
                }
                var isValidWithOrderType=data['isValidWithOrderType'];

                if(!isValidWithOrderType){
                    $('.cartOrderTypeNotChangeAbleModal .message').html(data['cartOrderTypeChangeMessage']);
                    $('.cartOrderTypeNotChangeAbleModal').modal('show');
                }
                $('.btn-process-payment').attr('disabled',false);
                $('.content .overlay').fadeOut();
            },
            error: function (error) {
                // console.log("error occured");
                $('.content .overlay').fadeOut();
            }
        });
    }

    var order_type = get_order_type();
    var delivery_postcode = $('#delivery_postcode').val();

    if ((typeof delivery_postcode) !== 'undefined') {
        getDeliveryChargeByPostCode(order_type,delivery_postcode);
        if (delivery_postcode.length >= 3) { getPostcodeSuggestion(order_type,delivery_postcode); }
        delivery_post_code();
    }

    function delivery_post_code() {
        $('#delivery_postcode').on('input',function (event) {
            var delivery_postcode = $(this).val();
            var order_type = get_order_type();

            if (delivery_postcode.length >= 3) {
                getPostcodeSuggestion(order_type,delivery_postcode);
                getDeliveryChargeByPostCode(order_type,delivery_postcode);
            }
            event.preventDefault();
        });
    }

    function getPostcodeSuggestion(order_type,delivery_postcode) {
        if (order_type == 'delivery') {
            if (delivery_postcode !== '' && (typeof delivery_postcode) !== 'undefined') {
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('menu/getPostcodeSuggestion'); ?>',
                    data: {order_type:order_type,postcode:delivery_postcode},
                    success: function (data) {
                        var jsonPostcode = data.jsonPostcode;
                        postcode = JSON.parse(jsonPostcode);

                        // initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:
                        autocomplete(document.getElementById("delivery_postcode"), postcode);
                    },
                    error: function (error) {
                        // console.log("error occured");
                    }
                });
            }
        }
    }

    function getDeliveryChargeByPostCode(order_type,delivery_postcode) {
        if(order_type=='delivery'){
            if((delivery_postcode!=='' )&& (typeof delivery_postcode!=='undefined')){
                $.ajax({
                    type: "POST",
                    url: '<?=base_url('menu/get_delivery_charge_postcodewise')?>',
                    data: {'order_type': order_type, 'delivery_postcode': delivery_postcode},
                    success: function (data) {
                        var cart_data = data['cart_summary'];
                        var message = data['message'];
                        var address = "";

                        var jsonPostcodeResult = data.jsonPostcodeResult;
                        if (jsonPostcodeResult) {
                            address = JSON.parse(jsonPostcodeResult);
                        }

                        // initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:
                        autocomplete(document.getElementById("delivery_address_line_1"), address);

                        if (!data['is_valid_post_code']) {
                            $('.invalid-post-code-message').html(message);
                        } else {
                            $('.invalid-post-code-message').empty();
                        }
                        $('.product-cart-block').empty();
                        $('.product-cart-block').html(cart_data);
                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
            }
        } else {
            $('.invalid-post-code-message').empty();
        }
    }

    function get_order_type() {
        var order_type = '';
        if ($('#d_type').is(':checked')) {
            order_type = $('#d_type').val();
        }

        if ($('#c_type').is(':checked')) {
            order_type = $('#c_type').val();
        }

        if ($('#dinein_type').is(':checked')) {
            order_type = $('#dinein_type').val();
        }
        return order_type;
    }

    function get_payment_method() {
        return $('.payment-method-block input[name="payment_method"]:checked').val();
    }

    var card_is_checked = $('.payment-method-block #stripe').is(':checked');

    if (card_is_checked) {
        $('.stripe-card-payment').fadeIn('slow');
    }

    $('.payment-method-block input[name="payment_method"]').click(function() {
        $('.btn-process-payment').attr('disabled',true);
        $('#sagepay_card_number').val('');
        $('#sagepay_security_code').val('');
        $('#sagepay_expiry_mm').val('');
        $('#sagepay_expiry_yy').val('');
        $('.sagpay-card-error-msg').html('');
        $('.sagepay-cvc-date-error-msg').html('');
        
        $('#cardstream_card_number').val('');
        $('#cardstream_security_code').val('');
        $('#cardstream_expiry_mm').val('');
        $('#cardstream_expiry_yy').val('');
        $('.cardstream-card-error-msg').html('');
        $('.cardstream-cvc-date-error-msg').html('');

        var payment_mode = $(this).val();
        var order_type = get_order_type();
        if (payment_mode == 'stripe') {
            $('.stripe-card-payment').fadeIn('slow');
            setupElements();
        } else {
            $('.stripe-card-payment').fadeOut('slow');
        }

        if (payment_mode == 'pay360') {
            $('.pay360-card-payment').fadeIn('slow');
        } else {
            $('.pay360-card-payment').fadeOut('slow');
        }

        if (payment_mode == 'worldpay') {
            $('.worldpay-card-payment').fadeIn('slow');
            setupElements();
        } else {
            $('.worldpay-card-payment').fadeOut('slow');
        }

        if (payment_mode == 'sagepay') {
            $('.sagepay-card-payment').fadeIn('slow');
        } else {
            $('.sagepay-card-payment').fadeOut('slow');
        }

        if (payment_mode == 'cardstream') {
            let formAction = '<?= base_url('order/cardstream_transaction') ?>';
            $('#order_process_form').attr('action',formAction);
            $('.cardstream-card-payment').fadeIn('slow');
        } else {
            let formAction = '<?= base_url('order/order_process') ?>';
            $('#order_process_form').attr('action',formAction);
            $('.cardstream-card-payment').fadeOut('slow');
        }

        // Update Part Start
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("order/get_service_charges"); ?>',
            data: {order_type,payment_mode},
            success: function (data) {
                $('.product-cart-block').html(data.product_cart);
            },
            error: function (error) {
            }
        });
        // Update Part End
    });

    function create_pay360_payment_request(event) {
        $('#customer_card_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                },
                error: function (error) {
                }
            });
        });
    }

    $("#delivery_time").change(function () {
        var time = this.value;
        $.ajax({
            type: "POST",
            url: '<?= base_url('menu/check_delivery_time') ?>',
            data: {'delivery_time': time},
            success: function (data) {
                var data = data['result'];
                if (data == '1') {
                    $('#delivery_time').val('');
                    alert('This slot already picked, Please choose another time.');
                    // $('select option[value="1"]').attr("selected",true);
                }
            },
            error: function (error) {
                // console.log("error occured");
            }
        });
    });
</script>