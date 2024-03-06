<script>
    $(document).ready(function () {
        $("form[name='sub_product_save_form']").validate({
            rules: {
                parent_category_id: "required",
                food_type_id: "required",
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
                parent_category_id: "Please Select Parent Category Name",
                food_type_id: "Please Select Food Type",
                category_id: "Please Select Category",
                product_id: "Please Select Product",
                sub_product_name: "Please Enter Product Name",
                sort_order: "Please Enter Sort Order",
                vat_rate: "Please Enter Vat Rate",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>