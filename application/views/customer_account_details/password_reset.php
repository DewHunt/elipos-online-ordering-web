
<div id="main-contanier">
    <!-- <div class="account_details_tab margin-top-1">
    </div> -->
    <ul class="nav nav-tabs" id="myTab" role="tablist" >
        <li class="nav-item">
            <a class="nav-link"  href="<?= base_url('my_account/customer_order_list') ?>" aria-controls="profile">All Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"  href="<?= base_url('my_account/customer_account_details') ?>" aria-controls="profile">Profile Edit</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="<?= base_url('my_account/reset_password') ?>" aria-controls="profile">Change Password</a>
        </li>
    </ul>

    <div class="card">
        <div class="card-header"><h4 class="">Change Your Password</h4></div>

        <div class="card-body">
            <div class="promos-header">
                <?php if (!empty($this->session->flashdata('error_message'))) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Oops!</strong> <?php echo $this->session->flashdata('error_message'); ?>
                    </div>
                <?php } ?>
                <?php if (!empty($this->session->flashdata('success_message'))) { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Congratulation!</strong> <?php echo $this->session->flashdata('success_message'); ?>
                    </div>
                <?php } ?>
            </div>
            <form id="customer-profile-update-form" name="customer-profile-update-form" action="<?= base_url('my_account/password_reset') ?>" class="register-form" method="post">
                <input type="hidden" id="id" name="id" value="<?= $this->session->userdata('customer_id') ?>">

                <div class="supp warning">
                    <div class="error">
                        <?php
                            $form_validation_error_data = array();
                            echo $form_validation_error_data = $this->session->flashdata('form_validation_error');
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="password">Current Password<span class="mandatory-field-color">*</span></label>
                            <input type="password" class="form-control" value="" id="current_password" name="current_password" placeholder="*****">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="password">Password<span class="mandatory-field-color">*</span></label>
                            <input type="password" class="form-control" value="" id="password" name="password" placeholder="*****">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="confirm-password">Confirm Password<span class="mandatory-field-color">*</span></label>
                            <input type="password" class="form-control" value="" id="confirm_password" name="confirm_password" placeholder="*****">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        <div class="form-group">
                            <div class="form-group">
                                <button  class="save-button-design common-submit-button checkout_creat_account" type="submit" >Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!--Scroll To Top-->
        <a href="#" class="typtipstotop"></a>
        <!--Scroll To Top-->

        <!-- Start Login/Register Form -->
        <div id="background-on-popup"></div>

        <div></div>
        <!-- End Login/Register Form -->
    </div>
</div>

<script>
    $("form[name='customer-profile-update-form']").validate({
        rules: {
            current_password: {
                required: true,
                minlength: 5,
            },
            password: {
                required: true,
                minlength: 5,
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: '#password',
            }
        },
        messages: {
            current_password: {
                required: "Please provide your current password",
                minlength: "Current password must be at least 5 characters long",
            },
            password: {
                required: "Please provide a password",
                minlength: "Password must be at least 5 characters long",
            },
            confirm_password: {
                required: "Please provide password to confirm password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Password doest not matched",
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
</script>
