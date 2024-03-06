<div class="container body">
    <div class="main_container">

        <?php $this->load->view('admin/navigation'); ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Customer Information</h2>

                                <?php echo anchor(base_url('admin/user/user_profile_update/'.$user->id), 'Update Information', 'class="btn btn-info btn-lg right-side-view"') ?>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">


                                <div class="x_content">
                                    <ul class="list-unstyled timeline">
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="" class="tag">
                                                        <span>Name</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a><?= $user->name ?></a>
                                                    </h2>

                                                    <div class="byline">
                                                        <span></span><a></a>
                                                    </div>
                                                    <p class="excerpt">
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="" class="tag">
                                                        <span>User Name</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a><?= $user->user_name ?></a>
                                                    </h2>

                                                    <div class="byline">
                                                        <span></span><a></a>
                                                    </div>
                                                    <p class="excerpt">
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="" class="tag">
                                                        <span>Email</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a><?= $user->email ?></a>
                                                    </h2>

                                                    <div class="byline">
                                                        <span></span><a></a>
                                                    </div>
                                                    <p class="excerpt">
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="" class="tag">
                                                        <span>Role</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a><?= $user->role == 1 ? "Admin" : "Editor"; ?></a>
                                                    </h2>

                                                    <div class="byline">
                                                        <span></span><a></a>
                                                    </div>
                                                    <p class="excerpt">
                                                    </p>
                                                </div>
                                            </div>
                                        </li>


                                    </ul>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /page content -->

        <?php $this->load->view('admin/footer'); ?>
    </div>
</div>

