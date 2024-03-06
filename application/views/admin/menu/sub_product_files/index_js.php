<script>
    $(document).ready(function () {
        $('.product-files-item tr .assign-sub-product-file-item input[type="checkbox"]').click(function(){
            var sub_product_item_id=$(this).val();
            if($(this).is(":checked")){
                assign_sub_product_item(sub_product_item_id);
            }
            else if($(this).is(":not(:checked)")){
                remove_sub_product_item(sub_product_item_id);
            }
            console.log(sub_product_item_id);
        });

        function assign_sub_product_item(sub_product_item_id){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("admin/sub_product_files/assign") ?>',
                data: {'sub_product_item_id': sub_product_item_id,},
                success: function (data) {
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }

        function remove_sub_product_item(sub_product_item_id){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("admin/sub_product_files/remove") ?>',
                data: {'sub_product_item_id': sub_product_item_id,},
                success: function (data) {
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }

        function get_food_type_by_parent_category_id() {
            var parent_category_id = $('#parent_category_id option:selected').val();
            var status = 'add_or_update';
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("admin/food_type/get_food_type_by_parent_catregory_id/") ?>',
                data: {'parent_category_id': parent_category_id, 'status': status},
                success: function (data) {
                    // alert(data);
                    $("#food_type_id").html(data['options']);
                    get_category_by_food_type_id();
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }

        function get_category_by_food_type_id() {
            var food_type_id = $('#food_type_id option:selected').val();
            var status = 'add_or_update';
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("admin/category/get_category_by_food_type_id/") ?>',
                data: {'food_type_id': food_type_id, 'status': status},
                success: function (data) {
                    // alert(data);
                    $("#category_id").html(data['options']);
                    get_product_by_category_id();
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }

        function get_product_by_category_id() {
            var category_id = $('#category_id option:selected').val();
            var status = 'add_or_update';
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("admin/product/get_product_list_by_category_id/") ?>',
                data: {'category_id': category_id, 'status': status},
                success: function (data) {
                    // alert(data);
                    $("#product_id").html(data['options']);
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }
    });

    // var table=  $('#sub-product-files-table').DataTable({
    //     "paging": false
    // });
</script>