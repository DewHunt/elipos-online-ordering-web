<!-- side navigation -->
<div class="col-md-3 left_col menu_fixed left">
    <!--<div class="col-md-3 left_col">-->
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?= base_url('admin/dashboard') ?>" class="site_title"><i class="fa fa-paw"></i>
                <span><?= get_company_name() ?></span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?= base_url('assets/my_design/admin_design/images/user.png') ?>" alt="..."
                     class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>

                <h2><?php echo ucfirst($this->session->userdata('user_name')); ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-user"></i> Customer <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= base_url('admin/customer') ?>">Customer List</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav side-menu">
                    <li><a><i class="fa fa-user"></i> User <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= base_url('admin/user') ?>">User List</a></li>
                            <li><a href="<?= base_url('admin/user_role') ?>">User Role</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav side-menu">
                    <li><a><i class="fa fa-globe"></i> All Orders <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= base_url('admin/all_orders') ?>">All Orders List</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav side-menu">
                    <li><a><i class="fa fa-bars"></i> Settings <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a>Business Settings<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('admin/settings/business_information_settings') ?>">Business Information Settings</a></li>
                                    <li><a href="<?= base_url('admin/settings/currency') ?>">Currency Settings</a></li>
                                    <li><a href="<?= base_url('admin/settings/social_media') ?>">Social Media Settings</a></li>
                                    <li><a href="<?= base_url('admin/settings/maintenance_mode') ?>">Maintenance Mode</a></li>
                                    <li><a href="<?= base_url('admin/settings/weekend_off') ?>">Weekend & Holidays </a></li>
                                    <li><a href="<?= base_url('admin/settings/opening_and_closing') ?>">Opening and Closing</a></li>
                                    <li><a href="<?= base_url('admin/settings/menu_upload') ?>">Menu Upload</a></li>
                                    <li><a href="<?= base_url('admin/settings/home_promo') ?>">Home Promo</a></li>
                                </ul>
                            </li>

                            <li><a>Payment Settings<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('admin/settings/payment_settings') ?>">Payment Settings</a></li>
                                    <li><a href="<?= base_url('admin/settings/paypal_settings') ?>">Paypal Settings</a></li>
                                    <li><a href="<?= base_url('admin/settings/stripe_settings') ?>">Stripe Settings</a></li>
                                    <li><a href="<?= base_url('admin/settings/nochecx_settings') ?>">Nochex Settings</a></li>
                                    <li><a href="<?= base_url('admin/settings/pay360_settings') ?>">Pay360 Settings</a></li>
                                    <li><a href="<?= base_url('admin/settings/worldpay_settings') ?>">Worldpay Settings</a></li>
                                </ul>
                            </li>

                            <li><a>Coverage<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('admin/settings/area_coverage') ?>">Coverage Area</a></li>
                                    <li><a href="<?= base_url('admin/postcode/all') ?>">Postcode List</a></li>
                                    <li><a href="<?= base_url('admin/settings/allowed_miles') ?>">Allowed Miles</a></li>
                                </ul>
                            </li>

                            <li><a href="<?= base_url('admin/settings/discount') ?>">Discount</a></li>
                            <li><a href="<?= base_url('admin/settings/service_charge') ?>">Service Charge</a></li>
                            <li><a href="<?= base_url('admin/settings/packaging_charge') ?>">Packaging Charge</a></li>
                            <li><a href="<?= base_url('admin/tips/index') ?>">Tips</a></li>
                            <li><a href="<?= base_url('admin/menu/index') ?>">Menu</a></li>
                            <li><a href="<?= base_url('admin/menu_action/index') ?>">Menu Action</a></li>

                            <li><a><i class="fa fa-mobile" aria-hidden="true" ></i>App Settings <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?= base_url('admin/app_settings/page') ?>">Page Settings</a></li>
                                    <li><a href="<?= base_url('admin/app_settings/home_page') ?>">Home Page</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav side-menu">
                    <li><a><i class="fa fa-bars"></i> Menu <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= base_url('admin/Parent_category') ?>">Parent Category</a></li>
                            <li><a href="<?= base_url('admin/food_type') ?>">Food Type</a></li>
                            <li><a href="<?= base_url('admin/category') ?>">Category</a></li>
                            <li><a href="<?= base_url('admin/product') ?>">Product</a></li>
                            <li><a href="<?= base_url('admin/sub_product') ?>">Sub Product</a></li>
                            <li><a href="<?= base_url('admin/sub_product_files') ?>">Sub Product Files</a></li>
                            <li><a href="<?= base_url('admin/table') ?>">Tables</a></li>
                            <li><a href="<?= base_url('admin/sub_product_files/assign') ?>">Assign/Remove Sub Product Files Item</a></li>
                            <li><a href="<?= base_url('admin/modifier_category') ?>">Modifier Category</a></li>
                            <li><a href="<?= base_url('admin/modifier') ?>">Modifier</a></li>
                            <li><a href="<?= base_url('admin/offers_or_deals') ?>">Offer/Deals</a></li>
                            <li><a href="<?= base_url('admin/free_items') ?>">Free Items Offer</a></li>
                            <li><a href="<?= base_url('admin/buy_and_get') ?>">Buy X Get Y</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav side-menu">
                    <li>
                        <a><i class="fa fa-newspaper-o" aria-hidden="true"></i>Vouchers <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= base_url($this->admin.'/vouchers') ?>">Vouchers</a></li>
                            <li><a href="<?= base_url($this->admin.'/coupons') ?>">Coupons </a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav side-menu">
                    <li>
                        <a><i class="fa fa-bars"></i> Booking <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= base_url('admin/booking_customer') ?>">Booking</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav side-menu">
                    <li>
                        <a><i class="fa fa-newspaper-o" aria-hidden="true"></i>Subscriber <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= base_url($this->admin.'/subscriber') ?>">All Subscriber</a></li>
                            <li><a href="<?= base_url($this->admin.'/subscriber/add') ?>">Add new </a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav side-menu">
                    <li><a href="<?= base_url($this->admin . '/customer_notifications') ?>"><i class="fa fa-bell" aria-hidden="true"></i>Notification </a>
                    </li>
                </ul>

                <ul class="nav side-menu">
                    <li>
                        <a><i class="fa fa-file"></i>Content Management<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="<?= base_url($this->admin.'/page_management') ?>"><i class="fa fa-dot-circle-o"></i>Page Management </a>
                            </li>

                            <li>
                                <a href="<?= base_url($this->admin.'/gallery_management') ?>"><i class="fa fa-image"></i>Gallery </a>
                            </li>
                            <li>
                                <a href="<?= base_url($this->admin.'/page_management/home') ?>"><i class="fa fa-dot-circle-o"></i>Home Page </a>
                            </li>
                            <li>
                                <a href="<?= base_url($this->admin.'/page_management/menu_review') ?>"><i class="fa fa-dot-circle-o"></i>Menu Tab Review</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a href="<?= base_url('admin/settings') ?>" data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a id="turnFullScreen" data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout"
               href="<?= base_url($this->admin . '/login/user_logout') ?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>

