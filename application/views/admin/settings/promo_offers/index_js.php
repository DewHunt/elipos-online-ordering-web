<script type="text/javascript">  
    $(document).on('click','.change-status',function(event) {
    	let id = $(this).attr('promo-offers-id');
    	let status = $(this).attr('promo-offers-status');
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/promo_offers/change_status') ?>',
            data: {id,status},
            success: function (data) {
                var promoOffersInfo = data.promoOffersInfo;
                var buttonRemoveClass = "";
                var buttonAddClass = "";

                if (promoOffersInfo.status == 1) {
                    buttonText = 'Active';
                    buttonRemoveClass = 'btn-danger';
                    buttonAddClass = 'btn-success';
                } else {
                    buttonText = 'Deactive';
                    buttonRemoveClass = 'btn-success';
                    buttonAddClass = 'btn-danger';
                }
                $('.po-status-'+id).html(buttonText);
                $('.po-status-'+id).attr('promo-offers-status',promoOffersInfo.status);
                $('.po-status-'+id).removeClass(buttonRemoveClass);
                $('.po-status-'+id).addClass(buttonAddClass);            },
            error: function (error) {
                console.log("error occured");
            }
        });
    })
</script>