<style type="text/css">
	.sagepay-input-div {
		background: lightgray;
		border: 1px solid lightgray;
		border-radius: 5px;
		margin: 10px 20px 20px 20px;
		padding: 10px;
	}
</style>

<div class="custom-control custom-radio">
	<input type="radio" name="payment_method" id="sagepay" value="sagepay" class="custom-control-input get_tips" >
    <label class="custom-control-label payment-label" for="sagepay"><?= get_sagepay_display_name(); ?></label>
</div>

<div class="sagepay-card-payment" style="display: none">
	<div class="sagepay-input-div">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="card-number">Card Number</label>
    			<input class="form-control" type="number" id="sagepay_card_number" name="sagepay_card_number" placeholder="Ex: 4929000000006" value="4929000000006">
    			<span class="error sagpay-card-error-msg"></span>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<label for="card-number">Expiry Date</label>
				<div class="input-group">
	    			<input class="form-control sagepay-expiry-date" type="number" id="sagepay_expiry_mm" name="sagepay_expiry_date[]" placeholder="MM" maxlength="2" value="12">
	    			<input class="form-control sagepay-expiry-date" type="number" id="sagepay_expiry_yy" name="sagepay_expiry_date[]" placeholder="/YY" maxlength="2" value="26">
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<label for="card-number">CVC</label>
    			<input class="form-control" type="number" id="sagepay_security_code" name="sagepay_security_code" placeholder="Ex: 123" value="123">
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
    			<span class="error sagepay-cvc-date-error-msg"></span>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 error-style">
				<input type="hidden" name="sagepay_status" id="sagepay_status" value="">
				<input type="hidden" name="sagepay_transaction_id" id="sagepay_transaction_id" value="">
				<input type="hidden" name="cres" id="cres" value="">
				<span class="sagepay-error"></span>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).on('input','#sagepay_card_number',function() {
		let cardNumber = $(this).val();
		if (cardNumber) {
			let isValid = /^[0-9]+$/i.test(cardNumber);
			if (isValid == false) {
				$('.btn-process-payment').attr('disabled',true);
				$('.sagpay-card-error-msg').html('Provides numbers only please.');
			} else {
				$('.btn-process-payment').attr('disabled',false);
				$('.sagpay-card-error-msg').html('');
			}
		} else {
			$('.btn-process-payment').attr('disabled',true);
			$('.sagpay-card-error-msg').html('Enter valid card numbers.');
		}
	});

	$(document).on('input','#sagepay_security_code',function() {
		let cvcNumber = $(this).val();
		if (cvcNumber) {
			let isValid = /^[0-9]+$/i.test(cvcNumber);
			if (isValid == false) {
				$('.btn-process-payment').attr('disabled',true);
				$('.sagepay-cvc-date-error-msg').html('Provides numbers only please.');
			} else {
				$('.btn-process-payment').attr('disabled',false);
				$('.sagepay-cvc-date-error-msg').html('');
			}
		} else {
			$('.btn-process-payment').attr('disabled',true);
			$('.sagepay-cvc-date-error-msg').html('Enmter valid card CVC.');
		}
	});

	$(document).on('input','#sagepay_expiry_mm',function() {
		let month = parseInt($(this).val());
		console.log('month: ',month);
		if (month) {
			if (month < 1) {
				$(this).val('01');
			} else if (month > 12) {
				$(this).val('12');
			} else if (month > 9 && month <= 12) {
				$(this).val(month);
			} else if (month >= 1 && month <= 9) {
				$(this).val('0'+month);
			}
			$('.btn-process-payment').attr('disabled',false);
		} else {
			$('.btn-process-payment').attr('disabled',true);
			$('.sagepay-cvc-date-error-msg').html('Enter valid expiry date.');
		}
	});


	$(document).on('input','#sagepay_expiry_yy',function() {
		let year = parseInt($(this).val());
		if (year) {
			if (year < 1) {
				$(this).val('00');
			} else if (year > 99) {
				$(this).val('99');
			} else if (year > 9 && year <= 99) {
				$(this).val(year);
			} else if (year >= 1 && year <= 9) {
				$(this).val('0'+year);
			}
			$('.btn-process-payment').attr('disabled',false);
		} else {
			$('.btn-process-payment').attr('disabled',true);
			$('.sagepay-cvc-date-error-msg').html('Enter valid expiry date.');
		}
	});
</script>