<script>
    $(document).ready(function () {
        $("form[name='customer_save_form']").validate({
            rules: { first_name: "required", },
            messages: { first_name: "Please Enter First Name", },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>