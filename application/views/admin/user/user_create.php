<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/user') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> User Lists</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="user_save_form" name="user_save_form" action="<?= base_url('admin/user/save') ?>" method="post">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" value="" id="name" name="name" placeholder="Name">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" value="" id="email" name="email" placeholder="Email" oninvalid="setCustomValidity('Please enter a valid email Address')">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="user-name">User Name</label>
                        <input class="form-control" type="text" value="" id="user_name" name="user_name" placeholder="User Name">
                        <?php if (!empty($this->session->flashdata('user_name_error_message'))): ?>
                            <div class="error-message col-xs-12"><?= $this->session->flashdata('user_name_error_message') ?></div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="user-type">User Type</label>                        
                        <select id="role" name="role" class="form-control">
                            <option name="role" value="" label="Please Select"></option>
                            <?php foreach ($user_role_lists as $user_role): ?>                                
                                <option id="role" name="role" value="<?= $user_role->role ?>"><?= $user_role->name ?></option>
                            <?php endforeach ?>
                            <!-- <option id="role" name="role" value="2" <?= (get_array_key_value('role',$user) == 2) ? 'selected' : '' ?>>Other</option> -->
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" value="" id="password" name="password" placeholder="*****">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="confirm-password">Confrim Password</label>
                        <input class="form-control" type="password" value="" id="confirm_password" name="confirm_password" placeholder="*****">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <a type="button" href="<?= base_url('admin/user') ?>" class="btn btn-danger">Cancel</a>
                    <button class="btn btn-warning" type="reset">Reset</button>
                    <button id="send" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
