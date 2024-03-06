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
                                <h2>Barclycard Settings</h2>

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
                                <form id="barclycard-settings-form" method="post"
                                      action="<?= base_url($this->admin . '/settings/barclycard_settings_insert') ?>">
                                    <input type="hidden" name="id" class="form-control" id="id"
                                           value="<?= get_barclycard_settings_id() ?>">
                                    <input type="hidden" name="name" class="form-control" id="name"
                                           value="barclycard_settings">

                                    <div class="card col-xs-12">
                                        <div class="form-group row error-message text-align-center">
                                            <label for=""
                                                   class="col-sm-3 col-xs-12 col-form-label"></label>

                                            <div class="col-sm-9 col-xs-12">
                                                <?php
                                                if (!empty($this->session->flashdata('save_error_message'))) {
                                                    echo $this->session->flashdata('save_error_message');
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div
                                                        class="col-lg-5 col-md-5 col-sm-5 col-xs-12 control-label form-group">
                                                        Barclycard PSPID
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                                                        <input class="form-control" type="text" name="barclycard_pspid"
                                                               value="<?= get_barclycard_pspid() ?>"
                                                               id="barclycard-pspid"
                                                               placeholder="Barclycard PSPID">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div
                                                        class="col-lg-5 col-md-5 col-sm-5 col-xs-12 control-label form-group">
                                                        Barclycard SHA-IN Pass Phrase
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                                                        <input class="form-control" type="text"
                                                               name="barclycard_sha_in_pass_phrase"
                                                               value="<?= get_barclycard_sha_in_pass_phrase() ?>"
                                                               id="barclycard-sha-in-pass-phrase"
                                                               placeholder="Barclycard SHA-IN Pass Phrase">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div
                                                        class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label form-group">
                                                        Barclycard SHA-OUT Pass Phrase
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                                                        <input class="form-control" type="text"
                                                               name="barclycard_sha_out_pass_phrase"
                                                               value="<?= get_barclycard_sha_out_pass_phrase() ?>"
                                                               id="barclycard-sha-out-pass-phrase"
                                                               placeholder="Barclycard SHA-OUT Pass Phrase">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div
                                                        class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label form-group">
                                                        Barclycard DECLINE URL
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                                                        <input class="form-control" type="url"
                                                               name="barclycard_decline_url"
                                                               value="<?= get_barclycard_decline_url() ?>"
                                                               id="barclycard-decline-url"
                                                               placeholder="Barclycard DECLINE URL">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div
                                                class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                Barclycard ACCEPT URL
                                            </div>
                                            <div
                                                class="col-lg-10 col-md-10 col-sm-10 col-xs-12 form-group barclycard_form-padding-left">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <input class="form-control" type="url"
                                                               value="<?= get_nochecx_test_success_url() ?>"
                                                               id="nochecx-test-success-url"
                                                               name="nochecx_test_success_url"
                                                               placeholder="Nochecx Test Success url">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group row">
                                                <div class="right-side-view right-side-magin">
                                                    <!--   <a type="button" href="<? /*= base_url('admin/user') */ ?>"
                                                               class="btn btn-danger">Cancel</a>-->
                                                    <!--  <button class="btn btn-warning" type="reset">Save Change</button>-->
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <button id="send" type="submit" class="btn btn-success">Save
                                                            Change
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
        <?php $this->load->view('admin/footer'); ?>
    </div>
</div>




