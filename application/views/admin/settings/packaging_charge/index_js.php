<script type="text/javascript">
	$(document).on('change','#is_for_collection_active',function() {
		if (this.checked) {
			$('.collection-child-checkbox-div').removeClass('child-checkbox-div-hide');
			$('.collection-child-checkbox-div').addClass('child-checkbox-div-show');
			$('#collection_packaging_charge').val('<?= $collection_packaging_charge ?>');
		} else {
			$('.collection-child-checkbox-div').removeClass('child-checkbox-div-show');
			$('.collection-child-checkbox-div').addClass('child-checkbox-div-hide');
			$('#collection_packaging_charge').val(0);
		}
	});

	$(document).on('change','#is_for_delivery_active',function() {
		if (this.checked) {
			$('.delivery-child-checkbox-div').removeClass('child-checkbox-div-hide');
			$('.delivery-child-checkbox-div').addClass('child-checkbox-div-show');
			$('#delivery_packaging_charge').val('<?= $delivery_packaging_charge ?>');
		} else {
			$('.delivery-child-checkbox-div').removeClass('child-checkbox-div-show');
			$('.delivery-child-checkbox-div').addClass('child-checkbox-div-hide');
			$('#delivery_packaging_charge').val(0);
		}
	});
</script>