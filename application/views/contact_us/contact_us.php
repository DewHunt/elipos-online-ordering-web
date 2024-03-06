<div id="main-contanier" class="contact_us">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content">
                <h1>Contact Us</h1>
                <div class="shop-timing-block contact_us_form_our_location">Our Opening & Closing Hours</div>
                    <?php $this->load->view('shop_timing_list'); ?>
                    <div class="contact_us_form_our_location">Our Location</div>
                    <div class="row">
                        <div class="google_map" style="margin-bottom: 20px;width: 100%">
                            <div id="map" style="width:100%;height:300px"><?=$page_details->content?></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row contact_us_all_form" style="margin-top: 50px">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="margin-bottom-design">
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                    <i class="fa fa-map-marker fa-2x"></i>
                                </div>
                                <div class=" border-bottom-design">
                                    Address <p><?=get_company_address()?></p> 
                                </div>
                            </div>
                            <div class="contact-us-margin-telephone">
                                <div><i class="fa fa-phone fa-2x"></i></div>
                                <div class=" border-bottom-design">
                                    Telephone <p><?=get_company_contact_number()?></p>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 contact-us-margin-fax">
                                <i class="fa fa-mobile fa-2x"></i>
                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 border-bottom-design contact-us-margin-fax">
                                Mobile <p><?=get_company_contact_number()?></p>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contact_us_customer_services contact-us-margin-why-to">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Ways to get in touch .</div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                            <i class="iconbox button fa fa-tasks fa-2x tasks-icon"></i>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 customer_service">
                                            Customer Service <p><?=get_company_contact_email()?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                            <i class="iconbox button fa fa-share fa-2x tasks-icon"></i>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 customer_service">
                                            Returns and Refunds: <p><?=get_company_contact_email()?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="contact-us-form-block">
                                <?php $this->load->view('contact_us/form'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Scroll To Top-->
        <a href="#" class="typtipstotop"></a>
    </div>
    <!-- End Login/Register Form -->
</div>

<script  type="text/javascript">
    contact_us_form_validations();
    function contact_us_form_validations() {
        $('#contact-us-form').validate({
            rules: {
                name: "required",
                message: "required",
                email: {
                    required: true,
                    email: true,
                },

            },
            messages: {
                name:"Please write you name",
                message: "Please write message",
                email: {
                    required: "Please enter email address",
                    email: "Please enter a valid email address",
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
            submitHandler: function (form) {
                if (confirm("Are sure to send message ?")) {
                    $.ajax({
                        type: "POST",
                        url:  $('#contact-us-form').attr('action'),
                        data: $('#contact-us-form').serialize(),
                        success: function (data) {
                            $('.contact-us-form-block').html(data);
                        },
                        error:function(error){
                            console.log("error occured");
                        }
                    });
                }
            }
        });
    }
</script>