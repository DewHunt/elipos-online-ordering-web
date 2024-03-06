<script>
    $(document).on('click','#btn-show',function() {
        var parent_category_id = $('#parentCategoryId').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/food_type/search_food_type/") ?>',
            data: {parent_category_id},
            success: function (data) {
                $('#food-type-table').html(data.output);
                $('.food-type-tab').DataTable({
                    "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]]
                });
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });
</script>