<form id="dine_in_table_form" name="dine_in_table_form" method="post" action="<?= base_url('menu/set_dinein_table_in_session') ?>">
	<div class="row">
		<div class="col-lg-9">
			<div class="form-group">
				<select id="dine_in_table" name="dine_in_table" class="form-control">
					<option value="">Select Your Dine-In Table</option>
					<?php foreach ($table_lists as $table): ?>
						<option value="<?= $table->id ?>"><?= $table->table_number ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>

		<div class="col-lg-3">
			<button type="submit" id="dine_in_table_button" name="dine_in_table_button" class="btn btn-success btn-block">Save</button>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<span style="color: red; font-weight: bold; font-size: 16px;" id="error_message"></span>
		</div>
	</div>
</form>