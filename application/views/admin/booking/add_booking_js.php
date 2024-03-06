<script  type="text/javascript">
	$("form[name='save_reservation_form']").validate({
		rules: {
			title: "required",
			name: "required",
			mobile: "required",
			email: "required",
			reservation_date:{
				required: true,
			},
			number_of_guest: "required",
		},
		messages: {
			title: "Please select title",
			name: "Please enter name",
			mobile: "Please enter mobile",
			email: "Please enter email",
			reservation_date: {
				required: "Please select reservation date",
			},
			number_of_guest: "Please enter number of guest",
		},
		submitHandler: function (form) {
			form.submit();
		}
	});

	$( "#reservation_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
</script>