<script>
    $(document).ready(function () {
        $("form[name='customer_save_form']").validate({
            rules: {
                title: "required",
                first_name: "required",
                mobile: "required",
            },
            messages: {
                title: "Please Select Title",
                first_name: "Please Enter First Name",
                mobile: "Please Enter Mobile",
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $('#same_as_address_checkbox').click(function () {
            if ($(this).is(":checked")) {
                var billing_address_line_1 = $('#billing_address_line_1').val();
                var billing_address_line_2 = $('#billing_address_line_2').val();
                var billing_city = $('#billing_city').val();
                var billing_postcode = $('#billing_postcode').val();
                $('#delivery_address_line_1').val(billing_address_line_1);
                $('#delivery_address_line_2').val(billing_address_line_2);
                $('#delivery_city').val(billing_city);
                $('#delivery_postcode').val(billing_postcode);
            } else {
                $('#delivery_address_line_1').val('');
                $('#delivery_address_line_2').val('');
                $('#delivery_city').val('');
                $('#delivery_postcode').val('');
            }
        });

    });
</script>