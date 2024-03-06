<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content">
                <h1 class="text-color">Info For Restaurant</h1>

                <div class="cmspage_content_left">
                    <h2>Coming soon...</h2>
                </div>

                <div class="cmspage_content_right">
                    <img src="<?= base_url('assets/images/info-for-restaurant.png') ?>" alt=""/>
                </div>

            </div>
        </div>
    </div>

    <!--Scroll To Top-->
    <a href="#" class="typtipstotop"></a>
    <!--Scroll To Top-->
    <script language="javascript">

        function subscriber_validation() {

            return false;

        }


        function newsletter(url, type) {

            if (echeck(document.subscriber.subscriber_email.value) == false) {

                document.subscriber.subscriber_email.value = '';

                document.subscriber.subscriber_email.focus();

            }

            else {

                var email = document.subscriber.subscriber_email.value;


                $.post(url,

                    {

                        email: email,

                        type: type,

                        url: url

                    },

                    function (data) {

                        $('#response1').html(data);

                        document.subscriber.subscriber_email.value = '';

                    });

            }

        }


        /*function searchvalidation()

         {

         if (document.searchpost.PCD.value == "" || document.searchpost.PCD.value == "Enter Post Code" )

         {

         alert("Post Code Needed.");

         document.searchpost.PCD.focus();

         return false;

         }



         return true;



         }*/

    </script>

    <!--Scroll To Top-->

    <a href="#" class="typtipstotop"></a>

    <!--Scroll To Top-->

    <!-- Start Login/Register Form -->

    <div id="background-on-popup"></div>

    <div>

        <!-- Start Signin Form -->

        <div id="sign-in-form" method="post">

            <div class="close"></div><!-- close button of the sign in form -->

            <ul id="form-section">

                <li>

                    <label>

                        <span>Username</span>

                        <input placeholder="Enter your username" name="username" id="username"
                               pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$" type="text" tabindex="1"
                               title="It must contain the username that you have chosen at registration" required
                               autofocus>

                    </label>

                </li>

                <li>

                    <label>

                        <span>Password</span>

                        <input placeholder="Enter your password" name="password" id="password" pattern=".{6,}"
                               type="password" tabindex="2"
                               title="It must contain the password that you have chosen at registration" required>

                    </label>

                </li>

                <div id="checkbox">

                    <label class="rem-me"><a href="../user/forgotpassword.html" target="_blank" id="forgot-passwd">Forgot
                            password?</a></label>

                </div>

                <!--<div id="checkbox">

                    <li>

                        <input name="remember-me" type="checkbox" id="remember-me"/>

                        <span class="unchecked-state"></span>

                        <span class="checked-state"></span>

                    </li>

                    <label for="remember-me" class="rem-me">Remember me next time</label>

                </div>-->

                <li>

                    <button name="sign-in-submit" type="submit" id="sign-in-submit" onclick="pop_up_login();">Sign In
                    </button>

                </li>

                <!--<li>

                    <label class="left-column">

                        <input type="button" class="facebook-login" value="Login with Facebook">

                    </label>

                    <label class="right-column">

                        <input type="button" class="google-login" value="Login with Google">

                    </label>

                </li>-->

                <div style="clear: both;"></div>

            </ul>

        </div>

        <!-- End Signin Form -->

        <!-- Start Register Form -->

        <div id="register-form">

            <form action="#" method="post">

                <div class="close"></div><!-- close button of the register form -->

                <ul id="form-section1">

                    <p><span class="register-numbering">1</span><span
                            class="register-numbering-text">Basic Information</span></p>

                    <li>

                        <span class="success" style="display:none; color:#0C0">Your registration has been completed. Please check your email for further details.</span>

                    </li>

                    <li>

                        <label class="left-column">

                            <span>First Name<font class="fontcolor-red">*</font></span>

                            <input type="text" name="fname" id="fname" tabindex="1" pattern="[a-zA-Z ]{2,}"
                                   placeholder="Enter your first name" required autofocus
                                   title="It must contain only letters and a length of minimum 2 characters!">

                        </label>

                        <label class="right-column">

                            <span>Last Name<font class="fontcolor-red">*</font></span>

                            <input type="text" name="lname" id="lname" tabindex="2" pattern="[a-zA-Z ]{2,}"
                                   placeholder="Enter your last name"
                                   title="It must contain only letters and a length of minimum 2 characters!" required>

                        </label>

                    </li>

                    <div style="clear: both;"></div>

                    <li>

                        <label>

                            <span>Mobile<font class="fontcolor-red">*</font></span>

                            <input type="tel" name="telephone" id="telephone" pattern="(\+?\d[- .]*){7,13}" tabindex="4"
                                   placeholder="Enter your phone number"
                                   title="It must contain a valid phone number formed only by numerical values and a length between 7 and 13 characters !"
                                   required>

                        </label>

                    </li>

                    <p><span class="register-numbering">2</span><span
                            class="register-numbering-text">Location Details</span></p>

                    <li>

                        <label>

                            <span>Address<font class="fontcolor-red">*</font></span>

                            <input type="text" name="address" id="address" tabindex="5" pattern="[a-zA-Z0-9. - , ]{10,}"
                                   placeholder="Enter your street address"
                                   title="It must contain letters and/or separators and a length of minimum 10 characters !"
                                   required>

                        </label>

                    </li>

                    <li>

                        <label class="left-column">

                            <span>City<font class="fontcolor-red">*</font></span>

                            <select name="city" id="city" tabindex="6" onchange="get_area_list(this.value);">


                                <option value="1">

                                    Dhaka
                                </option>


                            </select>

                        </label>

                    </li>

                    <script>
                        jQuery(document).ready(function () {
                            get_area_list(jQuery('#city').val());
                        });
                    </script>

                    <li>

                        <label class="right-column">

                            <span>Area<font class="fontcolor-red">*</font></span>

                            <div id="area_container">

                                <select name="area" id="area" tabindex="7">


                                </select>

                            </div>

                        </label>

                    </li>

                    <li>

                        <label class="left-column">

                            <span>Post Code<font class="fontcolor-red"></font></span>

                            <input type="text" name="zipcode" id="zipcode" tabindex="8" maxlength="7"
                                   onkeyup="jQuery(this).val(jQuery(this).val().toUpperCase());"
                                   placeholder="Enter your Post Code"
                                   title="It must contain only numbers and a length of minimum 3 characters !">

                        </label>

                    </li>


                    <div style="clear: both;"></div>

                    <p><span class="register-numbering">3</span><span class="register-numbering-text">Account Credentials</span>
                    </p>

                    <li>

                        <label>

                            <span>Email<font class="fontcolor-red">*</font></span>

                            <input type="email" name="email" id="email" tabindex="6"
                                   placeholder="Enter a valid email address"
                                   title="It must contain a valid email address e.g. 'someone@provider.com' !" required>

                        </label>

                    </li>

                    <li>

                        <label class="left-column">

                            <span>Password<font class="fontcolor-red">*</font></span>

                            <input type="password" name="password" id="password_reg" tabindex="7" pattern=".{6,}"
                                   placeholder="Enter password"
                                   title="It can contain all types of characters and a length of minimum 6 characters!"
                                   required>

                        </label>

                        <label class="right-column">

                            <span>Confirm Password<font class="fontcolor-red">*</font></span>

                            <input type="password" name="confirm_password" id="confirm_password" tabindex="8"
                                   pattern=".{6,}" placeholder="Confirm password"
                                   title="It can contain all types of characters and a length of minimum 6 characters!"
                                   required>

                        </label>

                    </li>

                    <div style="clear: both;"></div>

                    <li>
                        <label><span>
                        <input type="checkbox" name="agree_chk" id="agree_chk" style="margin-right: 1%;">I Agree to
                        <a href="../user/page/Privacy%20Policy.html" target="_blank">Privacy Policy</a>
                        and
                        <a href="../user/page/Terms.html" target="_blank">Terms and Conditions</a>
                    </span></label>
                    </li>

                    <li>
                        <label><span>
                        <input type="checkbox" name="newsletter" id="newsletter" style="margin-right: 1%;" checked>I would like to receive newsletter
                    </span></label>
                    </li>

                    <div style="clear: both;"></div>

                    <li>

                        <button name="submit" tabindex="11" type="submit" id="create-account-submit">Create Account
                        </button>

                    </li>

                </ul>

            </form>

            <ul id="regi_thanks_box">

                <li>

                    <label>

                        Your registration has been completed. Please check your email for further details.

                    </label>

                </li>

            </ul>

        </div>

        <!-- End Register Form -->

    </div>

    <!-- End Login/Register Form -->
</div>


<script type="text/javascript">
    function subscribe(value) {
        if (value === 'subscribe_button') {
            var username = jQuery('#sub_mail').val();
            var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
            if (username == '' || username == 'Enter Your Email') {
                alert('Please enter your email in the input field');
                jQuery('#sub_mail').focus();
                return false;
            }
            else if (reg.test(username) == false) {
                alert("Please enter valid email address");
                jQuery('#sub_mail').focus();
                return false;
            }
            else {

                $.post('../user/subscribe.html', {email: username}, function (response) {
                    //alert(response)
                    if (response === '1') {
                        jQuery('#footersuccess').show().html("Subscribed Successfully!").css("color", "#42B000");
                        jQuery('#sub_mail').val('');
                    }
                    else {
                        jQuery('#footersuccess').show().html("Already Subscribed!").css("color", "#FFA500");
                    }
                });
            }
        }
        else {
            alert('Unrecognised request. Please try again later');
        }
    }
</script>
