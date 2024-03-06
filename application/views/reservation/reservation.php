<style>
    iframe { min-height: auto; } 
    .process-loader { width: 50px; margin-top: -9px; display: none; float: right; }
    .row { margin: 0 0 15px 0px; }
    .error { color: red; }
    .form-control { border: 1px solid #DFDFDF; color: #555555; border-radius: 0; }
    /* Chrome */
    ::-webkit-input-placeholder { color: #ececec;; font-size:70%; opacity:0.5; }
    /* IE 10+ */
    :-ms-input-placeholder { color: #ececec; font-size:70%; opacity:0.5; }
    /* Firefox 19+ */
    ::-moz-placeholder { color: #ececec; font-size:70%; opacity:0.5; }
    /* Firefox 4 - 18 */
    :-moz-placeholder { color: #ececec; font-size:70%; opacity:0.5; }
    .select-placeholder{ color: #ececec; font-size:70%; opacity:0.5; }
    .col-form-label { font-size:17px; }
    .select-placeholde:selected { color: #ececec; font-size:70%; opacity:0.5; }
    select option:selected { font-size:70%; }
    .form-group { margin-bottom: 5px !important }
    .error-style { color: red; font-weight: bold; text-align: center; margin-top: 6px; }
    .show { display: block; }
    .hide { display: none; }
    .reservation-msg { margin-top: 6px; font-weight: bold; color: red; text-align: center; }
    .datepicker-days, .table-condensed { width: 500px; height: auto; }
    .table-condensed { border: 1px solid #008000; border-collapse: collapse; }
    .datepicker .datepicker-switch, .datepicker .prev, .datepicker .next {
        cursor: pointer;
        background: linear-gradient(rgb(0, 128, 0, 0.8),rgb(0, 133, 0, 0.6)) !important;
        color: #0c0c0c;
        border-radius: 0px;
        margin: 5px;
        border: 1px solid #008000;
    }
    .invalid { color: #ff0000; }
    .refresh {
        font-size: 12px;
        font-weight: bold;
        color: #ff0000;
        margin-left: 10px;
        cursor: pointer;
        padding: 5px;
        background: linear-gradient(rgb(173, 216, 230, 0.8),rgb(173, 216, 230, 0.6));
        box-shadow: 5px 5px 5px lightblue;
    }
    .checkout_creat_account { width: 150px !important }
    .btn-disabled { opacity: .65; }
</style>

<?php
    $form_data = $this->session->userdata('booking_form_data');
    $first_name = get_property_value('first_name',$customer);
    $last_name = get_property_value('last_name',$customer);
    $name = trim($first_name.' '.$last_name);
    $email = get_property_value('email',$customer);
    $phone = get_property_value('mobile',$customer);
    $reservation_date = date('Y-m-d');
    $start_time_hr = 6;
    $start_time_min = 0;
    $start_time_am_pm = 'PM';
    $number_of_guest = '';
    $booking_purpose = '';

    if ($form_data) {
        $name = get_array_key_value('name',$form_data);
        $email = get_array_key_value('email',$form_data);
        $phone = get_array_key_value('phone',$form_data);
        $reservation_date = get_array_key_value('reservation_date',$form_data);
        $start_time_hr = get_array_key_value('start_time_hr',$form_data);
        $start_time_min = get_array_key_value('start_time_min',$form_data);
        $start_time_am_pm = get_array_key_value('start_time_am_pm',$form_data);
        $number_of_guest = get_array_key_value('number_of_guest',$form_data);
        $booking_purpose = get_array_key_value('booking_purpose',$form_data);
    }

    $payment_settings = get_payment_settings();
    $is_payment_available = get_property_value('reservation', $payment_settings);
    $payment_gateways = get_property_value('payment_gateway', $payment_settings);    
    $form_action = base_url('reservation/save_reservation');
    $is_reservation_payment_available = get_reservation();
    $form_col_class = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
    if ($is_reservation_payment_available == 'yes') {
        $form_col_class = "col-lg-8 col-md-8 col-sm-8 col-xs-12";
        if (in_array('sagepay',$payment_gateways)) {
            $form_action = base_url('reservation/save_reservation');
        } else if (in_array('cardstream',$payment_gateways)) {
            $form_action = base_url('reservation/cardstream_transaction');
        }
    }
    $error_msg = $this->session->flashdata('error_msg');
    $success_msg = $this->session->flashdata('success_msg');
    $success_alert_class = 'hide';
    $error_alert_class = 'hide';
    if ($success_msg) {
        $success_alert_class = "show";
    }
    if ($error_msg) {
        $error_alert_class = "show";
    }

    $stripe_details = get_stripe_settings();
    $publishable_key = get_property_value('publishable_key',$stripe_details);
?>

<div class="card">
    <div class="card-header"><h1 class="text-color cart-title">Reservation</h1></div>
    <div class="card-body">
        <div class="alert alert-success success-msg <?= $success_alert_class ?>" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h6 class="text-xs-center success-msg-text" style="text-align: center">
                <?= $success_msg; ?>
            </h6>
        </div>

        <div class="alert alert-danger error-msg <?= $error_alert_class ?>" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h6 class="text-xs-center error-msg-text" style="text-align: center">
                <?= $error_msg; ?>
            </h6>
        </div>
        <div class="error error-message"><?php echo validation_errors(); ?></div>
        
        <form method="post" action="<?= $form_action ?>" name="save_reservation_form" id="save_reservation_form">
            <div class="row no-margin">
                <div class="<?= $form_col_class ?> no-padding">
                    <div class="row no-margin">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?= $name ?>">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?= $email ?>">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="reservation-date">Date</label>
                                <span class="fa fa-calendar" aria-hidden="true"></span>
                                <input type="text" class="form-control datepicker reservation_date" id="datepicker" name="reservation_date" placeholder="YYYY - MM - DD" autocomplete="off" value="<?= $reservation_date ?>">
                                <p class="error" id="date_error"></p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="time">Time</label>
                                <div class="row no-margin">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 no-padding">
                                        <select name="start_time_hr" class="form-control" id="start_time_hr">
                                            <?php for ($hour = 6; $hour <= 11; $hour++) { ?>
                                                <?php
                                                    $hour_val = ($hour >= 0 && $hour <= 9) ? '0'.$hour : $hour;
                                                    $select = '';
                                                    if ($hour_val == $start_time_hr) {
                                                        $select = 'selected';
                                                    }
                                                ?>
                                                <option name="start_time_hr" value="<?= $hour_val ?>" <?= $select ?>><?= $hour_val ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 no-padding">
                                        <select name="start_time_min" class="form-control" id="start_time_min">
                                            <?php for ($min = 0; $min <= 45; $min = $min + 15) { ?>
                                                <?php
                                                    $min_val = ($min >= 0 && $min <= 9) ? '0'.$min : $min;
                                                    $select = '';
                                                    if ($min_val == $start_time_min) {
                                                        $select = 'selected';
                                                    }
                                                ?>
                                                <option name="start_time_min" value="<?= $min_val ?>" <?= $select ?>>
                                                    <?= $min_val ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 no-padding">
                                        <select name="start_time_am_pm" class="form-control" id="start_time_am_pm">
                                            <!-- <option name="start_time_am_pm" value="AM">AM</option> -->
                                            <option name="start_time_am_pm" value="PM" readonly="" <?= $start_time_am_pm == 'PM'? 'selected' : '' ?>>PM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <p class="error" id="time_text"></p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="name">Phone</label>
                                <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?= $phone ?>">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="no-of-people">No. Of People</label>
                                <input type="number" name="number_of_guest" class="form-control" placeholder="Number of guests" min="1" value="<?= $number_of_guest ?>">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="booking_purpose">Notes</label>
                                <textarea name="booking_purpose" class="form-control" id="booking_purpose" rows="3" placeholder="Note"><?= $booking_purpose ?></textarea>
                            </div>
                        </div>

                        <?php if ($is_reservation_payment_available == 'no'): ?>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="captcha-text">Enter Captcha Text</label>
                                <div class="form-group">
                                    <input type="text" name="captcha_text" class="form-control" id="captcha-input" placeholder="Enter Captcha Text"></input>
                                    <span class="error captcha-error-msg"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="captcha-image">Captcha</label>
                                <div class="form-group">
                                    <span id="captcha-img"><?= $captcha_image ?></span>
                                    <span class="btn btn-danger" id="refresh-captcha"><i class="fa fa-refresh" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>

                <?php if ($is_reservation_payment_available == 'yes'): ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 payment-method-block">
                        <?php
                            if (in_array('stripe',$payment_gateways)) {
                                $this->load->view('reservation/payment_gateways/stripe/stripe',$this->data);
                            } else if (in_array('sagepay',$payment_gateways)) {
                                $this->load->view('reservation/payment_gateways/sagepay/sagepay',$this->data);
                            } else if (in_array('cardstream',$payment_gateways)) {
                                $this->load->view('reservation/payment_gateways/cardstream/cardstream',$this->data);
                            }
                        ?>
                        <p class="reservation-msg">To reservation you have to pay £<?= get_reservation_amount() ?></p>
                    </div>
                <?php endif ?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button type="submit" class="checkout_creat_account reservation-payment" id="send">Reserve a Table</button>
                    <img class="process-loader" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('reservation/payment_gateways/sagepay/sage_pay_form', $this->data); ?>
<!-- End Login/Register Form -->

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
    Stripe.setPublishableKey('<?= $publishable_key ?>');
    var card;
    var stripe = Stripe('<?= $publishable_key ?>');
    var payment_method = getPaymentMethod();

    $(document).ready(function() {
        var reservationDate = $('.reservation_date').val();
        var hour = $('#start_time_hr').val();
        var min = $('#start_time_min').val();
        var am_pm = $('#start_time_am_pm').val();
        var time = hour+':'+min+' '+am_pm;
        var dateValidResponse = check_valid_date(reservationDate);
        var timeValidResponse = check_valid_time(time);
        setSubmitButtonDisable(dateValidResponse,timeValidResponse);
        if (payment_method == 'stripe') {
            setupElements();
        }
    });

    function setSubmitButtonDisable(dateValidResponse,timeValidResponse) {
        var dateValidStatus = false;
        var timeValidStatus = false;

        if (dateValidResponse) {
            var dateValidResponseJson = dateValidResponse.responseJSON;
            if (dateValidResponseJson) {
                dateValidStatus = dateValidResponseJson.status;
            }
        }

        if (timeValidResponse) {
            var timeValidResponseJson = timeValidResponse.responseJSON;
            if (timeValidResponseJson) {
                timeValidStatus = timeValidResponseJson.status;
            }
        }

        if (dateValidStatus == false || timeValidStatus == false) {            
            $('#send').addClass('btn-disabled');
            $('#send').prop('disabled',true);
        } else {
            $('#send').removeClass('btn-disabled');
            $('#send').prop('disabled',false);
        }
    }

    var datesDisabled = '<?= $closing_date ?>';
    // console.log('datesDisabled: ',datesDisabled);
    $("#datepicker").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        startDate: new Date(),
        clearBtn: true,
        beforeShowDay: function(date) {
            var ymd = date.getFullYear()+'-'+('0'+(date.getMonth()+1)).slice(-2)+'-'+('0'+date.getDate()).slice(-2);
            // console.log(ymd+' = '+datesDisabled.indexOf(ymd));
            if (datesDisabled.indexOf(ymd) >= 0) {
                return { enabled : false, tooltip: '<?= $message ?>' };
            } else {
                return { enabled : true, };
            }
        }
    });

    $(document).on('changeDate','.reservation_date',function() {
        var date = $(this).val();
        var hour = $('#start_time_hr').val();
        var min = $('#start_time_min').val();
        var am_pm = $('#start_time_am_pm').val();
        var time = hour+':'+min+' '+am_pm;
        var dateValidResponse = check_valid_date(date);
        var timeValidResponse = check_valid_time(time);
        setSubmitButtonDisable(dateValidResponse,timeValidResponse);
    });

    function check_valid_date(date = '') {
        return $.ajax({
            type: "POST",
            url: '<?= base_url('reservation/check_valid_date') ?>',
            async: false,
            data: {date},
            success: function (data) {
                $('#date_error').html('');
                if (!data.status) {
                    var msg = "We are sincerely sorry! because our activities will be closed on "+date;
                    if (data.message) {
                        msg = data.message;
                    }
                    $('#date_error').html(msg);
                }
            },
            error: function (error) {
            }
        });
    }

    $(document).on('change','#start_time_hr,#start_time_min,#start_time_am_pm',function() {
        var hour = $('#start_time_hr').val();
        var min = $('#start_time_min').val();
        var am_pm = $('#start_time_am_pm').val();
        var time = hour+':'+min+' '+am_pm;
        var reservationDate = $('.reservation_date').val();

        var timeValidResponse = check_valid_time(time);
        var dateValidResponse = check_valid_date(reservationDate);
        setSubmitButtonDisable(dateValidResponse,timeValidResponse);
    });

    function check_valid_time(time = '') {
        return $.ajax({
            type: "POST",
            url: '<?= base_url('reservation/check_valid_time') ?>',
            async: false,
            data: {time},
            success: function (data) {
                $('#time_text').html('');
                if (!data.status) {
                    var msg = "We are sincerely sorry! because at "+time+" our activities will be closed. Please select another time";
                    if (data.message) {
                        msg = data.message;
                    }
                    $('#time_text').html(msg);
                }
            },
            error: function (error) {
            }
        });
    }

    $(document).on('click','#refresh-captcha',function() {
        $.ajax({
            type: "POST",
            url: '<?= base_url('reservation/refresh_captcha') ?>',
            success: function (data) {
                $('#captcha-img').html(data.captcha_image);
            },
            error: function (error) {
            }
        });
    });

    $.validator.addMethod("alphanumeric", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\s.]+$/i.test(value);
    });

    $.validator.addMethod("numeric", function (value, element) {
        return this.optional(element) || /^[0-9]+$/i.test(value);
    });

    $("form[name='save_reservation_form']").validate({
        rules: {
            name: { required: true, alphanumeric: true },
            phone: { required: true, minlength: 11, maxlength: 11, numeric: true },
            email: { required: true, email: true },
            reservation_date: { required: true },
            payment_method: { required: <?= $is_reservation_payment_available == 'yes' ? 'true' : 'false' ?> },
            number_of_guest: { required: true },
            booking_purpose : { alphanumeric: true },
            captcha_text: {
                required: <?= $is_reservation_payment_available == 'yes' ? 'false' : 'true' ?>,
                remote: {
                    url: 'reservation/check_captcha',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        captchaText: function() {
                            return $('#captcha-input').val();
                        }
                    },
                }
            },
        },
        messages: {
            name: {
                required: "Please enter name",
                alphanumeric: "Letters, numbers and space only please"
            },
            phone: {
                required: "Please enter phone",
                maxlength: "Mobile must be 11 digit long",
                minlength: "Mobile must be at least 11 digit long",
                numeric: "Numbers only please"
            },
            email: {
                required: "Please enter email",
                email: "Please Enter a Valid Email"
            },
            reservation_date: { required: "Please select reservation date" },
            payment_method: { required: "Please check Payment Method" },
            number_of_guest: { required: "Please enter number of guest" },
            booking_purpose: { alphanumeric: "Letters, numbers and space only please" },
            captcha_text: {
                required: "Please enter captcha text",
                remote: "Captcha not matched."
            },
        },

        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "help-block" );

            if ((element.prop("type") === "checkbox")) {
                error.insertAfter(element.parent("div"));
            } else if(element.prop("type") === "radio") {
                error.insertAfter(element.parent("div"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element,errorClass,validClass) {
            $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element,errorClass,validClass) {
            $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
        },
        submitHandler: function (form,event) {
            // event.preventDefault();
            $('.reservation-payment').css('display', 'none');
            $('.process-loader').css('display', 'inline-block');

            if (payment_method == 'stripe') {
                stripePayment(form);
            } else if (payment_method == 'sagepay') {
                sagepayTransaction(form);
            } else if (payment_method == 'cardstream') {
                form.submit();
            } else {
                form.submit();
            }
        }
    });

    function getPaymentMethod() {
        return $('.payment-method-block input[name="payment_method"]:checked').val();
    }

    function setupElements() {
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "15px",
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
            url: '<?= base_url('reservation/create_payment_intent') ?>',
            data: $('#save_reservation_form').serialize(),
            success: function (data) {
                console.log('data: ',data.clientSecret);
                if (data.clientSecret != '' && data.isValid == true) {
                    // Initiate the payment. If authentication is required, 
                    // confirmCardPayment will automatically display a modal
                    stripe.confirmCardPayment(data.clientSecret,{ payment_method: { card: card } }).then(function(confirmResult) {
                        if (confirmResult.error) {
                            // Show error to your customer
                            showError(confirmResult.error.message);
                            // alert(confirmResult.error.message);
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

    function showError(errorMsgText) {
        // changeLoadingState(false);
        var errorMsg = document.querySelector(".sr-field-error");
        errorMsg.textContent = errorMsgText;
        setTimeout(function() {errorMsg.textContent = "";}, 8000);
        $('.reservation-payment').css('display', 'inline-block');
        $('.process-loader').css('display', 'none');
    };

    function sagepayTransaction(form) {
        var sagepay_card_number = $('#sagepay_card_number').val();
        var sagepay_expiry_mm = $('#sagepay_expiry_mm').val();
        var sagepay_expiry_yy = $('#sagepay_expiry_yy').val();
        var sagepay_security_code = $('#sagepay_security_code').val();
        var card_holder_name = $('#name').val();

        const post_data = {
            'sagepay_card_number' : sagepay_card_number.replace(/\s/g, ""),
            'sagepay_expiry_mm' : sagepay_expiry_mm,
            'sagepay_expiry_yy' : sagepay_expiry_yy,
            'sagepay_security_code' : sagepay_security_code,
            'card_holder_name' : card_holder_name,
        };
        let formData = $('#save_reservation_form').serialize();

        $.ajax({
            type: "POST",
            async: false,
            url: '<?= base_url('reservation/sagepay_transaction') ?>',
            data: {post_data,formData},
            success: function (response) {
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
                    } else {
                        $('.error-msg').css('display','block');
                        $('.error-msg-text').html(response.msg);
                    }
                }
                $('.reservation-payment').css('display', 'inline-block');
                $('.process-loader').css('display', 'none');
            },
            error: function (error) {
                console.log("error: ",error);
            }
        });
    }
</script>
