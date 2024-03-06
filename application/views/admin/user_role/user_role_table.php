<div class="table-responsive">
    <table class="table table-striped table-bordered dt-responsive list-dt">
        <thead class="thead-default">
            <tr>
                <th class="text-center" width="20px">SN</th>
                <th class="text-center" width="120px">Name</th>
                <th class="text-center" width="40px">Role Id</th>
                <th class="text-center">Menu Permission</th>
                <th class="text-center" width="10px">Status</th>
                <th class="width-action text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $count = 1 ?>
            <?php if (!empty($user_role_lists)): ?>
                <?php foreach ($user_role_lists as $user_role): ?>
                    <tr id="row_<?= $user_role->id ?>">
                        <td class="text-center"><?= $count++ ?></td>
                        <td><?= $user_role->name ?></td>
                        <td class="text-center"><?= $user_role->role ?></td>
                        <td class="text-justify"><?= $user_role->menu_permission_names ?></td>
                        <td class="text-center">
                        	<?php
                        		$status = 'Active';
                        		$btn_class = 'btn-success';
                        		if ($user_role->status == 0) {
                            		$status = 'Deactive';
                            		$btn_class = 'btn-danger';
                        		}
                        	?>
                        	<button type="button" class="btn <?= $btn_class ?> btn-sm btn-status" user-role-id="<?= $user_role->id ?>" user-role-status="<?= $user_role->status ?>"><?= $status ?></button>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url("admin/user_role/menu_permission/$user_role->id") ?>" class="btn btn-info btn-block btn-sm">Menu Permission</i></a>
                            <a href="<?= base_url("admin/user_role/edit/$user_role->id") ?>" class="btn btn-primary btn-block btn-sm">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"> Edit</i>
                            </a>
                        	<button type="button" class="btn btn-danger btn-block btn-sm btn-delete" user-role-id="<?= $user_role->id ?>"><i class=" fa fa-times" aria-hidden="true"></i> Delete</button>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>