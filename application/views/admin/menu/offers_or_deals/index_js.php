<script type="text/javascript">
    function active_or_deactive(dealId,status,fieldName) {
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/Offers_or_deals/active_or_deactive_status') ?>' ,
            data: {dealId:dealId,status:status,fieldName:fieldName},
            success: function (data) {
                var dealsInfo = data.dealsInfo;
                var buttonRemoveClass = "";
                var buttonAddClass = "";

                if (dealsInfo.active == 1) {
                    buttonText = 'Active';
                    buttonRemoveClass = 'btn-danger';
                    buttonAddClass = 'btn-success';
                } else {
                    buttonText = 'Deactive';
                    buttonRemoveClass = 'btn-success';
                    buttonAddClass = 'btn-danger';
                }

                $('#active_or_deactive_'+dealId).html(buttonText);
                $('#active_or_deactive_'+dealId).attr('onclick','active_or_deactive('+dealsInfo.id+','+dealsInfo.active+',1)');
                $('#active_or_deactive_'+dealId).removeClass(buttonRemoveClass);
                $('#active_or_deactive_'+dealId).addClass(buttonAddClass);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    function orderable_or_unorderable(dealId,status,fieldName) {
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/Offers_or_deals/active_or_deactive_status') ?>' ,
            data: {dealId:dealId,status:status,fieldName:fieldName},
            success: function (data) {
                var dealsInfo = data.dealsInfo;
                var buttonRemoveClass = "";
                var buttonAddClass = "";

                if (dealsInfo.orderable == 1) {
                    buttonText = 'Orderable';
                    buttonRemoveClass = 'btn-danger';
                    buttonAddClass = 'btn-success';
                } else {
                    buttonText = 'Unorderable';
                    buttonRemoveClass = 'btn-success';
                    buttonAddClass = 'btn-danger';
                }

                $('#orderable_or_unorderable_'+dealId).html(buttonText);
                $('#orderable_or_unorderable_'+dealId).attr('onclick','orderable_or_unorderable('+dealsInfo.id+','+dealsInfo.orderable+',2)');
                $('#orderable_or_unorderable_'+dealId).removeClass(buttonRemoveClass);
                $('#orderable_or_unorderable_'+dealId).addClass(buttonAddClass);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    function highlighted_or_not_highlighted(dealId,status,fieldName) {
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/Offers_or_deals/active_or_deactive_status') ?>' ,
            data: {dealId:dealId,status:status,fieldName:fieldName},
            success: function (data) {
                var dealsInfo = data.dealsInfo;
                var buttonRemoveClass = "";
                var buttonAddClass = "";
                console.log(dealsInfo);

                if (dealsInfo.isHighlight == 1) {
                    buttonText = 'Highlighted';
                    buttonRemoveClass = 'btn-default';
                    buttonAddClass = 'btn-primary';
                } else {
                    buttonText = 'Not Highlighted';
                    buttonRemoveClass = 'btn-primary';
                    buttonAddClass = 'btn-default';
                }

                $('#highlighted_or_not_highlighted_'+dealId).html(buttonText);
                $('#highlighted_or_not_highlighted_'+dealId).attr('onclick','highlighted_or_not_highlighted('+dealsInfo.id+','+dealsInfo.isHighlight+',3)');
                $('#highlighted_or_not_highlighted_'+dealId).removeClass(buttonRemoveClass);
                $('#highlighted_or_not_highlighted_'+dealId).addClass(buttonAddClass);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }
</script>