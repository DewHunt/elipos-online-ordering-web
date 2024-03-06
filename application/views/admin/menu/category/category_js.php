<script>
    $(document).on('change','#parent_category_id',function(e) {
        e.preventDefault();
        var parent_category_id = jQuery('#parent_category_id option:selected').val();
        var status = 'list';
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/food_type/get_food_type_by_parent_catregory_id/") ?>',
            data: {'parent_category_id': parent_category_id, 'status': status},
            success: function (data) {
                //alert(data);
                $("#food_type_id").html(data['options']);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    function active_or_deactive(categoryId,status,fieldName) {
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/category/active_or_deactive_status') ?>',
            data: {categoryId:categoryId,status:status,fieldName:fieldName},
            success: function (data) {
                var categoryInfo = data.categoryInfo;
                var buttonRemoveClass = "";
                var buttonAddClass = "";

                if (categoryInfo.active == 1) {
                    buttonText = 'Active';
                    buttonRemoveClass = 'btn-danger';
                    buttonAddClass = 'btn-success';
                } else {
                    buttonText = 'Deactive';
                    buttonRemoveClass = 'btn-success';
                    buttonAddClass = 'btn-danger';
                }
                $('#active_or_deactive_'+categoryId).html(buttonText);
                $('#active_or_deactive_'+categoryId).attr('onclick','active_or_deactive('+categoryInfo.categoryId+','+categoryInfo.active+',1)');
                $('#active_or_deactive_'+categoryId).removeClass(buttonRemoveClass);
                $('#active_or_deactive_'+categoryId).addClass(buttonAddClass);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    function orderable_or_unorderable(categoryId,status,fieldName) {
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/category/active_or_deactive_status') ?>',
            data: {categoryId:categoryId,status:status,fieldName:fieldName},
            success: function (data) {
                var categoryInfo = data.categoryInfo;
                var buttonRemoveClass = "";
                var buttonAddClass = "";

                if (categoryInfo.orderable == 1) {
                    buttonText = 'Orderabled';
                    buttonRemoveClass = 'btn-danger';
                    buttonAddClass = 'btn-success';
                } else {
                    buttonText = 'Unorderable';
                    buttonRemoveClass = 'btn-success';
                    buttonAddClass = 'btn-danger';
                }
                $('#orderable_or_unorderable_'+categoryId).html(buttonText);
                $('#orderable_or_unorderable_'+categoryId).attr('onclick','orderable_or_unorderable('+categoryInfo.categoryId+','+categoryInfo.orderable+',2)');
                $('#orderable_or_unorderable_'+categoryId).removeClass(buttonRemoveClass);
                $('#orderable_or_unorderable_'+categoryId).addClass(buttonAddClass);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    function highlighted_or_not_highlighted_modal(categoryId,status,fieldName,highlightColor) {
        if (status == 1) {
            highlighted_or_not_highlighted(categoryId,status,fieldName);
        } else {
            $('#highlightedColorModal').modal('show');
            $('#color').val(highlightColor);
            $('#highlight_color').attr('onclick','highlighted_or_not_highlighted('+categoryId+','+status+','+fieldName+')');
            $('#color').colorpicker();
        }
    }

    function highlighted_or_not_highlighted(categoryId,status,fieldName) {
        if (status == 0) {
            var highlightColor = $('#color').val();
            $('#highlightedColorModal').modal('hide');
        } else {
            var highlightColor = "";
        }

        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/category/active_or_deactive_status') ?>',
            data: {categoryId:categoryId,status:status,fieldName:fieldName,highlightColor:highlightColor},
            success: function (data) {
                var categoryInfo = data.categoryInfo;
                var buttonRemoveClass = "";
                var buttonAddClass = "";

                if (categoryInfo.isHighlight == 1) {
                    buttonText = 'Highlighted';
                    buttonRemoveClass = 'btn-default';
                    buttonAddClass = 'btn-primary';
                } else {
                    buttonText = 'Not Highlighted';
                    buttonRemoveClass = 'btn-primary';
                    buttonAddClass = 'btn-default';
                }

                $('#highlighted_or_not_highlighted_'+categoryId).html(buttonText);
                $('#highlighted_or_not_highlighted_'+categoryId).attr('onclick','highlighted_or_not_highlighted_modal('+categoryInfo.categoryId+','+categoryInfo.isHighlight+',3,"'+categoryInfo.highlight_color+'")');
                $('#highlighted_or_not_highlighted_'+categoryId).removeClass(buttonRemoveClass);
                $('#highlighted_or_not_highlighted_'+categoryId).addClass(buttonAddClass);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }
    
    $(document).on('change','.set-unorderable',function() {
        var categoryId = $(this).attr('data-id');
        var dish = $(this);
        var orderable = $(this).is(':checked')?0:1;
        $.ajax({
            type: "POST",
            url:'<?=base_url('admin/category/changeOrderAbleStatus')?>' ,
            data: {categoryId:categoryId,'orderable':orderable},
            success: function (data) {
                var isDeleted = data['is_deleted'];
                if(isDeleted){
                    dish.closest('tr').remove();
                }
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    $(document).on('click','#btn-show',function() {
        var parent_category_id = $('#parent_category_id').val();
        var food_type_id = $('#food_type_id').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/category/search_category/") ?>',
            data: {parent_category_id,food_type_id},
            success: function (data) {
                $('#category-table').html(data.output);
                $('.category-tab').DataTable({
                    "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]]
                });
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });
</script>