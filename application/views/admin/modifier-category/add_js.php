<script>
    $(document).ready(function () {
        $("form[name='modifier_category_save_form']").validate({
            rules: {
                ModifierCategoryName: "required",
                SortOrder: "required",
                ModifierLimit: "required",
            },
            messages: {
                 ModifierCategoryName: "Name Rrequired",
                ModifierLimit: "Limit required",
                SortOrder: "Sort order required"
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>