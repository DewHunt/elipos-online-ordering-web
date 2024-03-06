<script>
	$(document).on('input','#card-number',function() {
		let cardNumber = $(this).val();
		if (cardNumber) {
			let isValid = /^[0-9]+$/i.test(cardNumber);
			if (isValid == false) {
				$('#process-transaction').attr('disabled',true);
				$('.cn-error-msg').html('Provides numbers only please.');
			} else {
				$('#process-transaction').attr('disabled',false);
				$('.cn-error-msg').html('');
			}
		} else {
			$('#process-transaction').attr('disabled',true);
			$('.cn-error-msg').html('Enter valid card number.');
		}
	});

	$(document).on('input','#cvc',function() {
		let cvcNumber = $(this).val();
		if (cvcNumber) {
			let isValid = /^[0-9]+$/i.test(cvcNumber);
			if (isValid == false) {
				$('#process-transaction').attr('disabled',true);
				$('.cvc-error-msg').html('Provides numbers only please.');
			} else {
				$('#process-transaction').attr('disabled',false);
				$('.cvc-error-msg').html('');
			}
		} else {
			$('#process-transaction').attr('disabled',true);
			$('.cvc-error-msg').html('Enter valid card CVC.');
		}
	});

	$(document).on('input','#expiry-month',function() {
		let month = parseInt($(this).val());
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
			$('#process-transaction').attr('disabled',false);
		} else {
			$('#process-transaction').attr('disabled',true);
			$('#emy-error-msg').html('Enter card expiry date');
		}
	});


	$(document).on('input','#expiry-year',function() {
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
			$('#process-transaction').attr('disabled',false);
		} else {
			$('#process-transaction').attr('disabled',true);
			$('#emy-error-msg').html('Enter card expiry date');
		}
	});

	$(document).on('click','#cancel-transaction',function() {
		Swal.fire({
			title: 'Are you sure?',
			text: "You want to cancel this payment!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				Swal.fire('Canceled!','Your transaction has been canceled.','success');
				window.location.replace("<?= base_url('cardstream_gateway/close/'); ?>")
			}
		});
	});
</script>