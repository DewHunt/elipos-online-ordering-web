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
                                <h2>Meta Data Settings</h2>

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
                                <form id="meta-data-settings-form"
                                      action="<?= base_url($this->admin . '/settings/home_meta_insert') ?>"
                                      method="post">
                                    <input type="hidden" name="id" value="<?= get_home_meta_id() ?>">
                                    <input type="hidden" name="name" value="home_meta">

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
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div
                                                    class="col-lg-2 col-md-2 col-sm-2 col-xs-12 form-group control-label meta_tittle_form-padding-left">
                                                    Meta Tittle
                                                </div>
                                                <div
                                                    class="col-lg-10 col-md-10 col-sm-10 col-xs-12 form-group ">

                                                    <input type="text" class="form-control" id="meta_title"
                                                           name="meta_title" value="<?= get_home_meta_title() ?>"
                                                           placeholder="Meta Title">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div
                                                        class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label form-group">
                                                        Meta Description
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 form-group">
                                                          <textarea class="form-control" id="meta_description"
                                                                    name="meta_description" rows="3"
                                                                    placeholder="Meta Description"><?= get_home_meta_description() ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div
                                                    class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label form-group meta_tittle_form-padding-left">
                                                    Meta Keywords
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 form-group">
                                                        <textarea class="form-control" id="meta_keywords"
                                                                  name="meta_keywords" rows="3"
                                                                  placeholder="Meta Keywords"><?= get_home_meta_keywords() ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group row">
                                                <div class="right-side-view right-side-magin">
                                                    <!--   <a type="button" href="<? /*= base_url('admin/user') */ ?>"
                                                               class="btn btn-danger">Cancel</a>-->
                                                    <!--  <button class="btn btn-warning" type="reset">Save Change</button>-->

                                                    <button id="send" type="submit" class="btn btn-success">Save
                                                        Change
                                                    </button>
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




