<script type="text/javascript">
	$(document).on('click','.btn-status',function() {
		var id = $(this).attr('menu-id');
		var status = $(this).attr('menu-status');
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/menu/change_status') ?>',
            data: {id,status},
            success: function (data) {
            	$('.menu-list-div').html(data.menu_list_table);
                $('.menu-tab').DataTable({
                    "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]]
                });
                Swal.fire({icon: 'info',title: 'Information',text: data.msg});
            },
            error: function (error) {
                console.log("error occured");
            }
        });
	});

	$(document).on('click','.btn-delete',function() {
		var id = $(this).attr('menu-id');
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
		            url:'<?= base_url('admin/menu/delete') ?>',
		            data: {id},
		            success: function (data) {
            			$('.menu-list-div').html(data.menu_list_table);
		                $('.menu-tab').DataTable({
		                    "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]]
		                });
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