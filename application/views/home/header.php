<div class="copyright copyright1" style="width: 100%">
    <div class="container">
        <div class="copyrighttop" style="float: right;"><?php $this->load->view('home/social_media_link'); ?></div>
    </div>
    <div class="clearfix"></div>
</div>

<div style="background: #191919">
    <div class="container">
        <nav class="navbar navbar-expand-md  navbar-default menu-navbar " style="background: transparent">
            <a class="mx-auto text-left" href="<?= base_url() ?>" style="padding-right: 0px; margin-left: 0px !important;">
                <!-- <img src="<?= base_url('assets/theme/images/streetly_balti_logo.png') ?>" class="custom-logo" alt="Streetly Balti" itemprop="logo"> -->
                <img src="<?= base_url(get_property_value('company_logo', $companyDetails)) ?>" class="custom-logo" alt="Streetly Balti" itemprop="logo">
            </a>
            
            <div class="navbar-collapse collapse order-1 order-md-0 dual-collapse2"  style="margin: 0;padding: 0">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item home-tab-list"><a class="nav-link page-scroll scroll" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link page-scroll scroll" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link page-scroll scroll" href="#services">Services</a></li>
                    <!-- <li class="nav-item"><a class="nav-link page-scroll scroll" href="#inside-menu">Restaurant Menu</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link page-scroll scroll" href="#christmas">Valentine’s Day</a></li> -->
                </ul>
            </div>
            <div class="order-0">
                <div class="row">
                    <div class="col-8" style="width: 70%;">
                        <a class="logo-brand page-scroll scroll" href="#page-top">
                            <img class="custom-logo-1" src="<?= base_url('assets/theme/') ?>images/streetly_balti_logo.png" alt="Streetly Balti">
                        </a>
                    </div>
                    <div class="" style="width: 29%;">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                            <span class="sr-only"><?= get_company_name() ?></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="navbar-collapse collapse order-3 dual-collapse2"  style="margin: 0;padding: 0 0 0 8px;">
                <ul class="navbar-nav  navbar-right">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('menu') ?>">Online Order</a></li>
                    <li class="nav-item"><a class="nav-link page-scroll scroll" href="#food">Food Gallery</a></li>
                    <li class="nav-item"><a class="nav-link page-scroll scroll" href="#table">Reservations</a></li>
                    <li class="nav-item"><a class="nav-link page-scroll scroll" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link page-scroll scroll" href="#contact">Contact</a></li>
                </ul>
            </div>
        </nav>
        <!-- <div class=" row justify-content-center">
            <a class=" mx-auto " href="#home" style="padding-right: 0px"> <img src="<?= base_url('assets/theme/') ?>images/streetly_balti_logo.png" class="custom-logo" alt="Streetly Balti" itemprop="logo">
            </a>
        </div> -->
    </div>
</div>
