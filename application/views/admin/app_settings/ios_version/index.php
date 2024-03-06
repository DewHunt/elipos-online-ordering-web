<?php
	$app_store_url = property_exists($ios_version, 'app_store_url') ? $ios_version->app_store_url : '';
	$package_name = property_exists($ios_version, 'package_name') ? $ios_version->package_name : '';
	$ios_app_id = property_exists($ios_version, 'ios_app_id') ? $ios_version->ios_app_id : '';
	$update_url = property_exists($ios_version, 'update_url') ? $ios_version->update_url : '';
	$current_app_version = property_exists($ios_version, 'current_app_version') ? $ios_version->current_app_version : '';
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4>iOS App Version Information</h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <button class="btn btn-info btn-md edit-app-version <?= $ios_version ? 'show' : 'hide' ?>">
                	<i class="fa fa-edit" aria-hidden="true"></i> Edit
                </button>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table class="table table-striped table-bordered">
            <tbody>
            	<tr>
            		<th width="150px">Current App Version</th>
            		<td id="current_app_version_td"><?= $current_app_version ?></td>
            	</tr>
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4>App Store Information</h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
            	<?php
            		$btn_name = $ios_version ? 'Edit' : 'Add';
            		$btn_icon_name = $ios_version ? 'fa fa-edit' : 'fa fa-plus';
            	?>
                <button class="btn btn-info btn-md add-edit-app-store-info">
                	<i class="<?= $btn_icon_name ?>" aria-hidden="true"></i> <span class="app-store-info-btn-text"><?= $btn_name ?></span>
                </button>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table class="table table-striped table-bordered">
            <tbody>
            	<tr>
            		<th width="150px">App Store URL</th>
            		<td id="app_store_url_td"><?= $app_store_url ?></td>
            	</tr>
            	<tr>
            		<th width="150px">Package Name</th>
            		<td id="package_name_td"><?= $package_name ?></td>
            	</tr>
            	<tr>
            		<th width="150px">Package Name</th>
            		<td id="ios_app_id_td"><?= $ios_app_id ?></td>
            	</tr>
            	<tr>
            		<th width="150px">Update URL</th>
            		<td id="update_url_td"><?= $update_url ?></td>
            	</tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addEditModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">App Store Information</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 app-store-inp-div">
						<div class="form-group">
							<label>App Store URL</label>
        					<input type="text" class="form-control" id="app_store_url" name="app_store_url" placeholder="App Store URL" required>
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 app-store-inp-div">
						<div class="form-group">
							<label>Package Name</label>
        					<input type="text" class="form-control" id="package_name" name="package_name" placeholder="Package Name" required>
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 app-store-inp-div">
						<div class="form-group">
							<label>iOS App ID</label>
        					<input type="text" class="form-control" id="ios_app_id" name="ios_app_id" placeholder="iOS App ID" required>
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 app-store-inp-div">
						<div class="form-group">
							<label>Update URL</label>
        					<input type="text" class="form-control" id="update_url" name="update_url" placeholder="Update URL" required readonly>
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 app-version-inp-div">
						<div class="form-group">
							<label>Current App Version</label>
        					<input type="number" step="1" class="form-control" id="current_app_version" name="current_app_version" placeholder="Current App Version" value="0" required>
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<span class="error-msg"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success save-btn">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>