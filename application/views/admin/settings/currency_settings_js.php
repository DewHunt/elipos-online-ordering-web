<script>
    $(document).ready(function () {
        $("form[name='currency_settings_form']").validate({
            rules: {
                symbol: "required",
                placement: "required",
            },
            messages: {
                symbol: "Please Enter Currency Symbol",
                placement: "Please Select Placement",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>