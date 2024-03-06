<html lang="en"style="background-color: white;">
    <div class="login">
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form id="login_info_form" name="login_info_form" method="post"
                          action="<?= base_url( 'admin/login/user_login') ?>">
                        <h1>Login</h1>

                        <div>
                            <input type="text" class="form-control" id="name_or_email" name="name_or_email"
                                   placeholder="User Name Or Email">
                                   <?php echo form_error('name_or_email', '<p class="error">', '</p>'); ?>
                        </div>
                        <div>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Password">
                                   <?php echo form_error('password', '<p class="error">', '</p>'); ?>
                        </div>
                        <?php if (!empty($this->session->flashdata('login_error'))) { ?>
                            <div class="col-xs-12 error-message">
                                <fieldset class="form-group">
                                    <div class="error"> <?php echo $this->session->flashdata('login_error'); ?></div>
                                </fieldset>
                            </div>
                        <?php } ?>

                        <div>
                            <button id="login" type="submit" class="btn btn-success">Log in</button>
                            <div style="border-top: 1px solid #d8d8d8;">
                                <?=get_develop_by()?>
                            </div>
                        </div>

                        <!--<div class="clearfix"></div>-->

                        <!--                    <div class="separator">
                                                <div class="clearfix"></div>
                                                <br/>
                        
                                                <div>
                                                    <a href="http://giantssoft.com/" target="_blank"><h6 class="address-design">
                                                                Developed By Giantssoft
                                                                Solution</h6></a>
                                                </div>
                                            </div>-->
                    </form>
                </section>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $("form[name='login_info_form']").validate({
                rules: {
                    name_or_email: "required",
                    password: "required",
                },
                messages: {
                    name_or_email: "Please Enter User Name or Email",
                    password: "Please Enter Password",
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });

    </script>
