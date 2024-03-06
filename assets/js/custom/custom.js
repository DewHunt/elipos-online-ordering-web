jQuery(document).ready(function() {
    if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {

        jQuery(".text-box").focus(function() {
            if (this.value === this.defaultValue) {
                this.value = '';
            }
        }).blur(function() {
                if (this.value === '') {
                    this.value = this.defaultValue;
                }
            });

        jQuery('#login-toggle').bind('touchend', function() {
            jQuery('#login-wrapper').slideToggle();
            jQuery('#login-toggle').toggleClass('open-nav');
        });

        jQuery('.overlay-popup-header .login span').bind('touchstart', function() {
            jQuery('.overlay').fadeOut();
            jQuery('#login-wrapper').delay(500).fadeIn();
            jQuery('#login-toggle').addClass('open-nav');
        });

    } else {

        jQuery(".text-box").focus(function() {
            if (this.value === this.defaultValue) {
                this.value = '';
            }
        }).blur(function() {
                if (this.value === '') {
                    this.value = this.defaultValue;
                }
            });

        jQuery('#login-toggle').click(function() {
            jQuery('#login-wrapper').slideToggle();
            jQuery('#login-toggle').toggleClass('open-nav');

            if (jQuery('#login-toggle').hasClass('open-nav')) {
                jQuery('#login_arrow').attr('src', base_url + 'assets/images/arrup.png');
            } else {
                jQuery('#login_arrow').attr('src', base_url + 'assets/images/arr.png');
            }
        });

        jQuery('#user-sub-menu').click(function() {

            if (jQuery(".user-sub-menu").is(":hidden")) {
                jQuery('#login_arrow').attr('src', base_url + 'assets/images/arrup.png');
            } else {
                jQuery('#login_arrow').attr('src', base_url + 'assets/images/arr.png');
            }
            jQuery('.user-sub-menu').slideToggle();

        });

        jQuery('.overlay-popup-header .login span').click(function() {
            jQuery('.overlay').fadeOut();
            jQuery('#login-wrapper').delay(500).fadeIn();
            jQuery('#login-toggle').addClass('open-nav');

        });

        jQuery('#password').keydown(function(e) {
            if (e.keyCode == 13) {
                //doLogin();
                pop_up_login();
            }
        });

        jQuery('#username').keydown(function(e) {
            if (e.keyCode == 13) {
                //doLogin();
                pop_up_login();
            }
        });

    }

});
function pop_up_login() {
    var uid = jQuery('#username').val();
    var upass = jQuery('#password').val();

    if (uid == "" || uid == "Email address") {
        alert('Please enter your email address.');
        jQuery('#username').focus();
        return;
    }
    if (upass == "" || upass == "Password") {
        alert('Please enter your password.');
        jQuery('#password').focus();
        return;
    }
    //alert(base_url + "user/login_new");
    jQuery.post(base_url + "user/login_new", {
        username : uid,
        password : upass
    }, function(response) {
        //alert(response);
        if (response != "1") {
            alert(response);
        } else {
            alert("You are successfully Logged In.");
            window.location.reload();
        }
    });
}

function mainmenu(){
  "use strict";
  jQuery("#main-menu ul:first li").hover(function(){
    jQuery(this).find('ul:first').stop().fadeIn('slow');
  },function(){
    jQuery(this).find('ul:first').stop().fadeOut('fast');
  });
}

function applyIso(){
  "use strict";
  jQuery("div.portfolio-container").css({overflow:'hidden'}).isotope({itemSelector : '.isotope-item'});
}

function animateSkillBars(){
  "use strict";
  var applyViewPort = ( jQuery("html").hasClass('csstransforms') ) ? ":in-viewport" : "";
  jQuery('.progress'+applyViewPort).each(function(){
    var progressBar = jQuery(this),
        progressValue = progressBar.find('.bar').attr('data-value');

    if (!progressBar.hasClass('animated')) {
      progressBar.addClass('animated');
      progressBar.find('.bar').animate({width: progressValue + "%"},600,function(){ progressBar.find('.bar-text').fadeIn(400); });
    }

  });
}

