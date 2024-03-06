<style>
    /* Firefox */
    ::placeholder { color: #79796e; opacity: 1;}
    /* Internet Explorer 10-11 */
    :-ms-input-placeholder { color: #79796e; }
    /* Microsoft Edge */
    ::-ms-input-placeholder { color: #79796e; }
    .checkout_login_form_area_left_text { margin: 0px; font-size: 16px; line-height: 40px; }
</style>

<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="checkout_login_area">
                <div class="checkout_login_area_heading">
                    <div class="float-left">Login Panel</div>
                    <div class="float-right">
                        <a href="<?= base_url('menu') ?>" class="continue-shopping-margin right-side-view register-tab common-submit-button checkout_creat_account">
                            <i class="fa fa-shopping-bag" aria-hidden="true"></i> Continue Shopping
                        </a>
                    </div>
                </div>

                <div id="registermailerror" name="registermailerror" class="error-heading" style="text-align: center; color: red;"></div>

                <form id="login_form" name="login_form" method="post" action="<?= base_url('my_account/login_action') ?>">
                    <div class="checkout_login_area_left">
                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">Email<span class="mandatory-field-color">*</span> :</div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <input type="email" class="form-control" value="" id="email" name="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">
                                    Password<span class="mandatory-field-color">*</span> :
                                </div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <input type="password" class="form-control" value="" id="loginpassword" name="password" placeholder="*****">
                            </div>
                        </div>

                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">&nbsp;</div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <a id="forgot-passwd" href="<?= base_url('my_account/recovery') ?>">Forgot password?</a>
                            </div>
                        </div>

                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">&nbsp;</div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <!--<input type="button" class="checkout_login common-submit-button" value="Login" onclick="return checklogin()" id="continue-order">-->
                                <button class="register-tab common-submit-button checkout_creat_account">
                                    <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                                </button>
                            </div>


                            <div class="checkout_login_form_area">
                                <div class="checkout_login_form_area_left">
                                    <div class="checkout_login_form_area_left_text"></div>
                                </div>

                                <div class="error checkout_login_form_area_right">
                                    <?php
                                        if (!empty($this->session->flashdata('customer_login_error'))) {
                                            echo $this->session->flashdata('customer_login_error');
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form id="registration_form" name="registration_form" method="post" action="<?= base_url('my_account/registration_action') ?>">
                    <div class="checkout_login_area_right">
                        <div class="checkout_login_area_right_text">
                            New To <span class="color_green text_bold"><?php echo get_company_name(); ?>?</span> Please Create An Account.
                        </div>

                        <?php if ($this->session->flashdata('form_validation_error')): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?= $this->session->flashdata('form_validation_error'); ?>
                            </div>
                        <?php endif ?>

                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">
                                    Title<span class="mandatory-field-color">*</span> :
                                </div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <select class="form-control" id="title" name="title">
                                    <option id="title" name="title" value="">Please Select</option>
                                    <option id="title" name="title" value="Mr.">Mr.</option>
                                    <option id="title" name="title" value="Mrs.">Mrs.</option>
                                    <option id="title" name="title" value="Miss">Miss</option>
                                </select>
                            </div>
                        </div>

                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">
                                    First Name<span class="mandatory-field-color">*</span> :
                                </div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <input type="text" class="form-control" value="" id="first_name" name="first_name" placeholder="First Name">
                            </div>
                        </div>

                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">Last Name :</div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <input type="text" class="form-control" value="" id="last_name" name="last_name" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">
                                    Email<span class="mandatory-field-color">*</span> :
                                </div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <input type="email" class="form-control" value="" id="email" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">
                                    Mobile<span class="mandatory-field-color">*</span> :
                                </div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <input type="number" class="form-control" value="" id="mobile" name="mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">
                                    Postcode<span class="mandatory-field-color">*</span> :
                                </div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <div autocomplete="off">
                                    <div class="autocomplete" style="width: 100%">
                                        <input type="text" class="form-control" value="" id="billing_postcode" name="billing_postcode" placeholder="Postcode">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">
                                    Password<span class="mandatory-field-color">*</span> :
                                </div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <input type="password" class="form-control" value="" id="password" name="password" placeholder="*****">
                            </div>
                        </div>
                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">
                                    Confirm Password<span class="mandatory-field-color">*</span> :
                                </div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <input type="password" class="form-control" value="" id="confirm_password" name="confirm_password" placeholder="*****">
                            </div>
                        </div>

                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text" style="line-height: 24px;">
                                    Terms And Conditions<span class="mandatory-field-color">*</span> :
                                </div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="terms_conditions" name="terms_conditions" style="margin-left: 2px;">
                                    <label class="custom-control-label" for="terms_conditions">I have read and agree to the <a class="terms-and-conditions" href="<?= base_url('terms_and_conditions') ?>" target="_blank">Terms and Conditions</a></label>
                                </div>
                            </div>
                        </div>

                        <div class="checkout_login_form_area">
                            <div class="checkout_login_form_area_left">
                                <div class="checkout_login_form_area_left_text">
                                    <span id="captcha-img"><?= $captcha_image ?></span>
                                    <span class="btn btn-danger" id="refresh-captcha">
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="checkout_login_form_area_right">
                                <input type="test" class="form-control" id="captcha-input" name="captcha_text" placeholder="Enter Captcha Text">
                                <span class="error captcha-error-msg"></span>
                            </div>
                        </div>

                        <div class="checkout_login_form_area text-right">
                            <button class="register-tab common-submit-button checkout_creat_account">Create Account</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
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

    $("form[name='login_form']").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: "required",
        },
        messages: {
            email: {
                required: "Please Enter Your Email",
                email: "Please Enter a Valid Email",
            },
            password: "Please Enter Password",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("form[name='registration_form']").validate({
        rules: {
            title: "required",
            first_name: { required: true, alphanumeric: true },
            last_name: { alphanumeric: true },
            terms_conditions: { required: true },
            email: {
                required: true,
                email: true,
            },
            mobile: { required: true, minlength: 11, maxlength: 11, numeric: true },
            billing_postcode: { alphanumeric: true },
            password: {
                required: true,
                minlength: 5,
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: '#password',
            },
            captcha_text: {
                required: true,
                remote: {
                    url: 'my_account/check_captcha',
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
            title: "Please Select Title",
            first_name: {
                required: "Please Enter First Name",
                alphanumeric: "Letters, numbers and space only please"
            },
            last_name: {
                alphanumeric: "Letters, numbers and space only please"
            },
            mobile: {
                required: "Please Enter Mobile",
                maxlength: "Mobile must be 11 digit long",
                minlength: "Mobile must be at least 11 digit long",
                numeric: "Numbers only please",
            },
            billing_postcode: {
                alphanumeric: "Letters, numbers and space only please"
            },
            email: {
                required: "Please Enter Your Email",
                email: "Please Enter a Valid Email",
            },
            password: {
                required: "Please provide a password",
                minlength: "Password must be at least 5 characters long",
            },
            confirm_password: {
                required: "Please provide a confirm password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Password doest not match",
            },
            terms_conditions: "<br> You must agree to our Terms and Conditions.",
            captcha_text: {
                required: "Please enter captcha text",
                remote: "Captcha not matched."
            },
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "help-block" );

            if ((element.prop( "type" ) === "checkbox")) {
                error.insertAfter( element.siblings('label'));
            } else if(element.prop( "type" ) === "radio"){
                error.insertAfter( element.parent().nextAll().last( "div" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).on('input','#billing_postcode',function(){
        var postcode = $(this).val();
        if (postcode !== '' && (typeof postcode) !== 'undefined' && postcode.length >= 3) {
            $.ajax({
                type: "POST",
                url: '<?= base_url('menu/getPostcodeSuggestion'); ?>',
                data: {order_type:'delivery',postcode:postcode},
                success: function (data) {
                    var jsonPostcode = data.jsonPostcode;
                    postcode = JSON.parse(jsonPostcode);
                    // console.log(postcode);

                    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
                    autocomplete(document.getElementById("billing_postcode"), postcode);
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }
    });
</script>