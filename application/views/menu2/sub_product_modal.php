<div class="row">   
    <?php if ($sub_products): ?>
        <?php foreach ($sub_products as $sub_product): ?>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 sub-product-col">
                <div class="">
                    <button class="btn btn-block button-sub-product-list btn-sub-prod" data-sub-product-id="<?= $sub_product->selectiveItemId ?>">
                        <span class="pull-left text-white"><?= $sub_product->selectiveItemName ?></span>
                        <span class="pull-right text-white"><?= get_price_text($sub_product->takeawayPrice) ?></span>
                        <?php if ($sub_product->selection_item_description): ?>
                            <span class="pull-left text-white text-left"><?= $sub_product->selection_item_description ?></span>
                        <?php endif ?>
                    </button>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>

<script type="text/javascript">
    $('.btn-sub-prod').click(function() {
        var sub_product_id = $(this).attr('data-sub-product-id');
        console.log(sub_product_id);
        var dish = $(this);
        $.ajax({
            type: "POST",
            url:'<?= base_url('menu/add_to_cart_sub_product') ?>',
            data: {'sub_product_id':sub_product_id},
            success: function (data) {
                if (data['isAddedToCart']) {
                    // show message
                    showSubProductAddedMessage('Successfully added to cart');
                    $('.product-cart-block').html(data['cart_content']);
                    cartScroll();
                } else {
                    $('.sub-product-modifier-modal .modal-body').html(data['modal']);
                    $('.sub-product-modifier-modal').modal('show');
                    addSubProductCart(dish);
                }
                removeItem();
                incrementQty();
                decrementQty();
                itemHover();
            },
            error: function (error) {
                console.log("error");
                removeItem();
                incrementQty();
                decrementQty();
                itemHover();
            }
        });
    });

    function showSubProductAddedMessage($message) {
        var messageHtml = '<div class="alert product-added-message fade show" role="alert">\n' +
            '  <strong>'+$message+'\n' +
            '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
            '    <span aria-hidden="true">&times;</span>\n' +
            '  </button>\n' +
            '</div>';
        $('body').append(messageHtml);
        setTimeout(function(){ $('.product-added-message').remove() }, 2000);
    }
</script>

