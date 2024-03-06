<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/user_role/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add User Role</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
    	<div class="user-role-div"><?= $user_role_table ?></div>
    </div>
</div>