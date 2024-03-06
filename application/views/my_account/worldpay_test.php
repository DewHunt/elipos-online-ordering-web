<script src="https://cdn.worldpay.com/v1/worldpay.js"></script>

<form action="/complete" id="paymentForm" method="post">
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
	            <label for="name-on-card">Name On Card</label>
	            <input type="text" class="form-control" data-worldpay="name" name="name" type="text" />
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label for="card-number">Card Number</label>
				<input type="text" class="form-control" data-worldpay="number">
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group">
				<label for="cv2-number">CVC</label>
				<input type="text" class="form-control" data-worldpay="cvc">
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
				<select class="form-control" data-worldpay="exp-month">
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
				<select class="form-control" data-worldpay="exp-year">
					<option value="">Select Year</option>
					<?php
						for ($i = 2021; $i <= 2050; $i++) { 
					?>
							<option value="<?= $i ?>"><?= $i ?></option>
					<?php
						}
					?>
				</select>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12"><input type="submit" class="btn btn-success" value="Place Order"/></div>
	</div>

	<div class="row">
		<div class="col-lg-12"><span id="paymentErrors"></span></div>
	</div>
</form>

<script type="text/javascript">
	var form = document.getElementById('paymentForm');
	console.log(form);
	Worldpay.useOwnForm({
		'clientKey': 'T_C_b27f2147-b934-4ce6-9cd7-12d67e786bef',
		'form': form,
		'reusable': false,
		'callback': function(status, response) {
			document.getElementById ('paymentErrors').innerHTML = '';
			if (response.error) {
				Worldpay.handleError(form, document.getElementById('paymentErrors'), response.error);
			} else {
				var token = response.token;
				alert(token);
				Worldpay.formBuilder(form, 'input', 'hidden', 'token', token);
				form.submit();
			}
		}
	});
</script>
