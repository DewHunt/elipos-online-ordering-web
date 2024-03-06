<script type="text/javascript">
    function add_new_loyalty() {
        var rowCount = $('#rowCount').val();
        rowCount++;
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/settings/add_new_loyalty_program') ?>',
            data: {rowCount:rowCount},
            success: function (data) {
                $('#loyalty_program tbody').append(data.output);
                $('#rowCount').val(rowCount);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    function remove_loyalty_program(rowId) {
        var rowStatus = $('#rowStatusId_'+rowId).val();
        if (rowStatus == 'old') {
            $('#colData_'+rowId).css({
                'background':'#d9534f',
                'color':'#fff'
            });

            $('#removeBtnId_'+rowId).css({
                'display':'none'
            });

            $('#restoreBtnId_'+rowId).css({
                'display':'block'
            });

            $('#statusId_'+rowId).css('color','#000');
            $('#rowStatusId_'+rowId).css('color','#000');
            $('#statusId_'+rowId).val("remove");
        } else {
            $('#rowId_'+rowId).remove();
            var rowCount = $('#rowCount').val();
            rowCount--;
            $('#rowCount').val(rowCount);
        }
    }

    function restore_loyalty_program(rowId) {
        $('#colData_'+rowId).css({
            'background':'#fff',
            'color':'#7395b4'
        });

        $('#removeBtnId_'+rowId).css({
            'display':'block'
        });

        $('#restoreBtnId_'+rowId).css({
            'display':'none'
        });

        $('#statusId_'+rowId).val("add");
    }

    $(document).on('change','.offerType',function() {
        var offerTypeValue = $(this).val();
        var rowCount = $(this).attr('row-count');

        if (offerTypeValue === 'others') {
            $('#description_'+rowCount).attr('required',true);
        } else {
            $('#description_'+rowCount).attr('required',false);
        }
    });
</script>