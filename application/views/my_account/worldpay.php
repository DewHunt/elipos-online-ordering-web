<script src="https://cdn.worldpay.com/v1/worldpay.js"></script >

<div class="custom-control custom-radio">
	<input type="radio" name="payment_method" id="worldpay" value="worldpay" class="custom-control-input get_tips">
    <label class="custom-control-label" for="worldpay">
        <img class="img-tumbnail" style="width: 100px; height: 40px" src="<?= base_url('assets/images/worldpay_logo.jpg') ?>">
    </label>
</div>

<div class="worldpay-card-payment" style="display: none">
	<form action="/complete" id="paymentForm" method="post">
		<div class="row">
			<div class="col-lg-12"><div id='paymentSection'></div></div>
		</div>

		<div class="row">
			<div class="col-lg-12"><input type="submit" value="Place Order" onclick="Worldpay.submitTemplateForm()"/></div>
		</div>

		<div class="row">
			<div class="col-lg-12"><span id="paymentErrors"></span></div>
		</div>
	</form>
</div>

<script type="text/javascript">
	window.onload = function() {
		Worldpay.useTemplateForm({
			'clientKey':'T_C_b27f2147-b934-4ce6-9cd7-12d67e786bef',
			'form':'paymentForm',
			'paymentSection':'paymentSection',
			'display':'inline',
			'reusable':true,
			'callback': function(obj) {
				if (obj && obj.token) {
					var _el = document.createElement('input');
					_el.value = obj.token;
					_el.type = 'hidden';
					_el.name = 'token';
					document.getElementById('paymentForm').appendChild(_el);
					document.getElementById('paymentForm').submit();
				}
			}
		});
	}
</script>