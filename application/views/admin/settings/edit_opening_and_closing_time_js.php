<script>
    $("#edit-timing-form").validate({
        rules: {
            day_id: "required",
            open_time: "required",
            close_time: "required",
        },
        messages: {
            day_id: "Please Select Day",
            open_time: "Please Enter Open Time",
            close_time: "Please Enter Close Time",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
</script>