
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
                                <h2>SMTP Config</h2>

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

                            <div class="x_content">
                                <div class="col-lg-12"></div>
                                    <?php

                                    if(!empty($smtp_config)){
                                        $email_config=json_decode($smtp_config->value);
                                    }else{
                                        $email_config='';
                                    }
                                    ?>
                                    <form id="why-we-are-form" method="post" action="smtp_config_insert" enctype="multipart/form-data">
                                        <input type="hidden" name="id"  class="form-control" id="id" value="<?=!empty($smtp_config)?$smtp_config->id:''?>">
                                        <input type="hidden" name="name"  class="form-control" id="name" value="smtp_config">
                                        <div class="form-group">
                                            <label for="description" class="form-control-label">Smtp Host URL</label>
                                            <input type="text" name="host"  class="form-control" id="host" value="<?=!empty($email_config)?$email_config->host:''?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="form-control-label">Smtp Host User</label>
                                            <input type="text" name="user"  class="form-control" id="user" value="<?=!empty($email_config)?$email_config->user:''?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="form-control-label">Smtp User Password</label>
                                            <input type="password" name="password"  class="form-control" id="password"value="<?=!empty($email_config)?$email_config->password:''?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="form-control-label">Mail Form(Title or Name)</label>
                                            <input type="text" name="form"  class="form-control" id="form" value="<?=!empty($email_config)?$email_config->form:''?>">
                                        </div>
                                        <label><?php  echo $this->session->flashdata('save_message')?></label>

                                        <div class="form-group">
                                            <button type="submit" id="contact-us-email-config-save-button" class=" btn btn-primary">Save</button>
                                        </div>
                                    </form>


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



