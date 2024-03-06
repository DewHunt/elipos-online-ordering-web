<?php
	$url = empty($url) ? '' : $url;
	$form_type = empty($form_type) ? '' : $form_type;
	$postcode_id = '';
	$postcode = '';
	$latitude = '';
	$longitude = '';

	if ($postcode_info) {
		$postcode_id = empty($postcode_info->id) ? '' : $postcode_info->id;
		$postcode = empty($postcode_info->postcode) ? '' : $postcode_info->postcode;
		$latitude = empty($postcode_info->latitude) ? '' : $postcode_info->latitude;
		$longitude = empty($postcode_info->longitude) ? '' : $postcode_info->longitude;
	}
?>

<form id="postcodes-form" action="<?= base_url('admin/postcode/postcode_save') ?>" method="post">
	<input type="hidden" name="id" value="<?= $postcode_id ?>">
	<input type="hidden" name="url" value="<?= $url ?>">
	<div class="form-group">
		<label for="email">Postcode:</label>
		<input type="text" class="form-control" id="email" placeholder="Postcode" name="postcode" value="<?= $postcode ?>">
	</div>
	<div class="form-group">
		<label for="pwd">Latitude:</label>
		<input type="text" class="form-control" id="latitude" placeholder="Latitude" name="latitude" value="<?= $latitude ?>">
	</div>
	<div class="form-group">
		<label for="pwd">Longitude:</label>
		<input type="text" class="form-control" id="longitude" placeholder="Longitude" name="longitude" value="<?= $longitude ?>">
	</div>

	<div class="form-group text-right">
		<button type="submit" class="btn btn-primary"><?= $btn_name ?></button>
		<?php if ($form_type == 'edit'): ?>		
			<span type="submit" class="btn btn-danger" id="postcode-delete" postcode_id="<?= $postcode_id ?>">Delete</span>
		<?php endif ?>
		<span type="button" class="btn btn-default" data-dismiss="modal">Close</span>
	</div>
</form>