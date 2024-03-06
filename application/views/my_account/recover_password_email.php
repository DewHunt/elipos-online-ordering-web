

<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content">
                <h1 class="text-color">Password Recovery</h1>
                <div class="col-xs-12 col-sm-10 col-md-6 offset-sm-1 offset-md-3">
                    <div class="recovery-block" style="padding: .5rem">
                        <div class="innercommon-right-content">
                            <form id="recover_password_email_form" name="recover_password_email_form" class="" method="post" action="<?= base_url('my_account/check_email') ?>">
                                <div class="form-group form_padding">
                                    <input type="email" name="email" id="email"  class="input1"
                                           placeholder="Enter email address">
                                </div>
                                <div class="form-group  text-xs-center">
                                    <button type="submit" id="check-email-button" class="common-submit-button checkout_creat_account">Submit</button>
                                    <img class="password-recovery-loader" style="display: none" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>

                                </div>

                            </form>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<script type="text/javascript">


    $('#recover_password_email_form').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
        },
        messages:{

            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email"
            },
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "help-block" );

            if ( (element.prop( "type" ) === "checkbox") ) {
                error.insertAfter( element.parent( "div" ) );
            } else if(element.prop( "type" ) === "radio"){
                error.insertAfter( element.parent().nextAll().last( "div" ) );
            }else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".error-message" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).parents( ".error-message" ).addClass( "has-success" ).removeClass( "has-error" );
        },
        submitHandler: function(form) {
            $.post($(form).attr('action'), $(form).serialize(),function(data){

                $('.recovery-block').html(data);
                $('#check-email-button').css('display','block');
                $('.password-recovery-loader').css('display','none');

            });
        }

    });
    $('#check-email-button').click(function () {
        if($('#recover_password_email_form').valid()){
            $(this).css('display','none');
            $('.password-recovery-loader').css('display','block');
        }

    });
</script>

