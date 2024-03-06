<script type="text/javascript">
    $(document).on('click','.btn-status',function() {
        var id = $(this).attr('user-role-id');
        var status = $(this).attr('user-role-status');
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/user_role/change_status') ?>',
            data: {id,status},
            success: function (data) {
                $('.user-role-div').html(data.user_role_table);
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.msg,
                });
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    $(document).on('click','.btn-delete',function() {
        var id = $(this).attr('user-role-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {           
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url:'<?= base_url('admin/user_role/delete') ?>',
                    data: {id},
                    success: function (data) {
                        $('.user-role-div').html(data.user_role_table);
                        Swal.fire({icon: 'info',title: 'Information',text: data.msg});
                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
            }
        })
    });
</script>