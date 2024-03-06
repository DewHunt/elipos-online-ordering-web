

<script type="text/javascript">
	$(document).on('change','#for_collection_active',function() {
		if (this.checked) {
			$('.collection-child-checkbox-div').removeClass('child-checkbox-div-hide');
			$('.collection-child-checkbox-div').addClass('child-checkbox-div-show');
			$('.collection-child').each(function() { this.checked = true; });
			$('#collection_cash_charge').val('<?= $collection_cash_charge ?>');
			$('#collection_card_charge').val('<?= $collection_card_charge ?>');
		} else {
			$('.collection-child-checkbox-div').removeClass('child-checkbox-div-show');
			$('.collection-child-checkbox-div').addClass('child-checkbox-div-hide');
			$('.collection-child').each(function() { this.checked = false; });
			$('#collection_cash_charge').val(0);
			$('#collection_card_charge').val(0);
		}
	});

	$(document).on('change','#for_delivery_active',function() {
		if (this.checked) {
			$('.delivery-child-checkbox-div').removeClass('child-checkbox-div-hide');
			$('.delivery-child-checkbox-div').addClass('child-checkbox-div-show');
			$('.delivery-child').each(function() { this.checked = true; });
			$('#delivery_cash_charge').val('<?= $delivery_cash_charge ?>');
			$('#delivery_card_charge').val('<?= $delivery_card_charge ?>');
		} else {
			$('.delivery-child-checkbox-div').removeClass('child-checkbox-div-show');
			$('.delivery-child-checkbox-div').addClass('child-checkbox-div-hide');
			$('.delivery-child').each(function() { this.checked = false; });
			$('#delivery_cash_charge').val(0);
			$('#delivery_card_charge').val(0);
		}
	});
</script>