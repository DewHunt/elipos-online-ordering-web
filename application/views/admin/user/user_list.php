<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/user/user_create') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add New User</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table class="table table-striped table-bordered dt-responsive nowrap list-dt">
            <thead>
                <tr>
                    <th class="text-center" width="20px">SN</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">User Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center" width="80px">User Type</th>
                    <th class="width-action text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $count = 1;
                ?>
                <?php foreach ($users as $user): ?>                
                    <tr>
                        <td class="text-center"><?= $count++; ?></td>
                        <td><?= ucwords($user->name) ?></td>
                        <td><?= $user->user_name ?></td>
                        <td><?= $user->email ?></td>
                        <td class="text-center"><?= $user->user_role_name ?></td>
                        <td class="text-center">
                            <a href="<?= base_url("admin/user/user_update/$user->id") ?>" class="btn btn-primary btn-sm"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a  href="<?= base_url("admin/user/delete/$user->id") ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class=" fa fa-times" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
