<script>
    $(document).ready(function () {
        let categoryId = $('#category_id').val();
        let productId = $('#product_id').val();
        search_data({ 'category_id' : categoryId, 'product_id' : productId });
    });

    $("#sub_product_list_form").validate({
        rules: {
            parent_category_id: "required",
            food_type_id: "required",
            category_id: "required",
            product_id: "required"
        },
        messages: {
            parent_category_id: "Please Select Parent Category Name",
            food_type_id: "Please Select Food Type",
            category_id: "Please Select Category",
            product_id: "Please Select Product"
        },
        errorElement: "em",
        errorPlacement: function (error,element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
            error.appendTo(element.parent().parent().after());
        },
        highlight: function (element,errorClass,validClass) {
            $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
        },
        submitHandler: function (form) {
            search_data();
        }
    });

    $(document).on('change','#category_id',function() {
        var category_id = $('#category_id option:selected').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/sub_product/get_product_list_by_category_id/") ?>',
            data: {category_id},
            success: function (data) {
                $(".product_id").html(data['options']);
                $('.select2').select2();
                $("#product_id").select2().trigger('change');
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    function search_data(formData = '') {
        $('.loader').css('display','block');
        if (formData === '') {
            formData = $("#sub_product_list_form").serializeArray();
        }
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/sub_product/search") ?>',
            data: formData,
            success: function (data) {
                $('.table-data-block').html(data['table_data']);
                $('.loader').css('display','none');
                $('.sub-product-list').DataTable({
                    "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]]
                });
            },
            error: function (error) {
                console.log("error occured");
            }
        })
    }

    $(document).on('click','.sub-product-list .btn-delete',function() {
        var foodItemId = $(this).attr('data-id');
        var dish = $(this);

        if(confirm("Are you sure to delete?")){
            $.ajax({
                type: "POST",
                url:'<?= base_url('admin/sub_product/delete') ?>' ,
                data: {'id':foodItemId},
                success: function (data) {
                    var isDeleted = data['is_deleted'];
                    if (isDeleted) {
                        dish.closest('tr').remove();
                    }
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }
    });
</script>