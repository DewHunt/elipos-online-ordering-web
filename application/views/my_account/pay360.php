<div class="custom-control custom-radio">
	<input type="radio" name="payment_method" id="pay360" value="pay360" class="custom-control-input get_tips">
    <label class="custom-control-label" for="pay360">
        <img  class="img-tumbnail" style="width: 100px; height: 40px" src="<?=base_url('assets/images/pay360_logo.png')?>">
    </label>
</div>

<div class="pay360-card-payment" style="display: none">
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label for="card-holder-name">Card Holder Name</label>
				<input type="text" class="form-control" id="card_holder_name" name="card_holder_name">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label for="pan">PAN</label>
				<input type="text" class="form-control" id="pan" name="pan">
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group">
				<label for="cv2-number">CVC Number</label>
				<input type="text" class="form-control" id="cv2_number" name="cv2_number">
			</div>
		</div>		
	</div>

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<?php
					$months = array('01' => 'Jan','02' => 'Feb','03' => 'Mar','04' => 'Apr','05' => 'May','06' => 'June','07' => 'July','08' => 'Aug','09' => 'Sep','10' => 'Oct','11' => 'Nov','12' => 'Dec',);
				?>
				<label for="expiry-month">Expiry Month</label>
				<select class="form-control" id="expiry_month" name="expiry_month">
					<option value="">Select Month</option>
					<?php foreach ($months as $key => $value): ?>
						<option value="<?= $key ?>"><?= $value ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="form-group">
				<label for="expiry-year">Expiry Year</label>
				<select class="form-control" id="expiry_year" name="expiry_year">
					<option value="">Select Year</option>
					<?php
						for ($i = 2021; $i <= 2050; $i++) { 
					?>
							<option value="<?= substr($i,-2) ?>"><?= $i ?></option>
					<?php
						}
					?>
				</select>
			</div>
		</div>
	</div>
</div>