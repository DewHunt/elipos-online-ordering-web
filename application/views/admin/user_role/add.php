<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/user_role') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> User Role List</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="user-role-form" name="user-role-form" action="<?= base_url('admin/user_role/save') ?>" method="post">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>User Role Name</label>
                        <input class="form-control" type="text" name="name" id="name" value="" placeholder="User Role Name">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Role ID</label>
                        <input class="form-control" type="text" name="role" id="role" value="" placeholder="User Role ID">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button id="save" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>