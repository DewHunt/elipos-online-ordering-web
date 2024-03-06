
<style>
    .subscribed-message{
        color: #ffffff;
    }
    .subscribed-message p{
        color: #ffffff;
        float: left;
    }
    #subscriber-client-form .error{
        float: left;
    }
</style>
<div id="subscribe_wrap">
    <div id="subscribe_block">
          <center>
        <div id="subscribe_block_left" style="width:100%;">
            <div class="subscribe_area_heading">Subscribe To Our <span
                    class="color_green text_bold">Newsletter</span></div>
            <div class="subscribe_area_details">
                Stay updated with all our special offers and latest deals, please enter your email address below:


            </div>

            <div id="subscribe_block_form">
                <form id="subscriber-client-form" method="post" action="<?=base_url('admin/subscriber/get_subscribed')?>">

                <ul>
                    <li>
                        <input type="text" placeholder="Enter Your Email"  name="email"
                               id="subscribe_email" class="subscribe_input">

                        <span class="subscribed-message "></span>
                    </li>
                    <li>
                        <button type="submit" class="subscribe_button" id="subscribe_button"
                               name="subscribe_button">Subscribe Now</button>
                    </li>
                </ul>
            </div>
            </form>
          
        </div>


          </center>


        <script>
            $('.subscribed-message').empty();

            $('#subscriber-client-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email address",
                        email: "Please enter a valid email address",
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
                submitHandler: function (form) {
                    $.ajax({
                        type: "POST",
                        url:  $('#subscriber-client-form').attr('action'),
                        data: $('#subscriber-client-form').serialize(),
                        success: function (data) {
                            $('.subscribed-message').html(data['message']);
                        },
                        error:function(error){
                            console.log("error occured");
                        }
                    });


                }
            });

        </script>

      <!--  <div id="subscribe_block_right">
            <div class="subscribe_area_heading">Our Delivery <span class="color_green text_bold">Partner</span>
            </div>
            <div class="subscribe_area_details">
                Always on customer's door within shortest possible time on receipt of information over e-mail,
                phone, fax or walk-in visit
            </div>

            <div id="delivery_partner_image_area">
                <img src="<?= base_url('assets/images/ixpress-logo.png') ?>" alt="" class=""/>
            </div>
        </div> -->
    </div>
</div>