
        <div class="page-title">
            <div class="title_left">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Page </h2>

                        <div class="form-group row success-message text-align-center">
                            <label for=""
                                   class="col-sm-3 col-xs-12 col-form-label"></label>

                            <div class="col-sm-9 col-xs-12">
                                <?php
                                if (!empty($this->session->flashdata('save_message'))) {
                                    echo $this->session->flashdata('save_message');
                                }


                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="error">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left" id="business_information_settings_form"
                              name="business_information_settings_form" method="post"
                              action="<?= base_url('admin/page_management/update_page_settings') ?>">
                            <input type="hidden" name="id" class="form-control" id="id"
                                   value="">
                            <input type="hidden" name="name" class="form-control" id="name"
                                   value="company_details">

                            <div class="card col-xs-12">
                                <div class="card-block">
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-xs-12 col-form-label control-label">
                                            Company Name
                                        </div>
                                        <div class="col-sm-9 col-xs-12">
                                            <input type="text" name="company_name" class="form-control"
                                                   id="company_name"
                                                   value="<?= !empty($details) ? $details->company_name : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-xs-12 col-form-label control-label">
                                            Email Address
                                        </div>
                                        <div class="col-sm-9 col-xs-12">
                                            <input type="email" name="email" class="form-control" id="email"
                                                   value="<?= !empty($details) ? $details->email : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-xs-12 col-form-label control-label">
                                            Contact Number
                                        </div>
                                        <div class="col-sm-9 col-xs-12">
                                            <input type="text" name="contact_number" class="form-control"
                                                   id="contact_number"
                                                   value="<?= !empty($details) ? $details->contact_number : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-xs-12 col-form-label control-label">
                                            Company Address
                                        </div>
                                        <div class="col-sm-9 col-xs-12">
                                                    <textarea type="text" rows="3" name="company_address"
                                                              class="form-control"
                                                              id="company_address"><?= !empty($details) ? $details->company_address : '' ?>
                                                    </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-xs-12 col-form-label">
                                            <div class="col-lg-6">
                                            </div>
                                            <div class="col-lg-6">
                                                Company Logo
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12">
                                            <span>Select File</span>
                                            <input type="file" name="file" id="file">
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <button type="button" class="btn btn-primary image-upload">Upload Image
                                            </button>
                                        </div>
                                    </div>
                                    <div class="logo-image-section col-xs-12 form-group row">
                                        <label for="" class="col-sm-3 col-xs-12 col-form-label"></label>

                                        <div class="card col-sm-3 col-xs-12">
                                            <img width="100px" height="100px" id="logoImage"
                                                 class="image-preview"
                                                 src="<?= !empty($details) ? base_url() . $details->company_logo : '' ?>">
                                        </div>
                                    </div>
                                    <div class="image-message">
                                        <?php
                                        if (!empty(get_shop_logo())) {
                                            ?>
                                            <input type="hidden" name="company_logo"
                                                   value="<?= get_shop_logo() ?>">
                                        <?php } ?>
                                    </div>

                                    <div class="form-group row">
                                        <div class="progress" style="display: none">
                                            <div class="background-color-white text-align-center"
                                                 style="background-color: #ffffff; border-radius: 30px"
                                                 id="progress-percentage">
                                            </div>
                                            <progress
                                                class="progressbar progress progress-striped progress-animated progress-success"
                                                value="0" max="100" id="progress-bar"></progress>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="right-side-view right-side-magin">
                                    <button id="send" type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


