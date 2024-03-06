<script type="text/javascript">
	$(document).on('click','.btn-view',function() {
		var id = $(this).attr('feedback-id');
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/feedback/view') ?>',
            data: {id},
            success: function (data) {
            	$('.view-data').html(data.content);
            	$('.view-feedback-modal').modal('show');
            },
            error: function (error) {
                console.log("error occured");
            }
        });
	});

	$(document).on('click','.btn-status',function() {
		var id = $(this).attr('feedback-id');
		var status = $(this).attr('feedback-status');
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/feedback/change_status') ?>',
            data: {id,status},
            success: function (data) {
            	$('.view-data').html(data.content);
            	$('.view-feedback-modal').modal('show');
            	$('.list-div').html(data.list_table);
                $('.feedback-tab').DataTable({
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
		var id = $(this).attr('feedback-id');
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
		            url:'<?= base_url('admin/feedback/delete') ?>',
		            data: {id},
		            success: function (data) {
		                $('.view-feedback-modal').modal('hide');
            			$('.list-div').html(data.list_table);
		                $('.feedback-tab').DataTable({
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