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
    <input type="radio" name="payment_method" id="cardstream" value="cardstream" checked>
    <label for="cardstream"><?= get_cardstream_display_name(); ?></label>
</div>

<div class="cardstream-card-payment">
	<div class="sagepay-input-div">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="cardstream-card-number">Card Number</label>
    			<input class="form-control" type="text" id="cardstream_card_number" name="cardstream_card_number" placeholder="Ex: 5301250070000191" value="5301250070000191" required>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<label for="card-number">Expiry Date</label>
				<div class="input-group">
	    			<input class="form-control cardstream-expiry-date" type="text" id="cardstream_expiry_mm" name="cardstream_expiry_date[]" placeholder="MM" maxlength="2" value="12" required>
	    			<input class="form-control cardstream-expiry-date" type="text" id="cardstream_expiry_yy" name="cardstream_expiry_date[]" placeholder="/YY" maxlength="2" value="26" required>
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<label for="cardstream-cvc-number">CVC</label>
    			<input class="form-control" type="text" id="cardstream_security_code" name="cardstream_security_code" placeholder="Ex: 123" value="123" required>
			</div>
		</div>
	</div>
</div>