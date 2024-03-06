<div class="error-div">
    <div class="alert alert-danger text-center">
    	<span class="error-msg-text"></span>
    </div>
</div>
<form class="sagepay-input-div" method="POST" action="<?= base_url('cardstream_gateway/cardstream_transaction'); ?>">
	<input type="hidden" id="customer-id" name="customer_id" value="<?= $customer_id ?>">
	<input type="hidden" id="total-amount" name="total_amount" value="<?= $total_amount ?>">
	<input type="hidden" id="card-holder-name" name="card_holder_name" value="<?= $card_holder_name ?>">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="form-group">
				<label for="card-number">Card Number</label>
    			<input class="form-control" type="number" id="card-number" name="card_number" placeholder="Ex: 5301250070000191" value="5301250070000191">
    			<span id="cn-error-msg" class="error"></span>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="form-group">
				<label for="card-number">Expiry Date</label>
				<div class="input-group">
	    			<input class="form-control sagepay-expiry-date" type="number" id="expiry-month" name="expiry_date[]" placeholder="MM" maxlength="2" value="12">
	    			<input class="form-control sagepay-expiry-date" type="text" id="expiry-year" name="expiry_date[]" placeholder="/YY" maxlength="2" value="26">
				</div>
				<span id="emy-error-msg" class="error"></span>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="form-group">
				<label for="card-number">CVC</label>
    			<input class="form-control" type="number" id="cvc" name="security_code" placeholder="Ex: 123" value="419">
				<span id="cvc-error-msg" class="error"></span>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-6">
			<button type="button" class="btn btn-success btn-block" id="cancel-transaction">Cancel Payment</button>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-6">
			<button type="submit" class="btn btn-success btn-block" id="process-transaction">Next</button>
		</div>
	</div>
</form>