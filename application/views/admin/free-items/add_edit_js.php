<script>
    $(document).on('click','#productCheckAll',function() {
        $(".product_item_checkbox").prop('checked', $(this).prop('checked'));
    });

    $(document).on('click','.product_item_checkbox',function() {
        var total_checkboxes = $('.product_item_checkbox:checkbox').length;
        var total_checked_checkboxes = $('.product_item_checkbox:checkbox:checked').length;
        if (total_checkboxes == total_checked_checkboxes) {
            $("#productCheckAll").prop("checked", true);
        } else {
            $("#productCheckAll").prop("checked", false);
        }
    });
    
    $(document).on('click','#subProductCheckAll',function() {
        $(".sub_product_item_checkbox").prop('checked', $(this).prop('checked'));
    });

    $(document).on('click','.sub_product_item_checkbox',function() {
        var total_checkboxes = $('.sub_product_item_checkbox:checkbox').length;
        var total_checked_checkboxes = $('.sub_product_item_checkbox:checkbox:checked').length;
        if (total_checkboxes == total_checked_checkboxes) {
            $("#subProductCheckAll").prop("checked", true);
        } else {
            $("#subProductCheckAll").prop("checked", false);
        }
    });
</script>