
<form id="recover_password_reset" class="" method="post" action="<?=base_url('my_account/recovery_password_reset')?>">
    <div class="fields form-group " id="pwd-container">
        <label>Password*</label>
        <input  class="input1" name="password" id="password" type="password">
        <div class="pwstrength_viewport_progress">
        </div>
    </div>
    <div class="fields form-group">
        <label>Confirm Password*</label>
        <input  class="input1" name="confirm_password" id="confirm_password" type="password">

    </div>
    <div class="form-group  text-xs-center">
        <button id="change-recovery-password"  type="submit"  class="common-btn ">Submit</button>
        <img class="password-recovery-loader" style="display: none" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>

    </div>
</form>

<script type="text/javascript">


    $('#recover_password_reset').validate({
        rules: {
            password:{
                required: true,
                minlength: 5,
            },
            confirm_password:{
                required: true,
                minlength: 5,
                equalTo:'#password'
            }
        },
        messages:{
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Password  match",
            },
            confirm_password: {
                required: "Please Confirm Password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Password does not match",
            }

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

            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data:$(form).serialize(),
                success: function (response) {
                    if( response.status === true ){
                        document.location.href =response.redirect;
                    }else{
                        $('.change-recovery-password').css('display','block');
                        $('.password-recovery-loader').css('display','none');
                    }

                },
                error:function(error){
                    console.log("error occured");
                }
            });


        }

    });


        $('.change-recovery-password"').click(function () {
            if( $('#recover_password_reset').valid()){
                $(this).css('display','none');
                $('.password-recovery-loader').css('display','block');
            }

    });


</script>
