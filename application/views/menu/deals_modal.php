<style>
    .center { width: 150px; margin: 40px auto; }
    .custom-control-input:checked~.custom-control-indicator { background-color: red!important; }
    .custom-control-input:focus ~ .custom-control-indicator { box-shadow: none !important; }
    .side-dish-as-modifier-category .category-name .card-header { padding: .25rem 0; }
    .deals-modal .totalDealsPrice:before { content: 'Total: '; }
    .deals-modal .card .item-selected { background: red; }
    .deals-modal .card .item-selected a { color: #ffffff; }
    .deals-modal .modifier-selection-block .addOne { display: none; float: right; }

    /* From deal_items.php */
    .deal-block { margin-bottom: 5px }
    .deal-item-body { padding: 0px }

    /* From products_selection.php */
    .product-selection { border-top: 1px solid #cacaca; cursor: pointer; padding: 5px 0px 5px 0px; color: #ffffff; margin-right: 5px; }
    .product-selection:before { content: '☐'; background: #bc0f11; padding: 8px 15px; }
    .product-selection:first-child { border-top: none; }
    .product-selection:last-child { border-bottom: 1px solid #cacaca; }
    .modifier-selection-block { border: 0px solid #00000020; margin: 5px; background: #f8f8f8; }
    .selected:before { color: #ffffff; content: '✔ '; background: #bc0f11; padding: 8px 15px; }
    .product-card { margin: 3px; }
    
    /* From modifier_selection.php */
    .modifier-as-product { color: #2a3f54; }
    .modifier-as-product:not(:first-child) { border-top: 0px solid #00000020; }
    .modifier-as-product:first-child { border-top:none; }
    .modifier { border-bottom: 1px solid #00000020; width: 100%; padding: 10px 5px 10px 5px; vertical-align: -webkit-baseline-middle; }
    .modifier:last-child { border-bottom: none; }
    .modifier-price { margin-left: 5px; margin-right: 5px; }
    .modifier-total-price { margin-right: 0px; }
    .icon-img { height: 25px; width: 25px }
    .add { float: right; border: 1px solid #ffffff; }
    .remove { float: right; margin-top: 3px; margin-right: 0px; }
    .modifier-card { margin-bottom: 5px; }
    .modifier-card-header { margin: 0px; padding: 8px; text-align: center; font-weight: 700; color: #008000; }
    .modifier-card-body { margin: 0px; padding: 0px 0px 5px 0px; }
    .deal-alert { width: 100%; background-color: #fff3cd !important; color: red !important; text-align: center; padding: 5px; margin: 5px 0px; }
</style>

<div class="modal fade deals-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="background: #ffffff">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id=""><strong><?= $deal->title ?></strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="" style="padding: .5rem">
                    <div class=""><?= $deal_items_block ?></div>
                    <div class="" style="border-top: 1px solid #eceeef;padding-top: 15px;margin-top: 15px">
                        <div class="clearfix"></div>
                        <div  style="float:left;">
                            <button type="button" class="deals-add-button" disabled>Add To Basket</button>
                            <a class="adding-to-cart-button-loader" style="display: none"><img src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                            </a>
                        </div>
                        <div style="float: right">
                            <strong id="totalDealsPrice"><?= get_price_text($deal->price) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#add_to_cart_form').on('submit', function (e) {
            e.preventDefault();
            $('.deals-modal .common-btn').css('display','none');
            $('.deals-modal .adding-to-cart-button-loader').css('display','block');
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                    $('.deals-modal').modal('hide');
                    $('.product-cart-block').empty();
                    $('.product-cart-block').html(data);
                },
                error: function (error) {

                }
            });
        });
    });

    var priceSymbol = '<?= get_currency_symbol() ?>';
    var deal = <?= json_encode($deal) ?>;
    var dealItems = <?= json_encode($deals_items) ?>;
    var total_deals_items_limit = <?= $total_deals_items_limit ?>;
    deal.items_details = dealItems;
    dealsPrice = parseFloat(deal.price);
    var dealDetails = new Array();

    $('.product-selection-block .product-selection').click(function () {
        console.log('.product-selection-block .product-selection');
        // check category
        var categoryId = $(this).attr('data-c');
        // check product
        var productId = $(this).attr('data-p');
        // check sub product
        var subProductId = $(this).attr('data-sp');
        var dealId = $(this).parents('div.product-selection-block').attr('data-d');
        // check deals id
        var dealItemId = $(this).parents('div.product-selection-block').attr('data-it');

        console.log('categoryId: ',categoryId);
        console.log('productId: ',productId);
        console.log('subProductId: ',subProductId);
        console.log('dealItemId: ',dealItemId);

        var gId = dealId+'-'+productId+'-'+subProductId+'-'+dealItemId;
        var dealItem = getDealsItemById(dealItemId);
        var productAsModifierLimit = dealItem.productAsModifierLimit;
        var subProductAsModifierLimit = dealItem.subProductAsModifierLimit;

        var itemModifierLimit = null;
        if (subProductId > 0){
            // sub product
            itemModifierLimit = getModifierLimitByDealItemSubProduct(subProductAsModifierLimit,subProductId);
        } else {
            itemModifierLimit = getModifierLimitByDealItemProduct(productAsModifierLimit,productId);
        }
        console.log('itemModifierLimit: ',itemModifierLimit);

        var dealItemLimit = 0;
        if (dealItem) {
            dealItemLimit = dealItem.limit;
        }

        var hasSelectedClass = $(this).hasClass('selected');
        var elements = [];
        var elementId = productId+'-'+subProductId+'-'+dealItemId;
        var element = {'id':elementId,'productId':productId,'subProductId':subProductId,'quantity':1,'modifierLimit':itemModifierLimit,'modifiers':[]};

        var total_deal_item_qty = 0;
        var qty = 1;

        if (hasSelectedClass) {
            console.log('view/deals_modal : not selected');
            $(this).removeClass('selected');
            $(this).parents('.product-card').removeClass('p-selected');
            $(this).parents('.product-card').not('.p-selected').find('.collapse').removeClass('show');
            $('.modifier-selection-block .modifier-as-product .modifier .modifier-qty').text('0');
            $('.modifier-selection-block .modifier-as-product .modifier .modifier-total-price').text('X 0 = '+priceSymbol+''+0);
            $(this).parents('.product-card').not('.p-selected').find('.modifier-selection-block .addOne').hide();
            $(this).parents('.product-card').not('.p-selected').find('.modifier-selection-block .remove').hide();
            $(this).parents('.product-card').not('.p-selected').find('.deal-item-div-'+productId+'-'+subProductId+'-'+dealId).removeClass('deal-item-div-selected-'+dealItemId);
            $(this).parents('.product-card').not('.p-selected').find('.deal-item-div-'+productId+'-'+subProductId+'-'+dealId).css('display','none');

            total_deal_item_qty = parseInt($('.total-deal-item-qty-'+dealItemId).attr('total-deal-item-qty'));
            qty = parseInt($('.item-quantity-'+productId+'-'+subProductId+'-'+dealId).attr('counted-item-qty'));
            total_deal_item_qty = total_deal_item_qty - qty;
            qty = 1;

            if (total_deal_item_qty < 0) { total_deal_item_qty = 0; }
            $('.item-quantity-'+productId+'-'+subProductId+'-'+dealId).attr('counted-item-qty',qty);
            $('.item-quantity-'+productId+'-'+subProductId+'-'+dealId).html(qty);
            $('.total-deal-item-qty-'+dealItemId).attr('total-deal-item-qty',total_deal_item_qty);

            if (dealDetails.length) {
                var itemIndex = -1;
                itemIndex = dealDetails.findIndex(element=>element.id == dealItemId);
                var elements = dealDetails[itemIndex].elements;

                var elementIndex = -1;
                elementIndex = elements.findIndex(element=>element.id == elementId);
                if(elementIndex >= 0){
                    dealDetails[itemIndex].elements.splice(elementIndex,1);
                }

                if(elements.length <= 0){
                    dealDetails.splice(itemIndex,1);
                }
            }
        } else {
            console.log('view/deals_modal : selected');
            $(this).parents('.product-card').addClass('p-selected');
            // $(this).parents('.p-selected').find('.modifier-selection-block .remove').css('display','block');
            $(this).parents('.p-selected').find('.modifier-selection-block .addOne').show();
            $(this).parents('.p-selected').find('.deal-item-div-'+productId+'-'+subProductId+'-'+dealId).css('display','block');
            $(this).parents('.p-selected').find('.deal-item-div-'+productId+'-'+subProductId+'-'+dealId).addClass('deal-item-div-selected-'+dealItemId);
            $(this).parents('.p-selected').find('.collapse').addClass('show');
            $(this).addClass('selected');
            $(this).next('.modifier-selection-block').show();

            total_deal_item_qty = parseInt($('.total-deal-item-qty-'+dealItemId).attr('total-deal-item-qty'));
            qty = parseInt($('.item-quantity-'+productId+'-'+subProductId+'-'+dealId).attr('counted-item-qty'));
            total_deal_item_qty = total_deal_item_qty + qty;
            qty = 1;
            if (total_deal_item_qty >= dealItemLimit) { total_deal_item_qty = dealItemLimit; }
            $('.item-quantity-'+productId+'-'+subProductId+'-'+dealId).attr('counted-item-qty',qty);
            $('.item-quantity-'+productId+'-'+subProductId+'-'+dealId).html(qty);
            $('.total-deal-item-qty-'+dealItemId).attr('total-deal-item-qty',total_deal_item_qty);

            if (dealDetails.length) {                
                var itemIndex = -1;
                itemIndex = dealDetails.findIndex(element=>element.id == dealItemId);
                console.log(itemIndex);
                if (itemIndex >= 0) {
                    var elements = dealDetails[itemIndex].elements;
                    var elementIndex = -1;
                    elementIndex = elements.findIndex(element=>element.id == elementId);
                    if (elementIndex >= 0) {
                        // update
                        dealDetails[itemIndex].elements[elementIndex] = element;
                    } else {
                        // insert new
                        elements.push(element);
                        dealDetails[itemIndex] = {'id':dealItemId,'elements':elements};
                    }
                } else {
                    // insert new
                    elements.push(element);
                    dealDetails.push({'id':dealItemId,'elements':elements});
                }
            } else {
                // insert new
                elements.push(element);
                dealDetails.push({'id':dealItemId,'elements':elements});
            }
        }

        var dealsItemIndex = dealDetails.findIndex(element=>element.id == dealItemId);
        if (dealsItemIndex >= 0) {
            var elements = dealDetails[dealsItemIndex].elements;
            if (elements.length >= dealItemLimit || total_deal_item_qty >= dealItemLimit) {
                setDealsButtonEnable(true);
                // $('.deal-items-div').removeClass('deal-item-div-selected-'+dealItemId);
                // $('.deal-items-div').css('display','none');
                $('.deal-item-div-selected-'+dealItemId).css('display','none');
                $('#accordion'+dealItemId).children('div').not('.p-selected').hide();
                $('#item'+dealItemId).addClass('item-selected');
                $(this).parent('div.product-selection-block').attr('data-it');
                $('.total-deal-item-qty-'+dealItemId).attr('total-deal-item-qty',dealItemLimit);
            } else {
                $('.deal-item-div-selected-'+dealItemId).css('display','block');
                $('#item'+dealItemId).removeClass('item-selected');
                setDealsButtonEnable(false);
                $('#accordion'+dealItemId).children('div').not('.p-selected').show();
            }
        } else {
            setDealsButtonEnable(false);
            $('#item'+dealItemId).removeClass('item-selected');
            $('#accordion'+dealItemId).children('div').not('.p-selected').show();
        }
        setDealsTotalPrice();
        console.log('dealDetails: ',dealDetails);
    });

    function getAlertTemplate(categoryName,message) {
        var template='<div style="width: 100%; background-color: #fff3cd; color: red; text-align: center; padding: 5px; margin: 5px 0px;" class="alert alert-waning alert-dismissable fade show">\n' +
            '<button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
            '<strong>'+categoryName+'!&nbsp;</strong>'+message+'.'+
            '</div>';
        return template;
    }

    /*Add modifiers*/
    $('.modifier-selection-block .modifier-as-product .modifier .addOne').click(function() {
        console.log('add one class');
        var sideDishId = $(this).parents('div.modifier').attr('data-md');
        var sideDishPrice = 0;
        sideDishPrice = $(this).parents('div.modifier').attr('data-pr');
        var dealId = $(this).parents('div.product-selection-block').attr('data-d');
        var dealItemId = $(this).parents('div.product-selection-block').attr('data-it');
        var productId = $(this).parents('div.modifier-selection-block').attr('data-p');
        var subProductId = $(this).parents('div.modifier-selection-block').attr('data-sp');
        var categorytId = $(this).attr('category-id');
        let assignedModifierLimit = $(this).attr('assigned-modifier-limit');
        let modifierCategoryId = $(this).attr('modifier-category-id');
        let lastModifierCategoryId = $(this).attr('last-modifier-category-id');
        let modifierCategoryName = $(this).attr('modifier-category-name');

        console.log('assignedModifierLimit: ',assignedModifierLimit);

        if ((typeof productId == 'undefined ') || (typeof subProductId == 'undefined' ) || (typeof dealItemId == 'undefined')) {
            // 1. if not undefined check product is selected
            // 2. check product and subproduct is exist in deals items
            // 3. check product has this modifiers
            return false;
        }

        var elementId = productId+'-'+subProductId+'-'+dealItemId;

        if (dealDetails.length) {
            var itemIndex = -1;
            itemIndex = dealDetails.findIndex(element=>element.id == dealItemId);
            if (itemIndex >= 0) {
                var elements = dealDetails[itemIndex].elements;
                var elementIndex = -1;
                elementIndex = elements.findIndex(element=>element.id == elementId);
                if (elementIndex >= 0) {
                    var element = dealDetails[itemIndex].elements[elementIndex];
                    var modifiers = element.modifiers;
                    var modifierLimit = element.modifierLimit;
                    var addedModifierQuantity = getAddedModifierQuantity(modifiers);
                    var selectedModifierQuantity = getTotalSelectedModifiers(modifiers,modifierCategoryId);
                    console.log('selectedModifierQuantity: ',selectedModifierQuantity);
                    let alertId = '#deal-alert-'+categorytId+'-'+productId+'-'+subProductId+'-'+modifierCategoryId;
                    if (modifierLimit > addedModifierQuantity) {
                        let qty = 1;
                        let isShow = true;
                        var sideDishIndex = -1;
                        var totalPrice = qty * (parseFloat(sideDishPrice));

                        // find if exist update quantity
                        if (selectedModifierQuantity < assignedModifierLimit) {
                            sideDishIndex = modifiers.findIndex(element=>element.id == sideDishId);
                            if (sideDishIndex >= 0) {
                                console.log('increase side dish quantity');
                                // increase side dish quantity
                                qty = parseInt(modifiers[sideDishIndex].quantity) + 1;
                                totalPrice = qty * (parseFloat(modifiers[sideDishIndex].unitPrice));
                                modifiers[sideDishIndex].quantity = qty;
                            } else {
                                console.log('Push One');
                                // push one
                                modifiers.push({'id':sideDishId,'category_id':modifierCategoryId,'quantity':1,'unitPrice':sideDishPrice})
                            }
                        } else {
                            isShow = false;
                            console.log('Modifier Limit Exceed');
                            $(this).parents('div.card-body').find(alertId).html(getAlertTemplate(modifierCategoryName,'Modifier limit is exceed'));
                            $(this).parents('div.card-body').find(alertId+'.alert').alert();
                            setTimeout(function() {
                                $(this).parents('div.card-body').siblings(alertId).find('.close').alert('close');
                            },5000);
                        }

                        if (isShow) {
                            $(this).parents('div.add').siblings('.remove').find('.modifier-qty').text(qty);
                            $(this).parents('div.add').siblings('.remove').find('.modifier-total-price').text('X '+qty+' = '+priceSymbol+''+totalPrice.toFixed(2));
                            $(this).parents('div.add').siblings('.remove').find('.removeOne').show();
                            $(this).parents('div.add').siblings('.remove').find('.modifier-total-price').show();
                            $(this).parents('div.add').siblings('.remove').show();
                        }
                    }
                    addedModifierQuantity = getAddedModifierQuantity(modifiers);
                    if (modifierLimit <= addedModifierQuantity) {
                        if (lastModifierCategoryId == modifierCategoryId) {
                            $(this).parents('#accordion'+dealItemId+'').find('.collapse').removeClass('show');
                        } else {
                            $(this).parents('div.card-body').find(alertId).html(getAlertTemplate(modifierCategoryName,'Total Modifier limit is exceed.'));
                            $(this).parents('div.card-body').find(alertId+'.alert').alert();
                        }
                    }
                } else {
                    console.log('element not found');
                }
            } else {
                console.log('item not found');
            }
        }
        setDealsTotalPrice();
        console.log('dealDetails: ',dealDetails);
        console.log('----------------------------');
    });


    $('.product-selection-block .product-card .inc-btn').click(function() {
        var deal_id = $(this).parents('div.product-selection-block').attr('data-d');
        var deal_limit = $(this).parents('div.product-selection-block').attr('data-l');
        var deal_item_id = $(this).parents('div.product-selection-block').attr('data-it');
        var deal_product_id = $(this).attr('deal-product-id');
        var deal_sub_product_id = $(this).attr('deal-sub-product-id');

        var total_deal_item_qty = parseInt($('.total-deal-item-qty-'+deal_item_id).attr('total-deal-item-qty'));
        var qty = parseInt($('.item-quantity-'+deal_product_id+'-'+deal_sub_product_id+'-'+deal_id).attr('counted-item-qty'));
        // if ($.isNumeric(total_deal_item_qty) === false) { total_deal_item_qty = 0; }           
        // if ($.isNumeric(qty) === false) { qty = 1; }

        if (total_deal_item_qty < deal_limit) {
            qty = qty + 1;
            total_deal_item_qty = total_deal_item_qty + 1;
        }
        if (qty >= deal_limit) { qty = deal_limit; }
        $('.item-quantity-'+deal_product_id+'-'+deal_sub_product_id+'-'+deal_id).attr('counted-item-qty',qty);
        $('.item-quantity-'+deal_product_id+'-'+deal_sub_product_id+'-'+deal_id).html(qty);
        $('.total-deal-item-qty-'+deal_item_id).attr('total-deal-item-qty',total_deal_item_qty);

        var elementId = deal_product_id+'-'+deal_sub_product_id+'-'+deal_item_id;

        if (dealDetails.length) {
            var itemIndex = -1;
            itemIndex = dealDetails.findIndex(element=>element.id == deal_item_id);
            if (itemIndex >= 0) {
                var elements = dealDetails[itemIndex].elements;
                var elementIndex = -1;
                elementIndex = elements.findIndex(element=>element.id == elementId);
                if (elementIndex >= 0) {
                    var element = dealDetails[itemIndex].elements[elementIndex];
                    if (qty <= deal_limit) {
                        element.quantity = qty;
                    }
                } else {
                    console.log('element not found');
                }
            } else {
                console.log('item not found');
            }
        }

        if (total_deal_item_qty == deal_limit) {
            setDealsButtonEnable(true);
            $('#accordion'+deal_item_id).children('div').not('.p-selected').hide();
            $('#item'+deal_item_id).addClass('item-selected');
            $(this).parent('div.product-selection-block').attr('data-it');
        }
        setDealsTotalPrice();
    });

    $('.product-selector-accordion .product-card .dec-btn').click(function() {
        var deal_id = $(this).parents('div.product-selection-block').attr('data-d');
        var deal_limit = $(this).parents('div.product-selection-block').attr('data-l');
        var deal_item_id = $(this).parents('div.product-selection-block').attr('data-it');
        var deal_product_id = $(this).attr('deal-product-id');
        var deal_sub_product_id = $(this).attr('deal-sub-product-id');

        var total_deal_item_qty = parseInt($('.total-deal-item-qty-'+deal_item_id).attr('total-deal-item-qty'));
        var qty = parseInt($('.item-quantity-'+deal_product_id+'-'+deal_sub_product_id+'-'+deal_id).attr('counted-item-qty'));
        if ($.isNumeric(total_deal_item_qty) === false) { total_deal_item_qty = 0; }           
        if ($.isNumeric(qty) === false) { qty = 1; }

        qty = qty - 1;
        total_deal_item_qty = total_deal_item_qty - 1;
        if (qty <= 0) { qty = 1; }
        if (total_deal_item_qty <= 0) { total_deal_item_qty = 1; }
        $('.item-quantity-'+deal_product_id+'-'+deal_sub_product_id+'-'+deal_id).attr('counted-item-qty',qty);
        $('.item-quantity-'+deal_product_id+'-'+deal_sub_product_id+'-'+deal_id).html(qty);
        $('.total-deal-item-qty-'+deal_item_id).attr('total-deal-item-qty',total_deal_item_qty);

        var elementId = deal_product_id+'-'+deal_sub_product_id+'-'+deal_item_id;
        // var elementId=productId+'-'+subProductId+'-'+dealItemId;

        if (dealDetails.length) {
            var itemIndex = -1;
            itemIndex = dealDetails.findIndex(element=>element.id == deal_item_id);
            if (itemIndex >= 0) {
                var elements = dealDetails[itemIndex].elements;
                var elementIndex = -1;
                elementIndex = elements.findIndex(element=>element.id == elementId);
                if (elementIndex >= 0) {
                    var element = dealDetails[itemIndex].elements[elementIndex];
                    if (qty <= deal_limit) {
                        element.quantity = qty;
                    }
                } else {
                    console.log('element not found');
                }
            }else{
                console.log('item not found');
            }
        }

        if (total_deal_item_qty < deal_limit) {
            $('#item'+deal_item_id).removeClass('item-selected');
            setDealsButtonEnable(false);
            $('#accordion'+deal_item_id).children('div').not('.p-selected').show();
        }
        setDealsTotalPrice();
    });

    $('.modifier-selection-block .modifier-as-product .modifier .removeOne').on(function() {
        var sideDishId = $(this).parents('div.modifier').attr('data-md');
        var dealId = $(this).parents('div.product-selection-block').attr('data-d');
        var productId = $(this).parents('div.modifier-selection-block').attr('data-p');
        var subProductId = $(this).parents('div.modifier-selection-block').attr('data-sp');
        var dealItemId = $(this).parents('div.product-selection-block').attr('data-it');

        var elementId = productId+'-'+subProductId+'-'+dealItemId;

        if ((typeof productId == 'undefined ') || (typeof subProductId == 'undefined') || (typeof dealItemId =='undefined')) {
            return false;
        }

        if (dealDetails.length) {
            var itemIndex = -1;
            itemIndex = dealDetails.findIndex(element=>element.id == dealItemId);
            if(itemIndex >= 0){
                var elements = dealDetails[itemIndex].elements;
                var elementIndex = -1;
                elementIndex = elements.findIndex(element=>element.id==elementId);
                if(elementIndex >= 0){
                    var element = dealDetails[itemIndex].elements[elementIndex];
                    var modifiers = element.modifiers;
                    var qty = 0;
                    var totalPrice = 0;
                    if (modifiers.length > 0) {
                        // find if exist decrease quantity
                        var sideDishIndex = -1;
                        sideDishIndex = modifiers.findIndex(element=>element.id==sideDishId);
                        if (sideDishIndex >= 0) {
                            // increase side dish quantity
                            qty = parseInt(modifiers[sideDishIndex].quantity)-1;
                            if (qty > 0) {
                                totalPrice = qty * (parseFloat(modifiers[sideDishIndex].unitPrice));
                                modifiers[sideDishIndex].quantity = qty;
                            } else {
                                modifiers.splice(sideDishIndex,1);
                                $(this).parents('div.remove').find('.modifier-total-price').hide();
                                $(this).parents('div.remove').find('.removeOne').hide();
                            }
                        } else {
                            $(this).parents('div.remove').find('.modifier-total-price').hide();
                            $(this).parents('div.remove').find('.removeOne').hide();
                        }
                    } else {
                        $(this).parents('div.remove').find('.modifier-total-price').hide();
                        $(this).parents('div.remove').find('.removeOne').hide();
                    }
                    $(this).parents('div.remove').find('.modifier-qty').text(qty);
                    $(this).parents('div.remove').find('.modifier-total-price').text('X '+qty+' = '+priceSymbol+''+totalPrice.toFixed(2));
                }
            }
        }
        setDealsTotalPrice();
    });

    function setDealsTotalPrice() {
        var totalPrice = parseFloat(getModifiersPrice()) + parseFloat(dealsPrice);
        var totalPriceToShow = (parseFloat(totalPrice)).toFixed(2);
        $('#totalDealsPrice').html(priceSymbol+''+totalPriceToShow);
    }

    function setDealsButtonEnable(setEnable = false) {
        var total_qty = 0;
        for (var i = dealDetails.length - 1; i >= 0; i--) {
            var elements = dealDetails[i].elements;
            for (var j = elements.length - 1; j >= 0; j--) {
                total_qty = total_qty + parseInt(elements[j].quantity);
            }
        }
        // console.log(total_qty);
        // if (setEnable && (dealItems.length == dealDetails.length)) {
        if (setEnable && (total_qty == total_deals_items_limit)) {
            if (!$('.deals-add-button').hasClass('common-btn')) {
                $('.deals-add-button').addClass('common-btn');
                $('.deals-add-button').prop( "disabled",false);
            }
        } else {
            if ($('.deals-add-button').hasClass('common-btn')) {
                $('.deals-add-button').removeClass('common-btn');
                $('.deals-add-button').prop( "disabled",true);
            }
        }
    }

    function getDealsItemById(itemId = 0) {
        var delaItems = deal.items_details;
        var itemIndex = -1;
        itemIndex = delaItems.findIndex(element=>element.id == itemId);
        if (itemIndex >= 0) {
            return delaItems[itemIndex];
        } else {
            return null;
        }
    }

    function getModifiersPrice() {
        var totalModifierPrice = 0;
        for (var i = 0; i < dealDetails.length; i = i + 1) {
            var elements = dealDetails[i].elements;
            for (var j = 0; j < elements.length; j = j + 1) {
                var modifiers = elements[j].modifiers;
                for (var k = 0; k < modifiers.length; k = k+ 1) {
                    var modifier = modifiers[k];
                    totalModifierPrice += (parseInt(modifier.quantity)) * (parseFloat(modifier.unitPrice));
                }
            }
        }
        return totalModifierPrice;
    }

    function getAddedModifierQuantity(modifiers) {
        if (modifiers.length > 0){
            var quantity = 0;
            if (Array.isArray(modifiers)) {
                modifiers.forEach(function(element) {
                    quantity = quantity + element.quantity;
                });
            }
            return quantity;
        }
        return 0;
    }

    function getTotalSelectedModifiers(modifiers,modifierCategoryId) {
        if (modifiers.length > 0){
            var total = 0;
            if (Array.isArray(modifiers)) {
                modifiers.forEach(function(element) {
                    if (element.category_id == modifierCategoryId) {
                        total++;
                    }
                });
            }
            return total;
        }
        return 0;
    }

    $('.deals-add-button').click(function () {
        if (dealItems.length == dealDetails.length) {
            $(this).css('display','none');
            $('.deals-modal .adding-to-cart-button-loader').css('display','block');
            $.ajax({
                type: "POST",
                url: '<?= base_url('menu/deals_add_to_cart') ?>',
                data: {'dealId':deal.id,'dealDetails':dealDetails},
                success: function (data) {
                    $('.deals-modal').modal('hide');
                    $('.product-cart-block').empty();
                    $('.product-cart-block').html(data['cart_content']);
                },
                error: function (error) {
                }
            });
        }
    });

    function getModifierLimitByDealItemProduct(productAsModifierLimit,productId) {
        if (typeof productAsModifierLimit == 'string') {
            productAsModifierLimit = JSON.parse(productAsModifierLimit);
        }

        if (productAsModifierLimit) {
            var modifierLimitIndex = -1;
            modifierLimitIndex = productAsModifierLimit.findIndex(element=>element.id == productId);
            if (modifierLimitIndex >= 0) {
                return  productAsModifierLimit[modifierLimitIndex].limit;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function getModifierLimitByDealItemSubProduct(subProductAsModifierLimit,subProductId) {
        if (typeof subProductAsModifierLimit == 'string') {
            subProductAsModifierLimit = JSON.parse(subProductAsModifierLimit);
        }

        if (subProductAsModifierLimit) {
            var modifierLimitIndex = -1;
            modifierLimitIndex = subProductAsModifierLimit.findIndex(element=>element.id == subProductId);
            if (modifierLimitIndex >= 0) {
                return subProductAsModifierLimit[modifierLimitIndex].limit;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    // function getItemElementModifier(dealItem,productId,subProductId,modifierId) {
    //     var modifier = null;
    //     var itemIndex = findDealItemIndex(dealItem);
    //     if (itemIndex >= 0) {
    //         var itemElementId = dealItem.id+'-'+productId+'-'+subProductId;
    //         var itemProducts = dealDetails[itemIndex].itemProducts;
    //         var itemElementIndex = findItemElementIndex(itemProducts,itemElementId);
    //         if (itemElementIndex >= 0) {
    //             // add modifier
    //             // check modifier
    //             var modifiers = itemProducts[itemElementIndex].modifiers;
    //             var itemElementModifierIndex = findItemElementModifierIndex(modifiers,modifierId);
    //             if(itemElementModifierIndex >= 0){
    //                 modifier = modifiers[itemElementModifierIndex];
    //             }
    //         }
    //     }
    //     return modifier;
    // }

    function findDealItemIndex(dealItem) {
        return dealDetails.findIndex(element=>element.id == dealItem.id);
    }

    function findItemElementIndex(itemProducts,id) {
        return itemProducts.findIndex(element=>element.id == id);
    }

    function findItemElementModifierIndex(itemProductsModifiers,id) {
        return  itemProductsModifiers.findIndex(element=>element.SideDishesId == id);
    }

    $('.deals-modal').on('hide.bs.modal', function (e) {
        console.log('dealDetails: ',dealDetails);
        console.log('Deals Modal colsed');
        $('.adding-to-cart-button-loader').css('display','none');
        $('.deals-modal-button').css('display','block');
        dealDetails = new Array();
        console.log('dealDetails: ',dealDetails);
    });
</script>