<script type="text/javascript">
    toggleFullScreen();
    function toggleFullScreen() {
        $('#turnFullScreen').click(function () {
            var element = document.documentElement;
            if (!IsFullScreenCurrently()) {
                GoInFullscreen(element);
                toggleFullScreen();
            } else {
                GoOutFullscreen();
                toggleFullScreen();
                console.log('click');
            }
        });
    }

    function IsFullScreenCurrently() {
        var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;
        console.log(full_screen_element);
        // If no element is in full-screen
        if (full_screen_element === null)
            return false;
        else
            return true;
    }

    function GoInFullscreen(element) {
        if (element.requestFullscreen)
            element.requestFullscreen();
        else if (element.mozRequestFullScreen)
            element.mozRequestFullScreen();
        else if (element.webkitRequestFullscreen)
            element.webkitRequestFullscreen();
        else if (element.msRequestFullscreen)
            element.msRequestFullscreen();
    }

    function GoOutFullscreen() {
        if (document.exitFullscreen)
            document.exitFullscreen();
        else if (document.mozCancelFullScreen)
            document.mozCancelFullScreen();
        else if (document.webkitExitFullscreen)
            document.webkitExitFullscreen();
        else if (document.msExitFullscreen)
            document.msExitFullscreen();
    }
</script>
<!-- /side navigation -->

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle"><a id="menu_toggle"><i class="fa fa-bars"></i></a></div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:void(0);" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="<?= base_url('assets/my_design/admin_design/images/user.png') ?>" alt="">
                        <?php echo ucfirst($this->session->userdata('user_name')); ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <!--<li><a href="javascript:;"> Profile</a></li>-->
                        <li><?php echo anchor(base_url($this->admin . '/user/user_profile'), 'Profile'); ?></li>
                        <li><a href="<?= base_url($this->admin . '/login/user_logout') ?>"><i class="fa fa-sign-out pull-right"></i> Logout</a></li>
                    </ul>
                </li>

                <!-- <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i><span class="badge bg-green">6</span>
                    </a>

                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>
                                <span class="image"><img src="<?= base_url('assets/my_design/admin_design/images/user.png') ?>" alt="Profile Image"/></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>

                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>

                        <li>
                            <a>
                                <span class="image"><img src="<?= base_url('assets/my_design/admin_design/images/user.png') ?>" alt="Profile Image"/></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>

                        <li>
                            <a>
                                <span class="image"><img src="<?= base_url('assets/my_design/admin_design/images/user.png') ?>" alt="Profile Image"/></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>

                        <li>
                            <a>
                                <span class="image"><img src="<?= base_url('assets/my_design/admin_design/images/user.png') ?>" alt="Profile Image"/></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>

                        <li>
                            <div class="text-center">
                                <a>
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->
