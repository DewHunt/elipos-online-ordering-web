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
                <?php
                    $user_role_id = $this->session->userdata('user_role');
                    $root_menu_lists = get_root_menu_list($user_role_id,true);
                    // dd($root_menu_lists);
                ?>
                <?php foreach ($root_menu_lists as $root_menu): ?>
                    <?php
                        $menu_icon = 'fa fa-bars';
                        if ($root_menu->menu_icon) {
                            $menu_icon = $root_menu->menu_icon;
                        }
                        $parent_menu_lists = get_menu_list($root_menu->id,$user_role_id,true);
                    ?>
                    <ul class="nav side-menu">
                        <?php if (count($parent_menu_lists) > 0): ?>
                            <li>
                                <a>
                                    <i class="<?= $menu_icon ?>"></i>&nbsp;<?= $root_menu->menu_name ?>&nbsp;<span class="fa fa-chevron-down"></span>
                                </a>
                                <ul class="nav child_menu">
                                    <?php foreach ($parent_menu_lists as $parent_menu): ?>
                                        <?php
                                            $menu_icon = 'fa fa-angle-right';
                                            if ($parent_menu->menu_icon) {
                                                $menu_icon = $parent_menu->menu_icon;
                                            }
                                            $child_menu_list = get_menu_list($parent_menu->id,$user_role_id,true);
                                        ?>                                        
                                        <?php if (count($child_menu_list) > 0): ?>                                        
                                            <li>
                                                <a><?= $parent_menu->menu_name ?>&nbsp;<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <?php foreach ($child_menu_list as $child_menu): ?>
                                                        <?php
                                                            $menu_id = $child_menu->id;
                                                            $menu_icon = 'fa fa-angle-right';
                                                            if ($child_menu->menu_icon) {
                                                                $menu_icon = $child_menu->menu_icon;
                                                            }
                                                            $menu_list = get_menu_list($child_menu->id,$user_role_id,true);
                                                        ?>
                                                        <?php if (count($menu_list) > 0): ?>
                                                            <li>
                                                                <a><?= $child_menu->menu_name ?>&nbsp;<span class="fa fa-chevron-down"></span></a>
                                                                <ul class="nav child_menu">
                                                                    <?php foreach ($menu_list as $menu): ?>
                                                                        <li>
                                                                            <a href="<?= base_url($menu->menu_link) ?>"><?= $menu->menu_name ?></a>
                                                                        </li>
                                                                    <?php endforeach ?>
                                                                </ul>
                                                            </li>
                                                        <?php else: ?>
                                                            <li>
                                                                <a href="<?= base_url($child_menu->menu_link) ?>"><?= $child_menu->menu_name ?></a>
                                                            </li>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li><a href="<?= base_url($parent_menu->menu_link) ?>"><?= $parent_menu->menu_name ?></a></li>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?= base_url($root_menu->menu_link) ?>">
                                    <i class="<?= $menu_icon ?>" aria-hidden="true"></i><?= $root_menu->menu_name ?>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                <?php endforeach ?>
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
