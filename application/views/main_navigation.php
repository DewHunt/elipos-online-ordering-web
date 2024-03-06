
<?php

$isCustomerIsLogin=$this->Customer_Model->customer_is_loggedIn();

?>

<div class="header-w3layouts">
    <!-- Navigation -->
    <nav class="main-navigation navbar navbar-default navbar-fixed-top">
        <div class="copyright copyright1">
            <div class="copyrighttop" style="float: right;">

                <ul class="social-icons-wrapper">
                    <li><h4>Follow us on:</h4></li>
                    <li><a target="_blank" class="facebook" href="https://www.facebook.com/Streetly.Balti.Chester/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a target="_blank" class="facebook" href="https://www.tripadvisor.co.uk/LocationPhotoDirectLink-g190731-d916546-i272988671-Streetly_Balti-Sutton_Coldfield_West_Midlands_England.html"><i class="fa fa-tripadvisor" aria-hidden="true"></i></a></li>
                    <li><a target="_blank" class="facebook" href="https://www.instagram.com/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="container">
            <div class="navbar-header page-scroll" style="padding-right: 10%;">
                <div class="row">
                    <div class="col-xs-8" >
                        <a href="#home">
                            <img src="<?=get_company_logo_url()?>" class="custom-logo-1 display-none" alt="<?= get_company_name()   ?>" itemprop="logo">
                        </a>
                    </div>
                    <div class="col-xs-4">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only"><?=get_company_name()?></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden"><a class="page-scroll scroll" href="#page-top"></a>	</li>
                    <li><a class="page-scroll scroll" href="#home">Home</a></li>
                    <li><a class="page-scroll scroll" href="#about">About</a></li>
                    <li style="z-index: 100"><a class="page-scroll scroll" href="#services">Services</a></li>
                    <li style="z-index: 100"><a class="page-scroll " href="<?=base_url('menu')?>">Order Online</a></li>
                </ul>
                <ul class="logo logo">
                    <li>
                        <a href="#home">
                            <img src="<?=get_company_logo_url()?>" class="custom-logo" alt="<?= get_company_name()    ?>" itemprop="logo">
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden"><a class="page-scroll scroll" href="#page-top"></a>	</li>
                    <li><a class="page-scroll scroll" href="#food">Restaurant MENU</a></li>
                    <li><a class="page-scroll scroll" href="#table">Book A Table</a></li>
                    <li><a class="page-scroll scroll" href="#testimonials">Testimonials</a></li>
                    <li><a class="page-scroll scroll" href="#contact">Contact</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
</div>