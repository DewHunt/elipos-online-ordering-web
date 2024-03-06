<div class="table-responsive">
    <table class="table table-striped table-bordered dt-responsive nowrap menu-tab list-dt">
        <thead class="thead-default">
            <tr>
                <th class="text-center" width="20px">SN</th>
                <th class="text-center">Name</th>
                <th class="text-center" width="50px">Parent</th>
                <th class="text-center" width="50px">Link</th>
                <th class="text-center" width="50px">Icon</th>
                <th class="text-center" width="50px">Order</th>
                <th class="text-center" width="50px">Status</th>
                <th class="width-action text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $count = 1 ?>
            <?php if (!empty($menu_lists)): ?>
                <?php foreach ($menu_lists as $menu): ?>
                    <tr id="row_<?= $menu->id ?>">
                        <td class="text-center"><?= $count++ ?></td>
                        <td><?= $menu->menu_name ?></td>
                        <td><?= $menu->parent_name ?></td>
                        <td><?= $menu->menu_link ?></td>
                        <td><?= $menu->menu_icon ?></td>
                        <td class="text-center"><?= $menu->order_by ?></td>
                        <td class="text-center">
                        	<?php
                        		$status = 'Active';
                        		$btn_class = 'btn-success';
                        		if ($menu->status == 0) {
                            		$status = 'Deactive';
                            		$btn_class = 'btn-danger';
                        		}
                        	?>
                        	<button type="button" class="btn <?= $btn_class ?> btn-sm btn-status" menu-id="<?= $menu->id ?>" menu-status="<?= $menu->status ?>"><?= $status ?></button>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url("admin/menu/edit/$menu->id") ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                        	<button type="button" class="btn btn-danger btn-sm btn-delete" menu-id="<?= $menu->id ?>"><i class=" fa fa-times" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>