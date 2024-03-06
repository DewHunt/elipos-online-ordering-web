
<!--<a href="#openModal">Open Modal</a>
        
<div id="openModal" class="modalDialog">
<div>	<a href="#close" title="Close" class="close">X</a>
                                
    <h2>Modal Box</h2>
                
<p>This is a sample modal box that can be created using the powers of CSS3.</p>
<p>You could do a lot of things here like have a pop-up ad that shows when your website loads, or create a login/register form for users.</p>
</div>
                </div>-->

<div id="main-contanier">
    <!--Restaurant Carousal Ends-->
    <div id="slideshow">
        <img src="<?= base_url('assets/uploads/banners/f30b8332ec93044cebf993667851b9f7.jpg') ?>" alt="Test"
             class="active"/>
        <img src="<?= base_url('assets/uploads/banners/6292da19c40ae22997f098f58c3cbb31.jpg') ?>" alt="Test 2"/>
    </div>
    <div id="banner_wrap">
        <div id="banner_block">
            <div id="banner_search_area">
                <div class="order_text">
                    <span class="logoradio" for="opt_1">
                        <h1> Welcome to <?php echo get_company_name(); ?> </h1>
                        <h4>Award winning Bangladeshi cuisine</h4>
                    </span>
                    <br/>
                </div>

                <div class="search_panel">
                    <div class="choose_area">
                        <input class="choose_zone_home_small" list="postcode_from_search_list" name="postcode_from_search" id="postcode_from_search" placeholder=" Enter Postcode">
                        <datalist id="postcode_from_search_list">
                            <?php
                            $postcode_by_limit = postcode_by_limit();
                            if (!empty($postcode_by_limit)) {
                                foreach ($postcode_by_limit as $postcode) {
                                    ?>
                                    <option value="<?= $postcode->postcode ?>"><?= $postcode->postcode ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </datalist>

                        <input type="button" class="search_button_home order_type_from_search" order-type="delivery" value="Delivery" id="order_type_delivery_from_search">
                        <input type="button" class="search_button_home order_type_from_search" order-type="collection" value="Collection" id="order_type_collection_from_search">
                    </div>
                    <div class="invalid_postcode_message error-message" style="font-size: 20px">

                    </div>
                    <input type="hidden" name="search_order_option" id="search_order_option" value="1"/>
                </div>

                <script>
                    jQuery('.order_type_from_search').on('click', function (e) {
                        var postcode = jQuery('#postcode_from_search').val();
                        postcode = postcode.trim();
                        var order_type_from_search = jQuery(this).attr('order-type');
                        jQuery.ajax({
                            type: "POST",
                            url: '<?php echo base_url("home/is_valid_postcode") ?>',
                            data: {'postcode': postcode, 'order_type_from_search': order_type_from_search},
                            success: function (data) {
                                if (data != 1) {
                                    //                                    alert(data);
                                    jQuery('.invalid_postcode_message').html(data);
                                    //return false;
                                } else {
                                    window.location.href = '<?php echo base_url("menu") ?>';
                                }
                            },
                            error: function (error) {
                                console.log("error occured");
                            }
                        });
                    });

                </script>

                <div class="banner_add_text">
                    <ul>
                        <li>&bull; Full Free To Use</li>
                        <li>&bull; Direct Connections With The Restaurants</li>
                        <li>&bull; Pay By Cash Or Credit Card</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="welcome_wrap">
        <div id="welcome_block">
            <div class="page_heading">Are You Feeling Hungry? <span class="color_green text_bold">Order Now!</span></div>
            <div class="page_subheading">
                We have a hugh range of fantastic dishes, from mild to spicy to tantilize your taste buds.
            </div>
            <div id="welcome_boxes">
                <div id="welcome_boxes_left">
                    <a href="#"><img src="<?= base_url('assets/images/home-burger.jpg') ?>" alt=""/></a>
                </div>

                <div id="welcome_boxes_right">
                    <div id="welcome_boxes_right_column1">
                        <div id="welcome_boxes_right_column1_adv_show">
                            <a href="#"><img src="<?= base_url('assets/images/home-sushi.jpg') ?>" alt=""/></a>
                        </div>

                        <div id="welcome_boxes_right_column1_adv_show">
                            <a href="#"><img src="<?= base_url('assets/images/home-kfc.jpg') ?>" alt="" class="top_gap"/></a>
                        </div>
                    </div>

                    <div id="welcome_boxes_right_column2">
                        <div id="welcome_boxes_right_column2_adv_show">
                            <a href="#"><img src="<?= base_url('assets/images/home-salsa.jpg') ?>" alt=""/></a>
                        </div>

                        <div id="welcome_boxes_right_column2_adv_show">
                    
                            <a href="<?= base_url('menu')?>"><img src="<?= base_url('assets/images/home-pizza.jpg') ?>" alt="" class="top_gap"/></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="how_it_works_wrap">
        <div id="how_it_works_block">
            <div class="page_heading">How It <span class="color_green text_bold">Works</span></div>
            <div class="page_subheading">
                Ordering from your favorite restaurant is even easier now in this restaurant Just follow these simple
                steps!
            </div>
            <div id="how_it_works_boxes">
                <ul>
                    <li>
                        <div class="works_area">
                            <div class="works_icon"><img src="<?= base_url('assets/images/works-img1.png') ?>"
                                                         alt="How It Works Icon"/>
                            </div>
                            <div class="works_heading">Search Your Location</div>
                            <div class="works_details">Search restaurants in your nearest locations</div>
                            <div class="works_arrow"><img src="<?= base_url('assets/images/works-arrow.png') ?>" alt=""/></div>
                        </div>
                    </li>

                    <li>
                        <div class="works_area">
                            <div class="works_icon"><img src="<?= base_url('assets/images/works-img2.png') ?>" alt="How It Works Icon"/>
                            </div>
                            <div class="works_heading">Choose Your Restaurant &amp; Menu</div>
                            <div class="works_details">Avoid awkward phone calls, Just select a restaurant and food in
                                your cart
                            </div>
                            <div class="works_arrow">
                                <img src="<?= base_url('assets/images/works-arrow.png') ?>" alt=""/>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="works_area">
                            <div class="works_icon">
                                <img src="<?= base_url('assets/images/works-img3.png') ?>" alt="How It Works Icon"/>
                            </div>
                            <div class="works_heading">Pay With Cash Or Card</div>
                            <div class="works_details">Pay Cash on Delivery or pay via credit/debit cards</div>
                            <div class="works_arrow">
                                <img src="<?= base_url('assets/images/works-arrow.png') ?>" alt=""/>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="works_area">
                            <div class="works_icon">
                                <img src="<?= base_url('assets/images/works-img4.png') ?>" alt="How It Works Icon"/>
                            </div>
                            <div class="works_heading">Pickup Or Delivery</div>
                            <div class="works_details">Food is ready to pickup or delivered to your home!</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="apps_download_wrap">
        <div id="apps_download_block">
            <div class="page_heading">Why not order food on the go  <span class="color_green text_bold">with our App </span></div>
            <div class="page_subheading">
                We are trying hard to prepare iphone and android Apps for you, Bombay Joe's online food ordering app will
                be available in appstore soon!
            </div>
            <div class="apps_mobile_pic">
                <img src="<?= base_url('assets/images/apps-mobile.png') ?>" alt=""/>
            </div>
            <div class="apps_texts_area">
                <div class="apps_texts">
                    <img src="<?= base_url('assets/images/coming-soon-home.png') ?>" alt=""/>
                </div>
                <div class="apps_buttons">
                    <a href="#"><img src="<?= base_url('assets/images/button-apps-store.png') ?>" alt=""/></a>
                    <a href="#"><img src="<?= base_url('assets/images/button-android.png') ?>" alt=""/></a>
                </div>
            </div>
        </div>
    </div>

    <!--Scroll To Top-->
    <a href="#main_container" class="typtipstotop"></a>
    <!--Scroll To Top-->

    <div id="subscribe_wrap">
        <div id="subscribe_block">
            <div id="subscribe_block_left">
                <div class="subscribe_area_heading">Subscribe To Our <span
                        class="color_green text_bold">Newsletter</span></div>
                <div class="subscribe_area_details">
                    If you did like to stay updated with all our latest offers and deals, please enter your emaill
                    address below:
                </div>

                <div id="subscribe_block_form">
                    <ul>
                        <li>
                            <input type="text" placeholder="Enter Your Email" value="" name="subscribe_email"
                                   id="subscribe_email" class="subscribe_input">
                        </li>
                        <li>
                            <input type="button" value="Subscribe Now" class="subscribe_button" id="subscribe_button"
                                   name="subscribe_button">
                        </li>
                    </ul>
                </div>
            </div>

            <div id="subscribe_block_right">
                <div class="subscribe_area_heading">Our Delivery <span class="color_green text_bold">Partner</span>
                </div>
                <div class="subscribe_area_details">
                    Always on customer's door within shortest possible time on receipt of information over e-mail,
                    phone, fax or walk-in visit
                </div>

                <div id="delivery_partner_image_area">
                    <img src="<?= base_url('assets/images/ixpress-logo.png') ?>" alt="" class=""/>
                </div>
            </div>
        </div>
    </div>
    <!--Scroll To Top-->
    <a href="#" class="typtipstotop"></a>
    <!--Scroll To Top-->  
</div>






