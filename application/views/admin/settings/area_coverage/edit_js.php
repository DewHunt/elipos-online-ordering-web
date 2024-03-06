<script>
    $("#allowed-postcodes-edit-settings-form").validate({
        rules: {
            postcode: "required",
            delivery_charge: "required",
            min_order_for_delivery: "required",
        },
        messages: {
            postcode: "Please Enter Postcode",
            delivery_charge: "Please Enter Delivery Charge",
            min_order_for_delivery: "Please Enter Min Order for Delivery",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
</script>