<script>
    $(document).ready(function () {
        $("form[name='food_type_update_form']").validate({
            rules: {
                parentCategoryId: "required",
                foodTypeName: "required",
            },
            messages: {
                parentCategoryId: "Please Select Parent Category",
                foodTypeName: "Please Enter Name",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>