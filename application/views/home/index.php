<?php
    //$companyDetails = get_company_details();
    //dd($companyDetails);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= !empty($title) ? $title : ''; ?></title>
        <link title="favicon" rel="icon" href="<?= base_url('assets/'.get_property_value('favicon', $companyDetails)) ?>"/>
        <!-- custom-theme -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="" />
        <script type="application/x-javascript">
            addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); }
        </script>
        <link rel="shortcut icon" type="image/png" href="images/favicon.png"/>
        <link rel="stylesheet" href="<?= base_url('assets/theme/') ?>css/lightbox.css">

        <!-- //custom-theme files-->
        <link href="<?= base_url('assets/theme/') ?>css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= base_url('assets/theme/') ?>css/aos.css" rel="stylesheet" type="text/css" media="all" /><!-- //animation effects-css-->

        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/') ?>css/bootstrap.css" type="text/css" media="all">


        <link href="<?= base_url('assets/theme/') ?>css/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= base_url('assets/theme/') ?>css/custom-navbar.css" rel="stylesheet" type="text/css" media="all" />
        <!-- //custom-theme files-->

        <!-- font-awesome-icons -->
        <link href="<?= base_url('assets/theme/') ?>css/font-awesome.css" rel="stylesheet">
        <!-- //font-awesome-icons -->

        <!-- googlefonts -->
        <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet">
        <!-- //googlefonts -->
        <!-- Facebook Pixel Code -->
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq)
                    return;
                n = f.fbq = function () {
                    n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq)
                    f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }
            (window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '484075842047418');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=484075842047418&ev=PageView&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <style>
            .ui-datepicker .ui-datepicker-header { background: #10636B !important; }
            .ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
                border: 1px solid #10636B !important;
            }
            .ui-state-default:hover, .ui-widget-content .ui-state-default:hover, .ui-widget-header .ui-state-default:hover {
                color: #10636B !important;
            }
            .error{ color: red !important; }
            html, body { font-size: 100%; font-family: sans-serif; background: #ffffff; margin: 0; }
            h1, h2, h3, h4, h5, h6 { margin: 0; font-family: sans-serif; }
            .contact .contact-left{ min-height: 595px; }
            .contact .contact-right{ min-height: 595px; }
            .height-all img { height: 382px; }
            @media (max-width: 575px) {
                .w3layouts-banner-top, .w3layouts-banner-top1 {
                    background-position: center;
                    background-size: 100% auto;
                    max-width: 100%;
                    height: auto;
                    transform: translate(0%, 0%);
                }
                .callbacks_container { height: 305px; }
                .height-all img { height: auto; }
            }
            @media only screen and (min-device-width: 768px) and (max-device-width: 1023px) and (
                -webkit-min-device-pixel-ratio: 1) { .modal-dialog { margin-top: 37% !important; }
            }
            @media only screen and (min-width: 1024px) and (max-height: 1366px) and (
                -webkit-min-device-pixel-ratio: 1.5) { .modal-dialog { margin-top: 29%; }
            }
            @media only screen and (min-device-width: 320px) and (max-device-width: 568px)and (
                -webkit-min-device-pixel-ratio: 2) { .modal-dialog { margin-top: 46%; }
            }
            @media only screen and (min-device-width : 375px) and (max-device-width : 812px)and (
                -webkit-device-pixel-ratio : 3) { .modal-dialog { margin-top: 68%; }
            }
            @media only screen and (min-device-width : 375px) and (max-device-width : 667px) {
                .modal-dialog { margin-top: 68%; }
            }
            @media only screen and (min-device-width: 375px) and (max-device-width: 812px) and (
                -webkit-min-device-pixel-ratio: 3) { .modal-dialog { margin-top: 80%; }
            }
            .navbar-collapse {
                -ms-flex-preferred-size: 100%;
                flex-basis: 100%;
                -webkit-box-flex: 1;
                -ms-flex-positive: 1;
                flex-grow: 0;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
            }
            @media (min-width: 768px) {
              .navbar-nav { margin: 7.5px -15px; }
            }
            .custom-logo { width: 250px; }
        </style>
    </head>

    <body>
        <!-- header -->
        <header class="navbar-fixed-top">
            <?php $this->load->view('home/header', $this->data); ?>
        </header>
        <!-- //header -->

        <!-- banner -->
        <?php $this->load->view('home/banner_slider') ?>
        <!-- //banner -->

        <!-- about -->
        <?php $this->load->view('home/promo_modal'); ?>

        <div class="about" id="about">
            <div class="container">
                <div class="heading"><h2 data-aos="zoom-in">About Us</h2></div>
                <h4>About our restaurant food</h4>
                <div class="text-center">
                    <p>
                        The Streetly Balti was established in Streetly, Sutton Coldfield in September 1993. It was the formation of a partnership between three brothers Jamal, Imam, and Shab. The menu was the conception of Imam Uddin and is now being continued and updated by current Head Chef, Rayhan. 
                    </p>
                    <a href="https://streetlybalti.co.uk/menu" class="btn btn-lg btn-primary">
                        <i class="fa fa-hand-o-up" ></i>&nbsp;Order Online
                    </a>
                </div>
                <div class="about-grids" style="display: flex; flex-wrap: wrap;">
                    <div data-aos="zoom-in" class="col-md-4 aboutgrid1 ">
                        <h3>Indian food is</h3>
                        <p> still one of the nation's most popular types of food due to its diverse use of flavours provided by the utilisation of fresh herbs and spices. Each region of India has its own style of cooking and distinct flavours. </p>
                    </div>
                    <div  data-aos="flip-right" class="col-md-4 aboutgrid2 height-all">
                        <img src="<?= base_url('assets/theme/') ?>images/about1.jpg" alt=""/>
                    </div>
                    <div data-aos="zoom-in" class="col-md-4 aboutgrid3">
                        <h3>The North is</h3>
                        <p> known for its tandoori and korma dishes; the South is famous for hot and spicy foods; the East specialises in chilli curries; and the West uses coconut and seafood, whereas the Central part of India is a blend of all.  </p>
                    </div>
                    <div class="clearfix"></div>
                    <div  data-aos="flip-right" class="col-md-4 aboutgrid4 height-all">
                        <img src="<?= base_url('assets/theme/') ?>images/about2.jpg" alt=""/>
                    </div>
                    <div data-aos="slide-up" class="col-md-4 aboutgrid5">
                        <h3>Spices are </h3>
                        <p> unquestionably the cornerstone of Indian cooking and are widely cultivated worldwide. At Streetly Balti we aim to delight and tantalise you with the flavours from the most diverse Sub-Continent. </p>
                    </div>
                    <div  data-aos="flip-right" class="col-md-4 aboutgrid6 height-all">
                        <img src="<?= base_url('assets/theme/') ?>images/about3.jpg" alt=""/>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- //about -->

        <!-- services -->
        <style>
            @media only screen 
            and (min-device-width: 768px) 
            and (max-device-width: 1024px) 
            and (-webkit-min-device-pixel-ratio: 1) {
                .col-md-6 { -webkit-box-flex: 0; -ms-flex: 0 0 50%; flex: 0 0 50%; max-width: 100%; }
                .col-md-4 { -webkit-box-flex: 0; -ms-flex: 0 0 33.333333%; flex: 0 0 33.333333%; max-width: 100%; }
            }
        </style>

        <div class="services" id="services">
            <div class="container">
                <div class="heading"><h3 data-aos="zoom-in">Our Services</h3></div>
                <div class="w3-agileits-services-grids">
                    <div data-aos="fade-down" class="col-md-6 agile-services-left">
                        <div class="agile-services-left-grid">
                            <div class="services-icon">
                                <div class="col-md-4 services-icon-info">
                                    <a class="page-scroll scroll" href="#table">  <i class="fa fa-cutlery" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-8 services-icon-text">                           
                                    <h5>DINE IN</h5>
                                    <!--  <h5><a class="page-scroll scroll" href="#table">DINE IN</a></h5> !-->
                                    <p>Reserve your table now and relax, let us put a smile back on your face.  </p>
                                    <p>0121 353 2224  </p>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="services-icon">
                                <div class="col-md-4 services-icon-info">
                                    <a class="nav-link" href="<?= base_url('menu') ?>">   <i class="fa fa-car" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-8 services-icon-text">
                                    <h5>HOME DELIVERY</h5>
                                    <p>No need to to cook or stress about dinner, just order online or call us, and we will bring you a piping hot curry to your door.</p>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="services-icon">
                                <div class="col-md-4 services-icon-info">
                                    <a class="page-scroll scroll" href="#contact">    <i class="fa fa-spoon" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-8 services-icon-text">
                                    <h5>OUTDOOR CATERING SERVICE</h5>
                                    <p>Planning a home celebration, don’t worry, just give Streetly Balti a call and we will take care of the rest. Whether it’s for 50 people or 500 people we will make your guests feel like kings.</p>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                    </div>
                    <div class="col-md-6 w3-agile-services-right">
                        <div data-aos="zoom-in" class="col-md-6 service1">
                            <img src="<?= base_url('assets/theme/') ?>images/c1.jpg" alt=""/>
                        </div>
                        <div data-aos="zoom-in" class="col-md-6 serviceimg">
                            <img src="<?= base_url('assets/theme/') ?>images/homedelivery.jpg" alt="" style="margin: 0em 0;"/>
                            <img src="<?= base_url('assets/theme/') ?>images/service2.jpg" alt="" style="margin: 1em 0;"/>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
        <!-- //services -->

        <!-- Inside Menu -->
        <div class="inside-menu" id="inside-menu" style="padding: 4em 0 2em;">
            <?php $this->load->view('home/inside_menu', $this->data); ?>
        </div>
        <!-- //Inside Menu -->

        <!-- gallery new -->
        <div class="gallery-new" id="food">
            <div class="heading"><h3 data-aos="zoom-in">Our Food</h3></div>
            <div class="gallery-grids">
                <div data-aos="flip-right" class="col-md-3 gallery-grid">
                    <div class="grid">
                        <figure class="effect-roxy">
                            <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery1.jpg" data-lightbox="example-set" data-title="Whole large pepper stuffed with spicy miced lamb and cook in tandoor" >
                                <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery1.jpg" alt="" />
                                <figcaption>
                                    <h3> Stuffed<span> Pepper </span></h3>
                                    <p>Whole large pepper stuffed with spicy miced lamb and cook in tandoor </p>
                                </figcaption>
                            </a>
                        </figure>
                    </div>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery2.jpg" data-lightbox="example-set" data-title="Small triangular packers with crispy party filled with spicy vegetables">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery2.jpg" alt="" />
                            <figcaption>
                                <h3>Machli <span>Kabab</span></h3>
                                <p>Chunky Fillets of Cod, marinated in tandoori spices and sizzled to perfection on the Tawa.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery3.jpg" data-lightbox="example-set" data-title="Small lentil fritters, crispy fried with onion and hot red chilli. Daali bora are quintessential comfort food.">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery3.jpg" alt="" />
                            <figcaption>
                                <h3>Daali <span>Bora</span></h3>
                                <p>Small lentil fritters, crispy fried with onion and hot red chilli. Daali bora are quintessential comfort food.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery4.jpg" data-lightbox="example-set" data-title="Fresh baby leaf spinach deep fried in a cripy crunchy batter, topped up with tangy tamrind and yoghurt, finished with sweet pomegranates">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery4.jpg" alt="" />
                            <figcaption>
                                <h3>Pata <span>Chatt</span></h3>
                                <p>Fresh baby leaf spinach deep fried in a cripy crunchy batter, topped up with tangy tamrind and yoghurt, finished with sweet pomegranates</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery5.jpg" data-lightbox="example-set" data-title="The finest ingredients expertly cooked in a blend of exotic herbs and spices with tomato, onion, capsicum, garlic and coriander.">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery5.jpg" alt="" />
                            <figcaption>
                                <h3>King Prawn <span>Balti</span></h3>
                                <p>The finest ingredients expertly cooked in a blend of exotic herbs and spices with tomato, onion, capsicum, garlic and coriander.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery6.jpg" data-lightbox="example-set" data-title="A popular roadside snack from sub continent India. The Indian Hash Brown, with added spice ! Flavoursome, Simple and yet so tasty !">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery6.jpg" alt="" />
                            <figcaption>
                                <h3>Aloo  <span>Tikki</span></h3>
                                <p>A popular roadside snack from sub continent India. The Indian Hash Brown, with added spice ! Flavoursome, Simple and yet so tasty ! </p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery7.jpg" data-lightbox="example-set" data-title="Pieces of spring chicken marinated and roasted and cooked in special mild masala sauce.">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery7.jpg" alt="" />
                            <figcaption>
                                <h3>Chicken Tikka <span>Massala</span></h3>
                                <p>Pieces of spring chicken marinated and roasted and cooked in special mild masala sauce.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery8.jpg" data-lightbox="example-set" data-title="Cooked with an authentic Bangladeshi citrus fruit called the shatkora, this is a very tasty dish with a citrus zing and a touch of chilli.">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery8.jpg" alt="" />
                            <figcaption>
                                <h3>Gosht <span>Shatkora</span></h3>
                                <p>Cooked with an authentic Bangladeshi citrus fruit called the shatkora, this is a very tasty dish with a citrus zing and a touch of chilli.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery9.jpg" data-lightbox="example-set" data-title="Delicious, eaten warm, naans are ideally served as a side dish to your favourite balti.">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery9.jpg" alt="" />
                            <figcaption>
                                <h3>Naan <span>Bread</span></h3>
                                <p>Delicious, eaten warm, naans are ideally served as a side dish to your favourite balti.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery10.jpg" data-lightbox="example-set" data-title="Red Spinach is famous for being the powerhouse of iron, vitamins, minerals, proteins, carbohydartes and fibres. This leafy vegetable is gluten free and hence a good diet supplement for people with liver problems.The perfect accompaniment to any Indian dinner table.">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery10.jpg" alt="" />
                            <figcaption>
                                <h3>Lal <span>Sag</span></h3>
                                <p>Red Spinach is famous for being the powerhouse of iron, vitamins, minerals, proteins, carbohydartes and fibres. This leafy vegetable is gluten free and hence a good diet supplement for people with liver problems.The perfect accompaniment to any Indian dinner table.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery11.jpg" data-lightbox="example-set" data-title="Whether eaten as a snack, main meal or even for breakfast, this tangy chickpea curry is arguably the most popular vegetarian dish in India">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery11.jpg" alt="" />
                            <figcaption>
                                <h3>Chana <span>Bhaji</span></h3>
                                <p>Whether eaten as a snack, main meal or even for breakfast, this tangy chickpea curry is arguably the most popular vegetarian dish in India.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-3 gallery-grid">
                <div class="grid">
                    <figure class="effect-roxy">
                        <a class="example-image-link" href="<?= base_url('assets/theme/') ?>gallery-images/gallery12.jpg" data-lightbox="example-set" data-title="Light, tender and fluffy basmati rice every time.">
                            <img src="<?= base_url('assets/theme/') ?>gallery-images/gallery12.jpg" alt="" />
                            <figcaption>
                                <h3>Rice <span></span></h3>
                                <p>Light, tender and fluffy basmati rice every time. </p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
            </div>
        </div>
        <!--//gallery new-->

        <!-- gallery -->
        <!--div class="gallery" id="food">
            <div class="heading">
                <h3 data-aos="zoom-in" >Our Food</h3>
            </div>

        <?php
        $product_object = new Product();
        $categories = $product_object->get_categories();
        $dealsCategories = $product_object->get_deals_categories();

    //            $products = $product_object->get_products();
        $products = $product_object->get_products_by_sort_order(12);
        $all_sub_products = $product_object->get_all_sub_products();
        ?>
            <div class="gallery-grids">

        <?php
        $countProduct = 1;
        foreach ($products as $product) {
            $allSubProducts = $product_object->getSubProductsByProductId($all_sub_products, $product->foodItemId);
            $hasSubProduct = (empty($allSubProducts)) ? false : true;

            if ($hasSubProduct) {
                $countSubProduct = 1;
                foreach ($allSubProducts as $subProduct) {
                    if ($countSubProduct <= 12) {
                        $number = rand(1, 12);
                        $this->load->view('home/product', array(
                            'name' => $subProduct->selectiveItemName,
                            'imageUrl' => base_url('assets/theme/images/food' . $number . '.jpg'),
                            'description' => $product->description
                        ));
                    }
                    $countSubProduct++;
                }
            } else {
                if ($countProduct <= 12) {
                    $number = rand(1, 12);
                    $this->load->view('home/product', array(
                        'name' => $product->foodItemName,
                        'imageUrl' => base_url('assets/theme/images/food' . $number . '.jpg'),
                        'description' => $product->description
                    ));
                }
                $countProduct++;
                ?>

            <?php
        }
    }
    ?>
                <div class="clearfix"> </div>
            </div>
        </div-->
        <!-- //gallery -->

        <!-- //christmas-menu -->
        <style>
            .recipes-w3l-agile { padding: 6em 0 3em 0; }
            #title{ display: none; }
        </style>
        <!--div id="christmas" style="overflow: hidden;">
                  <div class="recipes-w3l-agile">
                      <div class="container">
                          <div class="menucontentarea">   
                              <h3 class="tittle" style="text-transform: uppercase;">Valentine’s Day</h3>
                              <a rel="chrismas-menu" href="<?= base_url('assets/images/home-welcome/Streetly-Balti.png') ?>" title="">
                                <img style="width: 100%; margin-bottom: 2px;" alt="" src="<?= base_url('assets/images/home-welcome/Streetly-Balti.png') ?>"></a> 
        <!-- a rel="chrismas-menu" href="https://thelodgerestaurant.co.uk/assets/images/The Lodge Christmas Menu -2.png" title="">
           <img style="width: 100%;" alt="" src="https://thelodgerestaurant.co.uk/assets/images/The Lodge Christmas Menu -2.png" /></a-->
        <style>
        </style>
    </div>

    <div class="clearfix"> </div>

    <!-- book your table -->
    <div class="reservation-w3laits reservation-block" id="table">
        <?php
            $m_customer = new Customer_Model();

            $customer = null;
            if ($m_customer->customer_is_loggedIn()) {
                $customer_id = $m_customer->get_logged_in_customer_id();
                $customer = $m_customer->get($customer_id);
            }
        ?>

        <div class="container">
            <h3 class="tittle">BOOK YOUR TABLE</h3>
            <div class="agile-reservation">
                <div class="col-md-4 agile-reservation-grid">
                    <img src="<?= base_url('assets/theme/') ?>images/r1.jpg" alt=" " class="img-responsive img-style row2">
                </div>
                <div class="col-md-4 agile-reservation-grid  mid-w3l-aits  reservation-form-block">
                    <div class="book-form" style="margin: 0">

                        <form id="reservation_form" action="<?= base_url('reservation/save_reservation'); ?>" method="post" name="save_reservation_form">
                            <div class="phone_email col-xs-12 col-sm-12 col-md-6">
                                <label>Full Name : </label>
                                <div class="form-text">
                                    <span class="fa fa-user" aria-hidden="true"></span>
                                    <input type="text" name="name" placeholder="Name" value="<?= get_customer_full_name($customer) ?>">
                                </div>
                            </div>
                            <div class="phone_email phone_email1">
                                <label>Email : </label>
                                <div class="form-text">
                                    <span class="fa fa-envelope" aria-hidden="true"></span>
                                    <input type="email" id="resemail" name="email" placeholder="Email" value="<?= get_property_value('email', $customer) ?>">
                                </div>
                            </div>
                            <div class="phone_email">
                                <label>Phone Number : </label>
                                <div class="form-text">
                                    <span class="fa fa-phone" aria-hidden="true"></span>
                                    <input type="text" name="mobile" placeholder="Phone no" value="<?= get_property_value('phone', $customer) ?>">
                                </div>
                            </div>
                            <div class="phone_email phone_email1">
                                <label>Address : </label>

                                <?php
                                    $billing_address_line_1 = get_property_value('billing_address_line_1', $customer);
                                    $delivery_address_line_1 = get_property_value('delivery_address_line_1', $customer);
                                    $address = (!empty($billing_address_line_1)) ? $billing_address_line_1 : $delivery_address_line_1;
                                ?>

                                <div class="form-text">
                                    <span class="fa fa-map-marker" aria-hidden="true"></span>
                                    <input type="text" name="address" placeholder="Your Address" value="<?= $address ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="agileits_reservation_grid">
                                <div class="span1_of_1">
                                    <label>Date : </label>
                                    <div class="book_date">
                                        <span class="fa fa-calendar" aria-hidden="true"></span>
                                        <input class="datepicker" id="datepicker" type="text" name="reservation_date" placeholder="dd/mm/yyyy" required="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="span1_of_1">
                                    <!-- start_section_room -->
                                    <label>Time : </label>
                                    <div class="section_room">
                                        <div class="form-inline">
                                            <select id="start_time_hr" name="start_time_hr" class="form-control ">
                                                <?php for ($i = 5; $i <= 10; $i++) { ?>
                                                    <option name="start_time_hr" value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                                                <?php } ?>
                                            </select>
                                            <select id="start_time_min" name="start_time_min" class="form-control">
                                                <option name="start_time_min" value="00">00</option>
                                                <option name="start_time_min" value="15">15</option>
                                                <option name="start_time_min" value="30">30</option>
                                                <option name="start_time_min" value="45">45</option>
                                            </select>
                                            <select id="start_time_am_pm" name="start_time_am_pm" class="form-control">
                                                <option name="start_time_am_pm" value="PM">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span1_of_1">
                                    <label>No.of People : </label>
                                    <!-- start_section_room -->
                                    <div class="section_room">
                                        <input class="form-control" type="number" id="country1" name="number_of_guest" placeholder="Number of guests" min="1">
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="span1_of_1">
                                    <label for="note"> Allergens / Special Instructions</label>
                                    <!-- start_section_room -->
                                    <div class="section_room">
                                        <textarea class="form-control" type="text" id="note" name="booking_purpose" placeholder="Notes" ></textarea>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <input class="booking-button" type="submit" value="Book Now">
                            <img style="display: none; float: right; width: 50px;" class="booking-small-loader" src="<?= base_url('assets/images/loader.gif'); ?>" alt="" title="">
                            <div class="reservation-message"></div>
                        </form>
                    </div>
                    <div class="reservation-form-error-block"></div>
                </div>

                <div class="col-md-4 agile-reservation-grid">
                    <img src="<?= base_url('assets/theme/') ?>images/r2.jpg" alt=" " class="img-responsive img-style row2">
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <!-- //book a table -->

    <!-- testimonial -->
    <div class="testimonial"  id="testimonials">
        <div class="container">
            <h3 class="tittle">Testimonials</h3>
            <div class="row" style="margin-left: 10%;margin-right: 10%;">
                <div  class="">
                    <div id="TA_selfserveprop991" class="TA_selfserveprop"><ul id="nLjtQGyrkav" class="TA_links 9S4UK7"><li id="CB5Jrnxlk" class="zILYxE"><a target="_blank" href="https://www.tripadvisor.co.uk/"><img src="https://www.tripadvisor.co.uk/img/cdsi/img2/branding/150_logo-11900-2.png" alt="TripAdvisor"/></a></li></ul></div><script async src="https://www.jscache.com/wejs?wtype=selfserveprop&amp;uniq=991&amp;locationId=916546&amp;lang=en_UK&amp;rating=true&amp;nreviews=5&amp;writereviewlink=true&amp;popIdx=true&amp;iswide=false&amp;border=true&amp;display_version=2" data-loadtrk onload="this.loadtrk = true"></script>
                </div>

                <div class="">
                    <div id="TA_cdswritereviewlg177" class="TA_cdswritereviewlg"><ul id="he6yN6mof" class="TA_links 9Y3ighb65vF"><li id="NB5yBrvx8" class="Jxb2je8ME"><a target="_blank" href="https://www.tripadvisor.co.uk/"><img src="https://www.tripadvisor.co.uk/img/cdsi/img2/branding/medium-logo-12097-2.png" alt="TripAdvisor"/></a></li></ul></div><script async src="https://www.jscache.com/wejs?wtype=cdswritereviewlg&amp;uniq=177&amp;locationId=916546&amp;lang=en_UK&amp;lang=en_UK&amp;display_version=2" data-loadtrk onload="this.loadtrk = true"></script>
                </div>
            </div>
        </div>
    </div>
    <!-- //testimonial -->

    <!-- contact -->
    <div class="contact" id="contact">
        <div class="container">
            <div class="heading"><h3 data-aos="zoom-in" >Get In Touch</h3></div>
        </div>
        <div class="w3layouts-grids">
            <div data-aos="flip-left" class="col-md-6 contact-left">
                <h3 data-aos="zoom-in">Contact information</h3>
                <div class="contact-info">
                    <div class="contact-info-left">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                    </div>
                    <div class="contact-info-right">
                        <h5>Address</h5>
                        <ul><li><?= get_company_address() ?></li></ul>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="contact-info">
                    <div class="contact-info-left">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                    </div>
                    <div class="contact-info-right">
                        <h5>Mobile</h5>
                        <ul>
                            <?php $mobile = get_company_contact_number(); ?>
                            <li><a href="tel:<?= $mobile ?>"><?= $mobile ?></a></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="contact-info">
                    <div class="contact-info-left">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </div>
                    <div class="contact-info-right">
                        <h5>E-Mail</h5>
                        <?php $email = get_company_contact_email(); ?>
                        <ul>
                            <li><a href="mailto:<?= $email ?>"><?= $email ?></a></li>
                        </ul>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div data-aos="flip-right" class="col-md-6 contact-form contact-us-form-block contact-right">
                <form id="contact-us-form" class="contact-us-form" name="contact-us-form" action="<?= base_url('contact_us/send_message'); ?>" method="post">
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="email" class="email" name="email" placeholder="Email" required>
                    <div class="clearfix"> </div>
                    <input type="text" class="phone" name="mobile" placeholder="Phone Number" required>
                    <textarea placeholder="Message" name="message" ></textarea>
                    <input class="contact-us-submit-button" type="submit" value="SUBMIT">
                    <img style="display: none; float: right; width: 50px;" class="contact-us-small-loader" src="<?= base_url('assets/images/loader.gif'); ?>" alt="" title="">
                    <div class="clearfix"></div>
                    <div class="contact-us-form-result-message"></div>
                </form>
            </div>
        </div>
    </div>

    <div id="christmas" style="overflow: hidden;">
        <div class="recipes-w3l-agile">
            <div class="container">
                <div class="card" style="padding: .5rem;background: #FFFFFF;border: 3px solid black;border-radius: 0">
                    <div class="text-center card-header"><h3 class="tittle">Our Opening & Closing Hours</h3></div>
                    <?php $this->load->view('shop_opening_timing_list'); ?>
                    <!-- <iframe src="http://localhost:8181/demo.elipos/home/shop_opening_timing_list"></iframe> -->
                </div>
            </div>
        </div>
    </div>
    <!-- <iframe src="http://localhost:8181/demo.elipos/home/shop_opening_timing_list"></iframe> -->
    <div class="clearfix"> </div>
    <!-- //contact -->

    <!-- map -->
    <div class="map" style="margin-top: 25px;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2424.5362762815257!2d-1.8870741846472237!3d52.577996839682655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4870a475124f917f%3A0x4fb9ce994e42a65d!2sStreetly+Balti!5e0!3m2!1sen!2sbd!4v1539075470773"></iframe>
    </div>
    <!-- //map -->

    <!-- subscribe -->
    <div class="agileits_w3layouts_banner_info">
        <div class="container">
            <div data-aos="" class="col-md-7 subscribe-left">
                <h3>Subscribe to get the latest updates right to your inbox</h3>
            </div>
            <div data-aos="" class="col-md-5 subscribe-right">
                <form id="subscriber-client-form" class="subscriber-client-form" name="subscriber-client-form" action="<?= base_url('home/get_subscribed'); ?>" method="post">
                    <input type="email" name="email" placeholder="Enter your Email..." required="">

                    <input type="submit" value="Subscribe">
                    <div id="subscriber_email_validation"></div>
                    <div id="subscribed-message" class="subscribed-message"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- subscribe -->

    <!-- copyright -->

    <!-- //copyright -->
    
    <?php $this->load->view('footer', $this->data); ?>

    <!-- bootstrap-modal-pop-up -->
    <div class="modal video-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
        <div class="modal-dialog" role="document"  style= ''>
            <div class="modal-content">
                <div class="modal-header">
                    Food Chef
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <img src="<?= base_url('assets/theme/') ?>images/food3.jpg" alt=" " class="img-responsive" />
                    <p>
                        Welcome to Streetly Balti, where a treasure trove of flavours and spices await to tickle your tastebuds.
                        <i>Unspeakably brilliant Indian food and smooth, seamless pleasant service. Whether you want to impress the love of your life, enjoy a special occasion or just to celebrate life , Streetly Balti is the place to do it.</i>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- //bootstrap-modal-pop-up -->
    <script src="<?= base_url('assets/theme/') ?>js/lightbox-plus-jquery.min.js"></script><!-- for gallery js -->

    <!-- js -->
    <script type="text/javascript" src="<?= base_url('assets/theme/') ?>js/jquery-2.1.4.min.js"></script>
    <!-- for bootstrap working -->

    <!-- //for bootstrap working -->
    <!-- //js -->
    <script src="<?= base_url('assets/theme/js/bootstrap.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/jquery/jquery.validate.min.js') ?>"></script>


    <!-- /Responsive slides js -->
    <script src="<?= base_url('assets/theme/') ?>js/responsiveslides.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/theme/') ?>css/jquery-ui.css" />
    <script src="<?= base_url('assets/theme/') ?>js/jquery-ui.js"></script>
    <script src="<?= base_url('assets/theme/') ?>js/jquery.adipoli.min.js" type="text/javascript"></script>
    <script>
        // You can also use "$(window).load(function() {"
        $(function () {
            // Slideshow 4
            $("#slider3").responsiveSlides({
                auto: true,
                pager: true,
                nav: false,
                speed: 500,
                namespace: "callbacks",
                before: function () {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                    $('.events').append("<li>after event fired.</li>");
                }
            });

        });

        // You can also use "$(window).load(function() {"
        $(function () {
            // Slideshow 4
            $("#slider4").responsiveSlides({
                auto: true,
                pager: true,
                nav: false,
                speed: 500,
                namespace: "callbacks",
                before: function () {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                    $('.events').append("<li>after event fired.</li>");
                }
            });
        });

        // You can also use "$(window).load(function() {"
        $(function () {
            // Slideshow 4
            $("#slider3").responsiveSlides({
                auto: true,
                pager: false,
                nav: true,
                speed: 500,
                namespace: "callbacks",
                before: function () {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                    $('.events').append("<li>after event fired.</li>");
                }
            });

        });
    </script>

    <!-- Responsive slides js -->

    <!-- animation effects-js files-->
    <script src="<?= base_url('assets/theme/') ?>js/aos.js"></script><!-- //animation effects-js-->
    <script src="<?= base_url('assets/theme/') ?>js/aos1.js"></script><!-- //animation effects-js-->
    <!-- animation effects-js files-->

    <!-- //here starts scrolling icon -->
    <script src="<?= base_url('assets/theme/') ?>js/SmoothScroll.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/theme/') ?>js/move-top.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/theme/') ?>js/easing.js"></script>
    <!-- here stars scrolling script -->
    <script type="text/javascript">
        $(document).ready(function () {
            // var defaults = {
            //     containerID: 'toTop', // fading element id
            //     containerHoverID: 'toTopHover', // fading element hover id
            //     scrollSpeed: 1200,
            //     easingType: 'linear'
            //  };
             

            $().UItoTop({easingType: 'easeOutQuart'});

        });
        // here ends scrolling script
        // here ends scrolling icon
        // scrolling script
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();

                $('.navbar-nav li').removeClass('active');
                $(this).closest('li').addClass('active');

                $('html,body').animate({scrollTop: $(this.hash).offset().top - 150}, 1000);
            });

        });

        // scrolling script
        // var navbarFixedTopHeight = $(".navbar-fixed-top").height()
        // $(".w3ls-banner").css({"margin-top": navbarFixedTopHeight + 70 + 'px'});

        $(document).ready(function () {
            $('body').scrollspy({target: ".navbar", offset: 200});
        });
        // $(function () {
        //     $( ".datepicker" ).datepicker();
        //     $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" }).val()
        // });
        $("#datepicker").datepicker({dateFormat: 'dd-mm-yy', minDate: 0});

        contact_us_form_validations();

        function contact_us_form_validations() {
            var thisForm = $('#contact-us-form');
            thisForm.validate({
                rules: {
                    name: "required",
                    message: "required",
                    email: {
                        required: true,
                        email: true
                    }

                },
                messages: {
                    name: "Please write you name",
                    message: "Please write message",
                    email: {
                        required: "Please enter email address",
                        email: "Please enter a valid email address",
                    }
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    // Add the `help-block` class to the error element
                    error.addClass("help-block");

                    if ((element.prop("type") === "checkbox")) {
                        error.insertAfter(element.parent("div"));
                    } else if (element.prop("type") === "radio") {
                        error.insertAfter(element.parent().nextAll().last("div"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
                },
                submitHandler: function (form) {
                    if (confirm("Are sure to send message ?")) {
                        $.ajax({
                            type: "POST",
                            url: thisForm.attr('action'),
                            data: thisForm.serialize(),
                            beforeSend: function () {
                                $('.contact-us-submit-button').hide();
                                $('.contact-us-small-loader').show();
                            },
                            complete: function () {
                                $('.contact-us-small-loader').hide();
                                $('.contact-us-submit-button').show();
                            },
                            success: function (data) {
                                console.log('data: ',data);
                                $('.contact-us-form-result-message').html(data['message']);
                                $('.contact-us-form-result-message').fadeIn();
                                setTimeout(function () {
                                    $('.contact-us-form-result-message').fadeOut();
                                    $('.contact-us-form-result-message').val('')
                                }, 3000);
                            },
                            error: function (error) {
                                console.log("error occured");
                            }
                        });

                    }


                }
            });
        }

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
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                if ((element.prop("type") === "checkbox")) {
                    error.insertAfter(element.parent("div"));
                } else if (element.prop("type") === "radio") {
                    error.insertAfter(element.parent().nextAll().last("div"));
                } else {
                    error.insertAfter(element);
                }
                error.appendTo($('#subscriber_email_validation'));
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: $('#subscriber-client-form').attr('action'),
                    data: $('#subscriber-client-form').serialize(),
                    success: function (data) {
                        $('.subscribed-message').html(data['message']);
                        $('.subscribed-message').fadeIn();
                        setTimeout(function () {
                            $('.subscribed-message').fadeOut();
                            $('.subscribed-message').val('')
                        }, 3000);
                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
            }
        });

        reservation();
        function reservation() {
            var thisForm = $('#reservation_form');
            thisForm.validate({
                rules: {
                    name: "required",
                    mobile: "required",
                    email: "required",
                    reservation_date: {
                        required: true,
                    },
                    number_of_guest: "required",
                },
                messages: {
                    name: "Please enter name",
                    mobile: "Please enter mobile",
                    email: "Please enter email",
                    reservation_date: {
                        required: "Please select reservation date",
                    },
                    number_of_guest: "Please enter number of guest",
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    // Add the `help-block` class to the error element
                    error.addClass("help-block");

                    if ((element.prop("type") === "checkbox")) {
                        error.insertAfter(element.parent("div"));
                    } else if (element.prop("type") === "radio") {
                        error.insertAfter(element.parent().nextAll().last("div"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
                },
                submitHandler: function (form) {
                    if (confirm("Are sure to Book?")) {
                        $.ajax({
                            type: "POST",
                            url: thisForm.attr('action'),
                            data: thisForm.serialize(),
                            beforeSend: function () {
                                $('.booking-button').hide();
                                $('.booking-small-loader').show();
                            },
                            complete: function () {
                                $('.booking-small-loader').hide();
                                $('.booking-button').show();
                                document.getElementById("reservation_form").reset();
                                document.getElementById("country1").reset();
                                document.getElementById("resemail").reset();
                            },
                            success: function (data) {
                                $('.reservation-message').html(data['message']);
                                $('.reservation-message').fadeIn();
                                setTimeout(function () {
                                    $('.reservation-message').fadeOut();
                                    $('.reservation-message').val('')
                                }, 3000);
                            },
                            error: function (error) {
                                console.log("error occured");
                            }
                        });

                    }

                }
            });
        }

        $(function () {
            var type = window.location.hash;
            if (type) {
                $('html,body').animate({scrollTop: $(type).offset().top - 150}, 1000);
            }
            // location.href = window.location.pathname;
        });

        $(document).ready(function () {
            var type = window.location.hash;
            var href = 'a[href*="' + type + '"]';
            if (type !== '') {
                $('.nav-item').removeClass('active');
            }
            $('.navbar-nav li').find(href).closest('li').addClass('active');
            if (type) {
                $('html,body').animate({scrollTop: $(type).offset().top - 150}, 3000);
            }
        });

        $(document).ready(function () {
            //$(document).on("scroll", onScroll);
        });

        function onScroll(event) {
            $('.nav-item').removeClass('active');
            $('.home-tab-list').removeClass('active');
            var scrollPos = $(document).scrollTop() - 150;
            $(".navbar-nav .scroll").each(function () {
                var currLink = $(this);
                var refElement = $(currLink.attr("href"));
                if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                    $('.navbar-nav li a').closest('li').removeClass("active");
                    currLink.closest('li').addClass("active");
                } else {
                    currLink.closest('li').removeClass("active");
                }
            });
        }
    </script>

    <link rel="stylesheet" href="https://cdn.rawgit.com/stevenmonson/googleReviews/master/google-places.css">

    <script src="https://cdn.jsdelivr.net/gh/stevenmonson/googleReviews@6e8f0d794393ec657dab69eb1421f3a60add23ef/google-places.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDeivU57j-macv2fXXgbhKGM6cqMLmnAFI&signed_in=true&libraries=places"></script>

    <script>
        jQuery(document).ready(function ($) {
            $("#google-reviews").googlePlaces({
                placeId: 'ChIJp2QxV_sJVFMR1DEp1x_16F8' //Find placeID @: https://developers.google.com/places/place-id
                , render: ['reviews']
                , min_rating: 4
                , max_rows: 4
            });
        });

        $('#download-inside-menu').click(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'home/download_menu',
                data: {},
                success: function (data) {

                },
                error: function (error) {

                }
            });
        });
        $('.navbar-nav>li>a').on('click', function () {
            $('.navbar-collapse').collapse('hide');
        });
    </script>
    </body>
</html>