<script>
    $("#allowed-miles-add-settings-form").validate({
        rules: {
            delivery_radius_miles: "required",
            delivery_charge: "required",
            min_order_for_delivery: "required",
        },
        messages: {
            delivery_radius_miles: "Please Enter Delivery Radius Miles",
            delivery_charge: "Please Enter Delivery Charge",
            min_order_for_delivery: "Please Enter Min Order for Delivery",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
</script>