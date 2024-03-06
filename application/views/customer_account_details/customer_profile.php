<style>
    #myTab{ background-color: lightgrey; }
    .nav { margin-bottom: 10px }
</style>

<div id="main-contanier">
    <ul class="nav nav-tabs" id="myTab" role="tablist" >
        <li class="nav-item">
            <a class=" nav-link"  href="<?= base_url('my_account/customer_order_list') ?>" aria-controls="profile">All Orders</a>
        </li>
        <li class="nav-item">
            <a class=" nav-link active"  href="<?= base_url('my_account/customer_account_details') ?>" aria-controls="profile">Profile Edit</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('my_account/reset_password') ?>" aria-controls="profile">Change Password</a>
        </li>
    </ul>

    <div class="card">
        <div class="card-header"><h4 class="">Profile</h4></div>

        <div class="card-body">
            <div class="promos-header">
                <?php if (!empty($this->session->flashdata('duplicate_email_found_error_message'))) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Oops!</strong> <?php echo $this->session->flashdata('duplicate_email_found_error_message'); ?>
                    </div>
                <?php } ?>
                <?php if (!empty($this->session->flashdata('customer_profile_update_success_message'))) { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Congratulation!</strong> <?php echo $this->session->flashdata('customer_profile_update_success_message'); ?>
                    </div>
                <?php } ?>
            </div>
            
            <form id="customer-profile-update-form" name="customer-profile-update-form" action="<?= base_url('my_account/customer_profile_update') ?>" class="register-form" method="post">
                <input type="hidden" id="id" name="id" value="<?= $this->session->userdata('customer_id') ?>">

                <div class="supp warning">
                    <div class="error">
                        <?php
                            $form_validation_error_data = array();
                            echo $form_validation_error_data = $this->session->flashdata('form_validation_error');
                        ?>
                    </div>
                </div>

                <?php
                    $title_array = array('Mr.'=>'Mr.','Mrs.'=>'Mrs.','Miss'=>'Miss');
                ?>

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="title">Title<span class="mandatory-field-color">*</span></label>
                            <select class="form-control" id="title" name="title">
                                <option id="title" name="title" value="">Please Select</option>
                                <?php foreach ($title_array as $key => $value): ?>
                                    <?php
                                        $select = '';
                                        if ($key == $customer->title) {
                                            $select = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="first-name">First Name<span class="mandatory-field-color">*</span></label>
                            <input  class="form-control" id="first_name" name="first_name" type="text" value="<?= $customer->first_name ?>">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="last-name">Last Name<span class="mandatory-field-color">*</span></label>
                            <input  class="form-control" id="last_name" name="last_name" type="text" value="<?= $customer->last_name ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="email">Email<span class="mandatory-field-color">*</span></label>
                            <input  class="form-control" name="email" id="email" type="email" value="<?= $customer->email ?>">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="mobile">Mobile<span class="mandatory-field-color">*</span></label>
                            <input  class="form-control" id="mobile" name="mobile" type="text" value="<?= $customer->mobile ?>">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="postcode">Postcode<span class="mandatory-field-color">*</span></label>
                            <div autocomplete="off">
                                <div class="autocomplete" style="width: 100%">
                                    <input class="form-control" id="billing_postcode" name="billing_postcode" type="text" value="<?= $customer->billing_postcode ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="city">City<span class="mandatory-field-color">*</span></label>
                            <input  class="form-control" id="billing_city" name="billing_city" type="text" value="<?= $customer->billing_city ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Billing Address<span class="mandatory-field-color">*</span></label>
                            <div autocomplete="off">
                                <div class="autocomplete" style="width: 100%">
                                    <textarea type="text"  class="form-control" id="billing_address_line_1" name="billing_address_line_1" rows="3" placeholder="Billing Address"><?= $customer->billing_address_line_1 ?></textarea>
                                </div>
                            </div>
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
            title: "required",
            first_name: "required",
            last_name: "required",
            mobile: "required",
            billing_address_line_1: "required",
            billing_postcode: "required",
            billing_city: "required",
            email: {
                required: true,
                email: true,
            },
            mobile: "required",
        },
        messages: {
            title: "Please Select Title",
            first_name: "Please Enter First Name",
            last_name: "Please Enter Last Name",
            mobile: "Please Enter Mobile",
            billing_address_line_1: "Please Enter Address",
            billing_postcode: "Please Enter Postcode",
            billing_city: "Please Enter City",
            email: {
                required: "Please Enter Your Email",
                email: "Please Enter a Valid Email",
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).on('input','#billing_postcode',function(){
        var postcode = $(this).val();
        if (postcode !== '' && (typeof postcode) !== 'undefined' && postcode.length >= 3) {
            $.ajax({
                type: "POST",
                url: '<?= base_url('menu/getPostcodeSuggestion'); ?>',
                data: {order_type:'delivery',postcode:postcode},
                success: function (data) {
                    var jsonPostcode = data.jsonPostcode;
                    var jsonAddress = data.jsonAddress;
                    postcode = JSON.parse(jsonPostcode);
                    address = JSON.parse(jsonAddress);
                    // console.log(postcode);

                    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
                    autocomplete(document.getElementById("billing_postcode"), postcode);
                    autocomplete(document.getElementById("billing_address_line_1"), address);
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }
    });
</script>
