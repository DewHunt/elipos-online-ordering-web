<div class="registration-login-block">
    <div class='register-page background-white'>
        <div class='max-page'>
            <div class='promos-header'>
                <div class='promos-header-text-container'>
                    <h1 class='inherit promos-header-text'>Reset Password</h1>
                </div>
            </div>
            <div class='register-form-container'>
                <div class="register-form">

                    <form id="password_reset" class="" method="post" action="<?=base_url('my_account/password_reset')?>">
                        <div class="fields form-group " >
                            <label for="current_password">Current Password*</label>
                            <input  class="form-control" name="current_password" id="current_password" type="password">
                            <p class="error"><?=$this->session->userdata('current_password_message')?></p>
                        </div>
                        <div class="fields form-group " id="pwd-container">
                            <label>New Password*</label>
                            <input  class="form-control" name="password" id="password" type="password">
                            <div class="pwstrength_viewport_progress">
                            </div>
                        </div>

                        <div class="fields form-group">
                            <label>New Confirm Password*</label>
                            <input  class="form-control" name="confirm_password" id="confirm_password" type="password">

                        </div>
                        <div class="form-group  text-xs-center">
                            <button type="submit"  class="btn btn-primary form-control">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




