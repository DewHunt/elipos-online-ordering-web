<style type="text/css">
	.sagepay-input-div {
		background: lightgray;
		border: 1px solid lightgray;
		border-radius: 5px;
		padding: 10px;
	}
</style>

<label for="booking_purpose">Payment</label>
<div class="form-group">
	<input type="radio" name="payment_method" id="sagepay" value="sagepay" checked>
	<label for="sagepay"><?= get_sagepay_display_name(); ?></label>
</div>

<div class="sagepay-input-div">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="card-number">Card Number</label>
			<input class="form-control" type="text" id="sagepay_card_number" name="sagepay_card_number" placeholder="Ex: 4929000000006" value="4929000000006">
		</div>

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<label for="card-number">Expiry Date</label>
			<div class="input-group">
    			<input class="form-control sagepay-expiry-date" type="text" id="sagepay_expiry_mm" name="sagepay_expiry_date[]" placeholder="MM" maxlength="2" value="12">
    			<input class="form-control sagepay-expiry-date" type="text" id="sagepay_expiry_yy" name="sagepay_expiry_date[]" placeholder="/YY" maxlength="2" value="26">
			</div>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<label for="card-number">CVC</label>
			<input class="form-control" type="text" id="sagepay_security_code" name="sagepay_security_code" placeholder="Ex: 123" value="123">
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 error-style">
			<input type="hidden" name="sagepay_status" id="sagepay_status" value="">
			<input type="hidden" name="sagepay_transaction_id" id="sagepay_transaction_id" value="">
			<input type="hidden" name="cres" id="cres" value="">
			<span class="sagepay-error"></span>
		</div>
	</div>
</div>