<?php
	$other_settings_id = '';
	$active_reservation = '';
	$redirect_to_online_order = '';

    $other_settings = $this->Settings_Model->get_by(array("name" => 'other_settings'), true);
    if (!empty($other_settings)) {
	    $other_settings_id = get_property_value('id',$other_settings);
        $details = json_decode($other_settings->value);
	    $active_reservation = get_property_value('active_reservation',$details);
	    $redirect_to_online_order = get_property_value('redirect_to_online_order',$details);
    }
?>

<h3>Other Settings</h3>
<hr>
<form id="others_settings_form" method="post" action="<?= base_url('admin/settings/other_settings_save'); ?>">
	<input class="form-control" type="hidden" name="id" value="<?= $other_settings_id ?>">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left: 50px;">
			<div class="form-group">
				<div class="checkbox">
					<?php
						$check = '';
					    if ($active_reservation == 1) {
					    	$check = 'checked';
					    }
					?>
					<input type="hidden" name="active_reservation" value="0">
					<label><input type="checkbox" name="active_reservation" value="1" <?= $check?>>Active Reservation</label>
				</div>
				<div class="checkbox">
					<?php
						$check = '';
					    if ($redirect_to_online_order == 1) {
					    	$check = 'checked';
					    }
					?>
					<input type="hidden" name="redirect_to_online_order" value="0">
					<label><input type="checkbox" name="redirect_to_online_order" value="1" <?= $check ?>>Redirect To Online Order</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
			<button type="submit" class="btn btn-lg btn-success">Save</button>
		</div>
	</div>
</form>