jQuery(document).ready(function(){
  "use strict";
  mainmenu();

  animateSkillBars();

  jQuery(window).scroll(function(){ animateSkillBars(); });

  /* Main Menu */
  jQuery("#main-menu ul li:has(ul)").each(function(){
    jQuery(this).addClass("hasSubmenu");
  });

  /* Mibile Nav */
//  jQuery('#main-menu > ul').mobileMenu({
//    defaultText: 'Navigate to...',
//    className: 'mobile-menu',
//    subMenuDash: '&ndash;&nbsp;'
//  });

});
jQuery(function() {

    jQuery("#create-account-submit").click(function() {
        var fname = jQuery('#fname').val();
        var lname = jQuery('#lname').val();
        var mobile = jQuery('#telephone').val();
        var city = jQuery('#city').val();
        var area = jQuery('#area').val();
        var address = jQuery('#address').val();
        var zipcode = jQuery('#zipcode').val();
        var email = jQuery('#email').val();
        var password = jQuery('#password_reg').val();
        var confirm_password = jQuery('#confirm_password').val();

        if(fname=='' || fname==null){
            alert('First Name can\'t be empty.');
            jQuery('#fname').focus();
            return false;
        }
        if(lname=='' || lname==null){
            alert('Last Name can\'t be empty.');
            jQuery('#lname').focus();
            return false;
        }
        if(mobile=='' || mobile==null){
            jQuery('#telephone').focus();
            alert('Mobile number can\'t be empty.');
            return false;
        }
        if(city=='' || city==null){
            jQuery('#city').focus();
            alert('City can\'t be empty.');
            return false;
        }
        if(area=='' || area==null){
            jQuery('#area').focus();
            alert('Area can\'t be empty.');
            return false;
        }
        /*
        if(zipcode=='' || zipcode==null){
            jQuery('#zipcode').focus();
            alert('Zipcode can\'t be empty.');
            return false;
        }
        */
        if(address=='' || address==null){
            jQuery('#address').focus();
            alert('Address can\'t be empty.');
            return false;
        }
        if(email=='' || email==null){
            jQuery('#email').focus();
            alert('Email can\'t be empty.');
            return false;
        }
        if(password=='' || password==null){
            jQuery('#password_reg').focus();
            alert('Password can\'t be empty.');
            return false;
        }
        if(password!=confirm_password){
            jQuery('#confirm_password').focus();
            alert('Re-enter same password.');
            return false;
        }
        if( !jQuery('#agree_chk').is(':checked') ) {
            alert('You must accept the "Privacy Policy" and "Terms and Conditions"');
            jQuery('#agree_chk').focus();
            return false;
        }

        var newsletter = 0;
        if( jQuery('#newsletter').is(':checked') ) {
            newsletter = 1;
        }

        var dataString = 'customers_firstname='+ fname + '&customers_lastname=' + lname + '&customers_postcode=' + zipcode + '&customers_mobile=' + mobile+ '&customers_town=' + city+ '&cust_area=' + area+ '&customers_address1=' + address+ '&customers_email_address=' + email+ '&customers_password=' + password+ '&confirm_password=' + confirm_password+ '&newsletter=' + newsletter;

        if(fname=='' || lname=='' || mobile==''|| city==''|| area==''|| address==''|| email==''|| password==''|| confirm_password=='')
        {
            $('.success').fadeOut(200).hide();

            //$('.error').fadeOut(200).show();

        }
        else
        {
            jQuery.ajax({
                type: "POST",
                url: base_url + "user/register",
                data: dataString,
                success: function(response){
                    if(response == 1){
                        jQuery('.success').show( 4000, function() {
                            //jQuery("#sign-in-form").fadeOut("normal");
                            jQuery("#register-form").fadeOut("normal");
                            jQuery("#background-on-popup").fadeOut("normal");
                            //window.location = base_url + "registration_success";

                            //    For Auto Login [ Start ]      //
                            jQuery.post(base_url + "user/login_new", {
                                username : email,
                                password : password
                            }, function(response) {
                                //alert(response);
                                if (response != "1") {
                                    alert(response);
                                } else {
                                    alert("You are successfully Logged In.");
                                    //window.location.reload();
                                }
                            });
                            //    For Auto Login [ End ]      //


                        });
                    } else {
                        if( response == "The email address is already registered. Please Login using log in menu option or use \"I have forgotten my password\" option to retrieve your password.")
                        {
                            jQuery('#email').focus();
                            jQuery( "#email" ).addClass( "border-outside" );
                        }
                        if( response == "Your telephone is banned")
                        {
                            jQuery('#telephone').focus();
                            jQuery( "#telephone" ).addClass( "border-outside" );
                        }
                        alert(response);
                    }
                }
            });
        }
        return false;
    });
});

function get_area_list(city_id)
{
    jQuery.ajax({
        type: "POST",
        url: base_url+"customer/get_area_by_city",
        data: "cityid="+city_id,
        success: function(response){
            jQuery('#area_container').html(response);

        }
    });
}


jQuery(function() {
    jQuery("#subscribe_button").click(function() {
        var email = jQuery('#subscribe_email').val();
        if(email=='' || email==null ){
            jQuery('#email').focus();
            alert('Email can\'t be empty.');
            return false;
        }

        if( isEmail(email) ) {
            jQuery.ajax({
                type: "POST",
                url: base_url + "customer/register_subscribe_email",
                data: "subscribe_email="+email,
                success: function(response){
                    if(response == 1){
                        alert("Thank you for subscribing our newsletter");
                    } else {
                        alert(response);
                    }
                }
            });
        } else {
            alert("Please provide a valid email address.");
        }
    });
});

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
