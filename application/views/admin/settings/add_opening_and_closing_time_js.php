<script>
    $("#add-timing-form").validate({
        rules: {
            day_id: "required",
            open_time: "required",
            close_time: "required",
            sort_order: "required",
            collection_delivery_time: "required",
        },
        messages: {
            day_id: "Please Select Day",
            open_time: "Please Enter Open Time",
            close_time: "Please Enter Close Time",
            sort_order: "Please Enter Sort Order",
            sort_order: "Please Enter Collection Or Delivery Time",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
</script>