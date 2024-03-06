<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
            $companyDetails = get_company_details();
        ?>
        <link title="favicon" rel="icon" href="<?= base_url(get_property_value('favicon', $companyDetails)) ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/bootstrap/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/sweetalert2/css/sweetalert2.min.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/theme/css/style.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/theme/css/menu.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/theme/css/custom-navbar.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/theme/css/modify-css.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/responsive-240-320.css') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/responsive-320-480.css') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/responsive-480-767.css') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/responsive-768-999.css') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/responsive-1000-1024.css') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/jquery-ui/jquery-ui.min.css') ?>"/>

        <!-- Date Time -->
        <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/datepicker/css/bootstrap-datepicker.css') ?>" /> -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.css" integrity="sha512-9rQHiowu3AtR6xVE8Jz+lyV1r2/xXQVW0kI8+O9+PrfWSvoOHDF2SOUIUFAj0mwIAPf1ezTxRlpdngvsZeC4Rw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <script src="<?= base_url('assets/jquery/jquery-2.2.4.min.js') ?>" type="text/javascript"></script>
        <!-- jQuery Autocomplete css -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"  ></script>
        <script src="<?= base_url('assets/bootstrap/js/bootstrap.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/jquery/jquery.validate.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/jquery/additional-methods.min.js') ?>" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url('assets/admin/sweetalert2/js/sweetalert2.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/jquery/jquery.sticky.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/jquery/scrollspy.js') ?>"></script>

        <!-- Date Time -->
        <!-- <script type="text/javascript" src="<?= base_url('assets/admin/datepicker/js/bootstrap-datepicker.js') ?>"></script> -->
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.js" integrity="sha512-0mHP4QWDFa1GsmKUfBfEoEdklBFylG/SiXC6v6Vk9qPjuUdqCHXqT+VAt+2i0Na8b1xe+7dVKw7BTWUq7QRivA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>

    <?php
        $isMobile = $this->agent->is_mobile();
        $mobileClass = ($isMobile) ? 'mobile' : '';
    ?>

    <body class="<?=$mobileClass?>">
        <header>
            <div class="copyright copyright1" style="width: 100%">
                <div class="container">
                    <div class="copyrighttop" style="float: right;">
                        <?php $this->load->view('home/social_media_link'); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div style="background: #191919">
                <div class="container">
                    <nav class="navbar navbar-expand-md  navbar-default menu-navbar">                        
                        <a class="mx-auto text-left" href="<?= base_url() ?>" style="padding-right: 0px; margin-left: 0px !important;">
                            <img src="<?= get_company_logo_url() ?>" class="custom-logo" alt="<?= get_company_name() ?>" itemprop="logo" style="width: 250px;">
                        </a>                       

                        <div class="navbar-collapse collapse order-1 order-md-0 dual-collapse2"  style="margin: 0;padding: 0">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item "><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('#about') ?>">About</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('#services') ?>">Service</a></li>
                              	<!-- <li class="nav-item"><a class="nav-link" href="<?= base_url('#inside-menu') ?>">Restaurant Menu</a></li> -->
                                <!-- <li class="nav-item"><a class="nav-link" href="<?= base_url('#christmas') ?>">Valentine’s Day</a></li>-->
                            </ul>
                        </div>

                        <div class="order-0">
                            <div class="row">                             
                                <div class="col-8">
                                    <a class="logo-brand page-scroll scroll" href="<?= base_url() ?>" >
                                        <img class="custom-logo-1" src="<?= get_company_logo_url() ?>" alt="<?= get_company_name() ?>">
                                    </a>
                                </div>
                                <div class="col-4">
                                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".dual-collapse2" >
                                        <span class="sr-only"><?= get_company_name() ?></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>                               
                            </div>
                        </div>

                        <div class="navbar-collapse collapse order-3 dual-collapse2"  style="margin: 0;padding: 0">
                            <ul class="navbar-nav  navbar-right">
                                <li class="nav-item active">
                                    <a class="nav-link" href="<?= base_url('menu') ?>">Online Order</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('#food') ?>">Our Food</a></li>
                                <?php if (is_active_reservation()): ?> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= base_url('reservation') ?>">Reservations</a>
                                    </li>
                                <?php else: ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= base_url('#table') ?>">Reservations</a>
                                    </li>
                                <?php endif ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('#testimonials') ?>">Testimonials</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('#contact') ?>">CONTACT</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <section id="content" class="container" style="margin-top: 15px">
            <div class="main">
                <div class="wrapper"><?= $this->page_content; ?></div>
            </div>
        </section>

        <div class="clearfix"></div>

        <?php $this->load->view('footer', $this->data) ?>

        <script>
            function autocomplete(inp, arr) {
                /*the autocomplete function takes two arguments, the text field element and an array of possible autocompleted values:*/
                var currentFocus;
                /*execute a function when someone writes in the text field:*/
                inp.addEventListener('input', function(e) {
                    var a, b, i, val = this.value;
                    /*close any already open lists of autocompleted values*/
                    closeAllLists();
                    if (!val) { return false;}
                    currentFocus = -1;
                    /*create a DIV element that will contain the items (values):*/
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items");
                    /*append the DIV element as a child of the autocomplete container:*/
                    this.parentNode.appendChild(a);
                    /*for each item in the array...*/
                    for (i = 0; i < arr.length; i++) {
                        /*check if the item starts with the same letters as the text field value:*/
                        // if (arr[i].substr(0, val.length).toUpperCase().indexof(val.toUpperCase()) != 0) {
                        if (arr[i].toUpperCase().includes(val.toUpperCase()) > 0) {
                            /*create a DIV element for each matching element:*/
                            b = document.createElement("DIV");
                            /*make the matching letters bold:*/
                            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                            b.innerHTML += arr[i].substr(val.length);
                            /*insert a input field that will hold the current array item's value:*/
                            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                            /*execute a function when someone clicks on the item value (DIV element):*/
                            b.addEventListener("click", function(e) {
                                /*insert the value for the autocomplete text field:*/
                                inp.value = this.getElementsByTagName("input")[0].value;
                                /*close the list of autocompleted values,
                                (or any other open lists of autocompleted values:*/
                                closeAllLists();
                            });
                            a.appendChild(b);
                        }
                    }
                });

                /*execute a function presses a key on the keyboard:*/
                inp.addEventListener("keydown", function(e) {
                    var x = document.getElementById(this.id + "autocomplete-list");
                    if (x) x = x.getElementsByTagName("div");
                    if (e.keyCode == 40) {
                        /*If the arrow DOWN key is pressed,
                        increase the currentFocus variable:*/
                        currentFocus++;
                        /*and and make the current item more visible:*/
                        addActive(x);
                    } else if (e.keyCode == 38) {
                        //up
                        /*If the arrow UP key is pressed, decrease the currentFocus variable:*/
                        currentFocus--;
                        /*and and make the current item more visible:*/
                        addActive(x);
                    } else if (e.keyCode == 13) {
                        /*If the ENTER key is pressed, prevent the form from being submitted,*/
                        e.preventDefault();
                        if (currentFocus > -1) {
                            /*and simulate a click on the "active" item:*/
                            if (x) x[currentFocus].click();
                        }
                    }
                });

                function addActive(x) {
                    /*a function to classify an item as "active":*/
                    if (!x) return false;
                    /*start by removing the "active" class on all items:*/
                    removeActive(x);
                    if (currentFocus >= x.length) currentFocus = 0;
                    if (currentFocus < 0) currentFocus = (x.length - 1);
                    /*add class "autocomplete-active":*/
                    x[currentFocus].classList.add("autocomplete-active");
                }

                function removeActive(x) {
                    /*a function to remove the "active" class from all autocomplete items:*/
                    for (var i = 0; i < x.length; i++) {
                        x[i].classList.remove("autocomplete-active");
                    }
                }

                function closeAllLists(elmnt) {
                    /*close all autocomplete lists in the document, except the one passed as an argument:*/
                    var x = document.getElementsByClassName("autocomplete-items");
                    for (var i = 0; i < x.length; i++) {
                        if (elmnt != x[i] && elmnt != inp) {
                            x[i].parentNode.removeChild(x[i]);
                        }
                    }
                }
                /*execute a function when someone clicks in the document:*/
                document.addEventListener("click", function (e) {
                    closeAllLists(e.target);
                });
            }
        </script>
    </body>
</html>