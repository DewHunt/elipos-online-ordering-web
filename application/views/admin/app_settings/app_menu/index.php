<style type="text/css">
	.success-txt { color: #008000; font-weight:bold; }
	.danger-txt { color: #ff0000; font-weight:bold; }
	.saved-image { width: 60px; height: 60px; }
	td span { line-height: 0px; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/app_settings/add_app_menu') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Menu</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
    	<div class="table-responsive">
		    <table class="table table-striped table-bordered dt-responsive nowrap menu-tab list-dt">
		        <thead class="thead-default">
		            <tr>
		                <th class="text-center" width="20px">SN</th>
		                <th class="text-center" width="100px">Title</th>
		                <th class="text-center" width="100px">Component</th>
		                <th class="text-center" width="50px">Path</th>
		                <th class="text-center" width="50px">Icon Name</th>
		                <th class="text-center" width="50px">Menu Icon</th>
		                <th class="text-center" width="50px">Home Icon</th>
		                <th class="text-center" width="100px">Status</th>
		                <th class="text-center" width="60px">Order</th>
		                <th class="text-center" width="40px">Action</th>
		            </tr>
		        </thead>

		        <tbody>
		            <?php $count = 1 ?>
		            <?php if (!empty($menu_lists)): ?>
		                <?php foreach ($menu_lists as $menu): ?>
		                	<?php
		                		$iconImagePath = "assets/images/no-image.jpg";
		                		$homeIconImagePath = "assets/images/no-image.jpg";
		                		if ($menu->iconImagePath) {
		                			$iconImagePath = $menu->iconImagePath;
		                		}
		                		if ($menu->homeIconImagePath) {
		                			$homeIconImagePath = $menu->homeIconImagePath;
		                		}
		                	?>
		                    <tr>
		                        <td class="text-center"><?= $count++ ?></td>
		                        <td><?= $menu->title ?></td>
		                        <td><?= $menu->component ?></td>
		                        <td><?= $menu->path ?></td>
		                        <td><?= $menu->iconName ?></td>
		                        <td class="text-center">
		                        	<img class="img-thumbnail saved-image" src="<?= base_url($iconImagePath); ?>">
		                        </td>
		                        <td class="text-center">
		                        	<img class="img-thumbnail saved-image" src="<?= base_url($homeIconImagePath); ?>">
		                        </td>
		                        <td class="text-center">
		                        	<span class="<?= $menu->isActive ? 'success-txt' : 'danger-txt' ?>">Active: <?= $menu->isActive ? 'Yes' : 'No' ?></span>
		                        	<br>
		                        	<span class="<?= $menu->isShow ? 'success-txt' : 'danger-txt' ?>">Menu: <?= $menu->isShow ? 'Yes' : 'No' ?></span>
		                        	<br>
		                        	<span class="<?= $menu->showInHome ? 'success-txt' : 'danger-txt' ?>">Home: <?= $menu->showInHome ? 'Yes' : 'No' ?></span>
		                        </td>
		                        <td class="text-center">
		                        	<b>Menu: <?= $menu->sortingNumber ?></b>
		                        	<br>
		                        	<b>Home: <?= $menu->homeSortingNumber ?></b>
		                        </td>
		                        <td class="text-center">
		                            <a href="<?= base_url("admin/app_settings/edit_app_menu/$menu->id") ?>" class="btn btn-primary btn-sm btn-block">
		                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
		                            </a>
		                        	<button type="button" class="btn btn-danger btn-sm btn-block btn-delete" menu-id="<?= $menu->id ?>">
		                        		<i class=" fa fa-times" aria-hidden="true"></i>
		                        	</button>
		                        </td>
		                    </tr>
		                <?php endforeach ?>
		            <?php endif ?>
		        </tbody>
		    </table>
		</div>
    </div>
</div>