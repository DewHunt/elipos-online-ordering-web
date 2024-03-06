<script>
    $(document).on('click','.show-sub-product-files',function() {
        var category_id = $('#category_id').val();
        var product_id = $('#product_id').val();

        if (category_id == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<h4><b>Please Select Category</b></h4>',
            });
        } else if (product_id == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<h4><b>Please Select Food Type</b></h4>',
            });
        } else {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("admin/sub_product_files/get_sub_product_files") ?>',
                data: {category_id,product_id},
                success: function (data) {
                    $('.sub-product-files-tables').html(data['table_data']);
                    $('.assign-message').empty();
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }
    });

    $(document).on('change','#category_id',function() {
        var category_id = $('#category_id option:selected').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/sub_product_files/get_product_list_by_category_id/") ?>',
            data: {category_id},
            success: function (data) {
                $(".product_id").html(data['options']);
                $('.select2').select2();
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    $(document).on('click','.select_all',function() {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });

    $(document).on('click','.item-checkbox',function() {
        var total_checkboxes = $('.item-checkbox:checkbox').length;
        var total_checked_checkboxes = $('.item-checkbox:checkbox:checked').length;
        if (total_checkboxes == total_checked_checkboxes) {
            $(".select_all").prop("checked", true);
        } else {
            $(".select_all").prop("checked", false);
        }
    });

    $(document).on('click','.assign-button',function() {
        var all_checkbox = $('.product-files-item tr .assign-sub-product-file-item input[type="checkbox"]');
        if(confirm('Are you sure ?')){
            $('.loader-image').css('display','block');
            $('.assign-button').prop('disabled', true);
            var assign_ids = [];
            var delete_ids = [];
            $(all_checkbox).each(function( index ) {
                var id = $(this).val();
                if ($(this).is(':checked')) {
                    assign_ids.push(id);
                } else {
                    var is_prev_checked = $(this).attr('data-is-prev-checked');
                    if (is_prev_checked) {
                        delete_ids.push(id);
                    }
                }
            });

            var food_item_id = $('#product_id').val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("admin/sub_product_files/do_assign") ?>',
                data: {'assign_ids': assign_ids,'delete_ids':delete_ids,'foodItemId':food_item_id},
                success: function (data) {
                    $('.loader-image').css('display','none');
                    $('.assign-button').prop('disabled', false);
                    $('.assign-message').html('Sub product has been updated successfully.');
                },
                error: function (error) {
                    $('.loader-image').css('display','none');
                    $('.assign-button').prop('disabled', false);
                    $('.assign-message').html('<span class="error">Sub product did not updated successfully.</span>');
                }
            });
        }
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
</script>