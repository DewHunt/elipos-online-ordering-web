<script>
    $(document).ready(function () {
        $("form[name='product_save_form']").validate({
            rules: {
                parent_category_id: "required",
                food_type_id: "required",
                category_id: "required",
                product_name: "required",
                sort_order: "required",
                table_price: "required",
                takeaway_price: "required",
                bar_price: "required",
                unit: "required",
                vat_rate: "required",
            },
            messages: {
                parent_category_id: "Please Select Parent Category Name",
                food_type_id: "Please Select Food Type",
                category_id: "Please Select Category",
                product_name: "Please Enter Product Name",
                sort_order: "Please Enter Sort Order",
                unit: "Please Select Unit",
                vat_rate: "Please Enter Vat Rate",
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                // Add the `help-block` class to the error element
                error.addClass( "help-block" );
                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.parent( "label" ) );
                } else if (element.hasClass('select2') && element.next('.select2-container').length) {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter( element);
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).parents( ".error-message" ).addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).parents( ".error-message" ).addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: function (form) {
                form.submit();
            }
        });        
    });

    $(document).on('change','#category_id',function() {
        let category_id = $(this).val();
        console.log(category_id);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/product/get_sort_order/") ?>',
            data: {category_id},
            success: function (data) {
                console.log(data);
                $("#sort_order").val(data);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });
</script>