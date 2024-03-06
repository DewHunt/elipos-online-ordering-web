<div class="error-div">
    <div class="alert alert-danger text-center">
    	<span class="error-msg-text"></span>
    </div>
</div>
<div class="sagepay-input-div">
	<input type="hidden" id="customer-id" name="customer_id" value="<?= $customer_id ?>">
	<input type="hidden" id="total-amount" name="total_amount" value="<?= $total_amount ?>">
	<input type="hidden" id="card-holder-name" name="card_holder_name" value="<?= $card_holder_name ?>">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="form-group">
				<label for="card-number">Card Number</label>
    			<input class="form-control" type="number" id="card-number" name="card-number" placeholder="Ex: 4929000000006" value="4929000000006">
    			<span id="cn-error-msg" class="error"></span>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="form-group">
				<label for="card-number">Expiry Date</label>
				<div class="input-group">
	    			<input class="form-control sagepay-expiry-date" type="number" id="expiry-month" name="expiry_date[]" placeholder="MM" maxlength="2" value="2">
	    			<input class="form-control sagepay-expiry-date" type="number" id="expiry-year" name="expiry_date[]" placeholder="/YY" maxlength="2" value="26">
				</div>
				<span id="emy-error-msg" class="error"></span>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="form-group">
				<label for="card-number">CVC</label>
    			<input class="form-control" type="number" id="cvc" name="cvc" placeholder="Ex: 123" value="123">
				<span id="cvc-error-msg" class="error"></span>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-6">
			<button type="button" class="btn btn-success btn-block" id="cancel-transaction">Cancel Payment</button>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-6">
			<button type="button" class="btn btn-success btn-block" id="process-transaction">Next</button>
		</div>
	</div>
</div>

<form id="sagePayFallbackForm" method="post" action="">
    <input type="hidden" name="PaReq" value="">
    <input type="hidden" name="TermUrl" value="<?= base_url('order/order_process?') ?>">
    <input type="hidden" name="MD" value="">
</form>

<form id="sagePayChallengeAuthenticationForm" method="post" action="">
    <input type="hidden" name="creq" value=""/>
    <input type="hidden" name="threeDSSessionData" value=""/>
</form>