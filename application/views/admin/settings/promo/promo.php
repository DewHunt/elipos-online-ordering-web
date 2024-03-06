<script type="text/javascript">
	$(document).ready(function() {
		$('body').append('<div id="promo-div"></div>');
		$.ajax({
			type: "POST",
			url: "<?= base_url('home/promo'); ?>",
			data: {},
			success: function (data) {
				console.log(data.output);
				$('#promo-div').html(data.output);
			},
			error: function (error) {
			}
		});
	});
</script>