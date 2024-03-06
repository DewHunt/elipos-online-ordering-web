
<script>
    $(document).ready(function () {
        $("form[name='parent_category_save_form']").validate({
            rules: {
                parentCategoryName: "required",
            },
            messages: {
                parentCategoryName: "Please Enter Name",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>