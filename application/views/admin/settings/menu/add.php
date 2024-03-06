<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/menu') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Menu List</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="menu_form" name="menu_form" action="<?= base_url('admin/menu/save') ?>" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<label for="parent">Parent</label>
					<div class="form-group">
						<select class="form-control select2" id="parent-menu-id" name="parent_menu">
							<option value="">Select Parent</option>
							<?php foreach ($menu_lists as $menu): ?>
								<option value="<?= $menu->id ?>"><?= $menu->menu_name ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<label for="menu-name">Menu Name</label>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Menu name" name="menu_name" value="" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<label for="menu-link">Menu Link</label>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Menu link" name="menu_link" value="">
					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<label for="menu-icon">Menu Icon</label>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="fa fa-icon" name="menu_icon" value="">
					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<label for="order-by">Order By</label>
					<div class="form-group">
						<input type="number" class="form-control" placeholder="Order By" id="order-by" name="order_by" value="<?= $order_by ?>" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
					<button class="btn btn-success btn-lg">Save</button>
				</div>
			</div>
        </form>
    </div>
</div>