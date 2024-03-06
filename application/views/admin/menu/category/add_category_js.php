<script>
    $(document).ready(function () {
        $("form[name='category_save_form']").validate({
            rules: {
                parent_category_id: "required",
                food_type_id: "required",
                category_type_id: "required",
                category_name: "required",
                sort_order: "required",
            },
            messages: {
                parent_category_id: "Please Select Parent Category",
                food_type_id: "Please Select Food Type",
                category_type_id: "Please Select Category Type",
                category_name: "Please Enter Category Name",
                sort_order: "Please Enter Sort Order",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $('#parent_category_id').change(function (event) {
            event.preventDefault();
            var parent_category_id = $('#parent_category_id option:selected').val();
            console.log(parent_category_id);
            var status = 'add_or_update';
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("admin/food_type/get_food_type_by_parent_catregory_id/") ?>',
                data: {'parent_category_id': parent_category_id, 'status': status },
                success: function (data) {
                    //alert(data);
                    $("#food_type_id").html(data['options']);
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        });
    });
</script>