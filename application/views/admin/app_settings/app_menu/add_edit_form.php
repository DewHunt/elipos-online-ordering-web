<style type="text/css">
    .saved-image { width: 100px; height: 100px; margin-top: 8px; }
</style>

<?php
	$id = property_exists($menu_info, 'id') ? $menu_info->id : '';
	$title = property_exists($menu_info, 'title') ? $menu_info->title : '';
	$component = property_exists($menu_info, 'component') ? $menu_info->component : '';
	$path = property_exists($menu_info, 'path') ? $menu_info->path : '';
	$btnColor = property_exists($menu_info, 'btnColor') ? $menu_info->btnColor : '';
	$sortingNumber = property_exists($menu_info, 'sortingNumber') ? $menu_info->sortingNumber : '';
	$homeSortingNumber = property_exists($menu_info, 'homeSortingNumber') ? $menu_info->homeSortingNumber : '';
	$iconName = property_exists($menu_info, 'iconName') ? $menu_info->iconName : '';
	$iconImagePath = property_exists($menu_info, 'iconImagePath') ? $menu_info->iconImagePath : '';
	$homeIconImagePath = property_exists($menu_info, 'homeIconImagePath') ? $menu_info->homeIconImagePath : '';
	$isActive = property_exists($menu_info, 'isActive') ? $menu_info->isActive : '';
	$isShow = property_exists($menu_info, 'isShow') ? $menu_info->isShow : '';
	$showInHome = property_exists($menu_info, 'showInHome') ? $menu_info->showInHome : '';
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4><?= $page_title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/app_settings/app_menu') ?>">
                	<i class="fa fa-hand-o-left" aria-hidden="true"></i> App Menu List
               	</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="menu_form" name="menu_form" action="<?= base_url('admin/app_settings/save_app_menu') ?>" method="post" enctype="multipart/form-data">
        	<input type="hidden" class="form-control" name="id" value="<?= $id ?>">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label for="menu-title">Menu Title</label>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Menu Title" name="title" value="<?= $title ?>">
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label for="menu-component">Menu Component</label>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Menu Component" name="component" value="<?= $component ?>">
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label for="menu-path">Menu Path</label>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Menu Path" name="path" value="<?= $path ?>">
					</div>
				</div>
			</div>

			<div class="row">                
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label for="button-color">Button Color</label>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Button Color" name="btnColor" value="<?= $btnColor ?>">
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label for="menu-order">Menu Order</label>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Menu Order" name="sortingNumber" value="<?= $sortingNumber ?>">
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label for="menu-order-in-home">Menu Order In Home</label>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Menu Order In Home" name="homeSortingNumber" value="<?= $homeSortingNumber ?>">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label for="icon-name">Icon Name</label>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Icon Name" name="iconName" value="<?= $iconName ?>">
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label for="icon-image-path">Icon Image</label>
					<div class="form-group">
                        <input type="hidden" class="form-control" name="previousIconImagePath" value="<?= $iconImagePath; ?>">
						<input type="file" class="form-control" placeholder="Icon Image" name="iconImagePath" value="iconImagePath">
						<?php if ($iconImagePath): ?>
                        	<img class="img-thumbnail saved-image" src="<?= base_url($iconImagePath); ?>">
						<?php endif ?>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label for="home-icon-image">Home Icon Image</label>
					<div class="form-group">
                        <input type="hidden" class="form-control" name="previousHomeIconImagePath" value="<?= $homeIconImagePath; ?>">
						<input type="file" class="form-control" placeholder="Home Icon Image" name="homeIconImagePath" value="homeIconImagePath">
						<?php if ($homeIconImagePath): ?>							
                        	<img class="img-thumbnail saved-image" src="<?= base_url($homeIconImagePath); ?>">
						<?php endif ?>
					</div>
				</div>
			</div>

			<div class="row">				
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <label for="status">Status</label>
                    <div class="form-group">
                        <label for="is-active" class="checkbox-inline">
                            <input type="hidden" name="isActive" value="0">
                            <input type="checkbox" name="isActive" id="is-active" value="1" <?= $isActive ? 'checked' : '' ?>> Active
                        </label>

                        <label for="is-show" class="checkbox-inline">
                            <input type="hidden" name="isShow" value="0">
                            <input type="checkbox" name="isShow" id="is-show" value="1" <?= $isShow ? 'checked' : '' ?>> Show In Menu
                        </label>

                        <label for="show-in-home" class="checkbox-inline">
                            <input type="hidden" name="showInHome" value="0">
                            <input type="checkbox" name="showInHome" id="show-in-home" value="1" <?= $showInHome ? 'checked' : '' ?>> Show In Home
                        </label>
                    </div>
                </div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
					<button class="btn btn-success btn-lg"><?= $btnName ?></button>
				</div>
			</div>
        </form>
    </div>
</div>