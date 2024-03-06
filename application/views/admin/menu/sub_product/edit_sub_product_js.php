<script>
    $(document).ready(function () {
        $("form[name='sub_product_update_form']").validate({
            rules: {
                category_id: "required",
                product_id: "required",
                sub_product_name: "required",
                sort_order: "required",
                table_price: "required",
                takeaway_price: "required",
                bar_price: "required",
                vat_rate: "required",
            },
            messages: {
                category_id: "Please Select Category",
                product_id: "Please Select Product",
                sub_product_name: "Please Enter Product Name",
                sort_order: "Please Enter Sort Order",
                vat_rate: "Please Enter Vat Rate",
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.parent("label"));
                } else if (element.hasClass('select2') && element.next('.select2-container').length) {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element,errorClass,validClass) {
                $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element,errorClass,validClass) {
                $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
            },
            submitHandler: function (form) {
                form.submit();
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
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        });

        $(document).on('change','#product_id',function() {
            let product_id = $(this).val();
            console.log(product_id);
            $.ajax({
                type: 'POST',
                url: '<?= base_url('admin/sub_product/get_sort_order/') ?>',
                data: {product_id},
                success: function (data) {
                    $('#sort_order').val(data);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>