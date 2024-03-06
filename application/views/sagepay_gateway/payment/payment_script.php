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

	$(document).on('click','#process-transaction',function() {
		const customerId = $('#customer-id').val();
		const cardHolderName = $('#card-holder-name').val();
		const totalAmount = $('#total-amount').val();
		const cardNumber = $('#card-number').val();
		const expiryMonth = $('#expiry-month').val();
		const expiryYear = $('#expiry-year').val();
		const cvc = $('#cvc').val();
		let isCardValid = true;
		$('#cn-error-msg').html('');
		$('#emy-error-msg').html('');
		$('#cvc-error-msg').html('');
		$('.error-msg-text').html('');

		if (cardNumber === '') {
			isCardValid = false;
			$('#cn-error-msg').html('Enter valid card number');
		} else if (/^[0-9]+$/i.test(cardNumber) === false) {
			isCardValid = false;
			$('#cn-error-msg').html('Provides numbers only please.');
		}

		if (expiryMonth === '' || expiryYear === '') {
			isCardValid = false;
			$('#emy-error-msg').html('Enter card expiry date');
		}

		if (cvc === '') {
			isCardValid = false
			$('#cvc-error-msg').html('Enter valid card CVC');
		} else if (/^[0-9]+$/i.test(cvc) === false) {
			isCardValid = false
			$('#cvc-error-msg').html('Provides numbers only please.');
		}

		if (isCardValid === true) {
	        const postData = {
	            'customerId' : customerId,
	            'cardHolderName' : cardHolderName,
	            'number' : cardNumber.replace(/\s/g, ""),
	            'expiryMonth' : expiryMonth,
	            'expiryYear' : expiryYear,
	            'cvc' : cvc,
	            'totalAmount': totalAmount
	        };

			$.ajax({
				type: "POST",
				async: false,
				url: '<?= base_url('sagepay_gateway/sagepay_transaction') ?>',
				data: {postData},
				success: function(response) {
					console.log('response: ', response);
	                // console.log(response);
	                const isValid = response.isValid;
	                if (isValid) {
	                    const data = response.transactionInfo;
	                    // console.log('data', data);
	                    if ('status' in data) {
	                        const transactionId = data.transactionId;
	                        const status_code = data.statusCode;
	                        const status = data.status;
	                        if (status == 'Ok') {
	                            // form.submit();
	                        } else if (status == '3DAuth') {
	                            if ('paReq' in data) {
	                                let pareq = data.paReq;
	                                const acs_url = data.acsUrl;
	                                formData = $('#order_process_form').serialize();
	                                const termUrl = $('#sagePayFallbackForm input[name="TermUrl"]').val();

	                                $('#sagePayFallbackForm').attr('action', acs_url);
	                                $('#sagePayFallbackForm input[name="PaReq"]').val(pareq);
	                                $('#sagePayFallbackForm input[name="MD"]').val(transactionId);
	                                $('#sagePayFallbackForm input[name="TermUrl"]').val(termUrl+formData)
	                                $('#sagePayFallbackForm').submit();
	                            } else if ('cReq' in data) {
	                                let creq = data.cReq;
	                                const acs_url = data.acsUrl;

	                                $('#sagePayChallengeAuthenticationForm').attr('action', acs_url);
	                                $('#sagePayChallengeAuthenticationForm input[name="creq"]').val(creq);
	                                $('#sagePayChallengeAuthenticationForm input[name="threeDSSessionData"]').val(transactionId);
	                                $('#sagePayChallengeAuthenticationForm').submit();
	                            }
	                        } else if (status == 'Rejected') {
	                            $('.error-div').css('display','block');
	                            $('.error-msg-text').html(data.statusDetail);
	                        }
	                    } else {
	                        $('.error-div').css('display','block');
	                        $('.error-msg-text').html(data.description);
	                    }
	                } else {
	                	$('.error-div').css('display','block');
	                	$('.error-msg-text').html(response.msg);
	                }
	                $('.btn-process-payment').css('display', 'block');
	                $('.process-order-loader').css('display', 'none');
				},
				error: function(error) {
					console.log('error: ', error);
				}
			});
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
				window.location.replace("<?= base_url('sagepay_gateway/close/'); ?>")
			}
		});
	});
</script>