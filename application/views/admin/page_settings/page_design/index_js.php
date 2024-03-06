<script type="text/javascript">
	$(document).on('click','.btn-view',function() {
		var id = $(this).attr('design-id');
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/page_management/view_page_design') ?>',
            data: {id},
            success: function (response) {
            	var pageDesign = response.page_design;
            	$('.css-content').html(pageDesign.value);
            	$('#designModal').modal('show');
            },
            error: function (error) {
                console.log("error occured");
            }
        });
	});

	$(document).on('click','.btn-delete',function() {
		var id = $(this).attr('design-id');
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
		            url:'<?= base_url('admin/page_management/delete_page_design') ?>',
		            data: {id},
		            success: function (response) {
		            	console.log('response: ',response);
            			$('.design-list').html(response.list);
		                $('.design-tab').DataTable({
		                    "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]]
		                });
		                Swal.fire({icon: 'info',title: 'Information',text: response.msg});
		            },
		            error: function (error) {
		                console.log("error occured");
		            }
		        });
			}
		})
	});
</script>