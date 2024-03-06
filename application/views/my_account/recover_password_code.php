

                            <h1>Hi,<?=$customer->first_name.' '.$customer->last_name;  ?></h1>
                            <p style="font-size: 80%"> We sent 6 digits code in you email.Please enter code to reset you password</p>
                            <form id="recover_password_code"  method="post" action="<?=base_url('my_account/check_code')?>">
                                <div class="form-group form_padding">
                                    <input type="text" name="code" id="code"  class="input1"
                                           placeholder="Enter 6 digits Code">
                                </div>
                                <p class="error" style="margin-bottom: 0.5rem"><?=$message?></p>
                                <div class="form-group  text-xs-center">
                                    <button  id="check-code-button" type="submit"  class=" common-submit-button checkout_creat_account">Submit</button>
                                    <img class="password-recovery-loader"  style="display: none" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>

                                </div>
                            </form>

                            <script type="text/javascript">

                                $('#recover_password_code').validate({
                                    rules: {
                                        code: {
                                            required: true,
                                            maxlength: 6,
                                            minlength: 6
                                        },
                                    },
                                    messages:{

                                        code: {
                                            required: "Please enter valid code ",

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
                                            $('.cmspage_content .recovery-block').html(data);
                                            $('#check-code-button').css('display','block');
                                            $('.password-recovery-loader').css('display','none');

                                        });
                                    }

                                });
                                $('#check-code-button').click(function () {
                                    if($('#recover_password_code').valid()){
                                        $(this).css('display','none');
                                        $('.password-recovery-loader').css('display','block');
                                    }

                                });

                            </script>


