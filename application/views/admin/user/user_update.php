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
        <form id="user_save_form" name="user_save_form" method="post" action="<?= base_url('admin/user/edit') ?>">
            <input type="hidden" value="<?= $user->id ?>" id="id" name="id" placeholder="">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div for="name">Name</div>
                        <input class="form-control" type="text" value="<?= $user->name ?>" id="name" name="name" placeholder="Name">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div for="email">Email</div>
                        <input class="form-control" type="email" value="<?= $user->email ?>" id="email" name="email" placeholder="Email" oninvalid="setCustomValidity('Please enter a valid email Address')">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="user-name">User Name</label>
                        <input readonly="readonly" class="form-control" type="text" value="<?= $user->user_name ?>" id="user_name" name="user_name" placeholder="User Name">
                        <?php if (!empty($this->session->flashdata('user_name_error_message'))): ?>                        
                            <div class="error-message col-xs-12"><?= $this->session->flashdata('user_name_error_message') ?></div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="user-type">User Type</label>
                        <select id="role" name="role" class="form-control">
                            <option name="role" value="" label="Please Select"></option>
                            <?php foreach ($user_role_lists as $user_role): ?>
                                <?php
                                    $select = '';
                                    if ($user_role->role == $user->role) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option id="role" name="role" value="<?= $user_role->role ?>" <?= $select ?>><?= $user_role->name ?></option>
                            <?php endforeach ?>
                            <!-- <option id="role" name="role" value="2" <?= ($user->role == 2) ? 'selected' : '' ?>>Other</option> -->
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" value="" id="password" name="password" placeholder="*****">
                    </div>                    
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input class="form-control" type="password" value="" id="confirm_password" name="confirm_password" placeholder="*****">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col--md-12 col-sm-12 col-xs-12 text-right">
                    <a type="button" href="<?= base_url('admin/user') ?>" class="btn btn-danger">Cancel</a>
                    <button class="btn btn-warning" type="reset">Reset</button>
                    <button id="send" type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>