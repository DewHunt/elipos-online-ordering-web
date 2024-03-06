<style type="text/css">
    .parentMenuBlock{ border: 1px solid #d4c8c8; padding: 10px 0px; margin-bottom: 10px; }
</style>
<?php
	$user_role_id = $this->session->userdata('user_role');
	$root_menu_lists = get_root_menu_list($user_role_id,true);
	$menu_permission = explode(',', $user_role_info->menu_permission);
	// dd($root_menu_lists);
?>


<form id="menu_form" name="menu_form" action="<?= base_url('admin/user_role/update_menu_permission') ?>" method="post" enctype="multipart/form-data">
	<div class="panel panel-default">
		<div class="panel-heading">
		    <div class="row">
		        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
		        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
					<button type="submit" class="btn btn-success">Update</button>
		            <a class="btn btn-info" href="<?= base_url('admin/user_role') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> User Role List</a>
		        </div>
		    </div>
		</div>
	    <div class="panel-body">
			<input type="hidden" name="user_role_id" value="<?= $user_role_info->id ?>">

			<div class="row parentMenuBlock">
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    	<input type="checkbox" class="select_all" name="select_all"> Select All
			    </div>
			</div>

			<?php foreach ($root_menu_lists as $root_menu): ?>
				<?php 
					$checked = checke_menu_permission($root_menu->id,$menu_permission);
			        $parent_menu_lists = get_menu_list($root_menu->id,$user_role_id,true);
				?>

				<div class="row parentMenuBlock">
					<div class="col-lg-12">
	            		<input class="parentMenu_<?= $root_menu->parent_menu ?> menu" type="checkbox" name="user_role_menu[]" value="<?= $root_menu->id ?>" <?= $checked ?>  data-id="<?= $root_menu->id ?>" <?php if ($root_menu->id == 1): ?>onclick="return false" checked<?php endif ?>>&nbsp;<span><?= $root_menu->menu_name ?></span>
	            		<div class="row" style="padding-left: 30px;">
	            			<?php foreach ($parent_menu_lists as $parent_menu): ?>
	                        	<?php
									$checked = checke_menu_permission($parent_menu->id,$menu_permission);
							        $child_menu_lists = get_menu_list($parent_menu->id,$user_role_id,true);
	                        	?>

	                        	<div class="col-lg-3">
	                            	<input class="parentMenu_<?= $parent_menu->parent_menu ?> menu" type="checkbox" name="user_role_menu[]" value="<?= $parent_menu->id ?>" <?= $checked ?>  data-id="<?= $parent_menu->id ?>">&nbsp;<span><?= $parent_menu->menu_name ?></span>

	                            	<div class="row" style="padding-left: 30px;">
	                            		<?php foreach ($child_menu_lists as $child_menu): ?>
				                        	<?php
												$checked = checke_menu_permission($child_menu->id,$menu_permission);
										        $menu_lists = get_menu_list($child_menu->id,$user_role_id,true);
				                        	?>
				                        	<div class="col-lg-12">
	                                        	<input class="parentMenu_<?= $child_menu->parent_menu ?> menu" type="checkbox" name="user_role_menu[]" value="<?= $child_menu->id ?>" <?= $checked ?> data-id="<?= $child_menu->id ?>">&nbsp;<span><?= $child_menu->menu_name ?></span>
	                                        	<div class="row" style="padding-left: 30px;">
	                                        		<?php foreach ($menu_lists as $menu): ?>
							                        	<?php
															$checked = checke_menu_permission($menu->id,$menu_permission);
							                        	?>
							                        	<div class="col-lg-12">
	                                        				<input class="parentMenu_<?= $menu->parent_menu ?> menu" type="checkbox" name="user_role_menu[]" value="<?= $menu->id ?>" <?= $checked ?> data-id="<?= $menu->id ?>">&nbsp;<span><?= $menu->menu_name ?></span>
							                        	</div>
	                                        		<?php endforeach ?>
	                                        	</div>
				                        	</div>
	                            		<?php endforeach ?>
	                            	</div>
	                        	</div>
	            			<?php endforeach ?>
	            		</div>
					</div>
				</div>
			<?php endforeach ?>
	    </div>

		<div class="panel-footer">
			<div class="row">
				<div class="col-lg-12 text-right">
					<button type="submit" class="btn btn-success">Update</button>
				</div>
			</div>
		</div>
	</div>
</form>