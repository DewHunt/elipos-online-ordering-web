<script type="text/javascript">
    cartScroll();
    function cartScroll() {
        var height = $('.cartscroll').height();
        if (height >= 300) {
            $('.cartscroll').css({'overflow-y':'scroll','margin-right':'0'})
        } else {
            $('.cartscroll').css({'overflow-y':'auto','margin-right':'10px'})
        }
        if(!$('body').hasClass('mobile')){
            const lastRow = $('.table-cart-details tr:last').get(0);
            if (lastRow) {
                lastRow.scrollIntoView();
            }
        } else {
            setTimeout(function () { $('.cartscroll').css({'overflow': 'auto'}); },5);
        }
    }
</script>


<?php
    // dd($this->cart->contents());
    if (is_home_promo_active_for_menu()){
        $this->load->view('home/promo_modal');
    }
    echo $shop_open_close_modal;

    $categories = $product_object->get_categories_menu_by_flags();
    $dealsCategories = $product_object->get_deals_categories_menu_by_flags();
    $products = $product_object->get_products_menu_by_flags();
    $side_dishes = $product_object->get_side_dish();
    $all_sub_products = $product_object->get_all_sub_products();
    $dealsName = $product_object->get_offers_or_deals_name();
    $dealsId = str_replace(' ', '-', $dealsName);

    $all_data = array(
        'categories' => $categories,
        'dealsCategories' => $dealsCategories,
        'products' => $products,
        'all_sub_products' => $all_sub_products,
        'dealsName' => $dealsName,
        'dealsId' => $dealsId,
    );
?>

<!-- Mobile View -->
<div class="row no-padding no-margin sticky-top d-sm-none product-category-mobile-menu-block" style="background: #ffffff;display: none">
    <div class="col-12" style="padding-top:10px; height: 50px">
        <h6 class="categoryNameTitle" style="float: left"></h6>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#categoryNav">
            <i class="fa fa-bars" style="color: red; border: 1px solid red; padding: 2px 10px;"></i>
        </button>
    </div>
    <div class="col-12">
        <nav style="width: 100%;margin-top: 5px">
            <div class="collapse navbar-collapse" id="categoryNav">
                <div class="product-category-mobile-menu">
                    <?php $this->load->view('menu2/categories', $all_data); ?>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="menu-page">
    <div class="content-info"><?php $this->load->view('menu2/info'); ?></div>
    <div class="content-menu">
        <div class="row no-margin no-padding">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="padding-left: 0">
                <div class="content-menu-tab d-none d-sm-block">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item "><a class="nav-link active" data-toggle="tab" href="#product-menu" role="tab">Menu</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#info" role="tab">Info</a></li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane  show active" id="product-menu" role="tabpanel">
                        <div class="row no-margin no-padding">
                            <div class="col-lg-5 col-md-5 col-sm-4 col-xs-12 no-margin no-padding d-none d-sm-block category-box">
                                <div class="menu-category-list-block">
                                    <?php $this->load->view('menu2/categories', $all_data); ?>
                                </div>
                            </div>
                            <div id="product-as-category" class="col-lg-7 col-md-7 col-sm-8 col-xs-12 no-margin no-padding">
                                <?php $this->load->view('menu2/product_as_category', $all_data); ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="info" role="tabpanel">
                        <?php $this->load->view('menu2/tab_info'); ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 no-padding no-margin ">
                <div class="content-cart"><?= $cart_content ?></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade sub-product-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="background: transparent">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title no-padding" id="exampleModalLabel"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="product-modal-block"></div>
<div class="deals-modal-block"></div>

<div class="free-item-modal-block"><?php //echo $free_item_modal_content; ?></div>

<?php $this->load->view('menu/common_script'); ?>

<?php $isMobile = $this->agent->is_mobile(); ?>

<?php if ($isMobile): ?> 
    <div class="mobile-cart-block">
        <?php $this->load->view('cart/mobile'); ?>
    </div>
<?php endif ?>

<div class="modal fade sub-product-modifier-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="background: #ffffff">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adding To Cart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var flashMsg = '<?php echo $this->session->flashdata('order_type_error_message'); ?>';
        if (flashMsg) {
            showProductAddedMessage(flashMsg);
        }
    });

    $(document).on('click','.checkout_button',function (e) {
        var order_type_value = '<?php echo get_sess_order_type() ?>';
        var table_id = '<?php echo $this->session->userdata('dine_in_table_number_id') ?>';
        var checkout_type = $(this).attr('checkout-type');
        <?= $this->session->unset_userdata('tips_amount'); ?>

        if (order_type_value == 'dine_in' && table_id == '') {
            var message = "Please Select Your Desire Table";
            $('.orderTypeMissMatch .modal-body .message').html(message);
            $('.orderTypeMissMatch').modal('show');
            return false;
        } else {
            if (checkout_type == 'guest') {
                window.location = 'my_account/login_action?email=guest@gmail.com&password=<?php echo sha1(12345)?>&login_type=guest';
                return false;
            } else {
                return true;
            }
        }
    });

    $('.menu-category-list-block').sticky({topSpacing: 0});
    $('.content-cart').sticky({topSpacing: 0});
    $('.menu-category-list-block ul li').removeClass('active');
    $('.menu-category-list-block ul li').click(function () {
        $('.menu-category-list-block ul li').removeClass('active');
        $(this).addClass('active');
    });

    $('#accordion-category .category-header').click(function () {
        // $('#accordion-category .collapse').removeClass('show');
        var categoryId = $(this).parents('div.card').attr('id');
        if (!$('.cuisinesearch-menu ul li a[href="#' + categoryId + '"]').hasClass('active')) {
            $('.cuisinesearch-menu ul li a').removeClass('active');
            $('.cuisinesearch-menu ul li a[href="#' + categoryId + '"]').addClass('active');
        }

        if ($(this).parents('div.card-header').find('.expand-plus-minus .fa').hasClass('fa-plus')) {
            $('.expand-plus-minus .fa').removeClass('fa-minus');
            $('.expand-plus-minus .fa').addClass('fa-plus');
            $(this).parents('div.card-header').find('.expand-plus-minus .fa').removeClass('fa-plus');
            $(this).parents('div.card-header').find('.expand-plus-minus .fa').addClass('fa-minus');
        } else if ($(this).parents('div.card-header').find('.expand-plus-minus .fa').hasClass('fa-minus')) {
            $('.expand-plus-minus .fa').removeClass('fa-minus');
            $('.expand-plus-minus .fa').addClass('fa-plus');
            $(this).parents('div.card-header').find('.expand-plus-minus .fa').removeClass('fa-minus');
            $(this).parents('div.card-header').find('.expand-plus-minus .fa').addClass('fa-plus');
        }
        $(this).toggleClass('show');
        // $(this +'.expand-plus-minus i').toggleClass('fa-minus','fa-plus');
    });

    var url = window.location.href;
    var category_id='';
    if (url.search("#") > 0) {
        category_id = url.substring(url.lastIndexOf('#') + 0);
    } else {
        category_id = url.substring(url.lastIndexOf('/') + 100);
    }
    
    if (category_id !== '') {
        $(category_id).addClass('category-header-active');
        $('.cuisinesearch-menu ul li a[href="' + category_id + '"]').addClass('active');
    }

    if (category_id !== '' && !$(category_id + ' div.collapse').hasClass('show')) {
        $(category_id + ' div.collapse').addClass('show');
        $(category_id + ' .expand-plus-minus .fa').removeClass('fa-plus');
        $(category_id + ' .expand-plus-minus .fa').addClass('fa-minus');
    }

    $('.product').click(function () {
        console.log('sub-product');
        console.log($(this).has('.get-sub-product-button').length !== 0);
        if ($(this).has('.get-sub-product-button').length !== 0) {
            var product_id = $(this).find('.get-sub-product-button').attr('data-product-id');
            $(this).find('.get-sub-product-button').css('display', 'none');
            $(this).find('.get-sub-product-button').siblings('.adding-to-cart-button-loader').css('display', 'block');

            var dish = $(this).find('.get-sub-product-button');
            $.ajax({
                type: "POST",
                url: '<?= base_url('menu/get_sub_product') ?>',
                data: {'product_id': product_id},
                success: function (data) {
                    if (data['status'] === true) {
                        $('.sub-product-modal .modal-body').empty();
                        $('.sub-product-modal .modal-title').text(data['productName']);
                        $('.sub-product-modal .modal-body').html(data['modal']);
                        $('.sub-product-modal').css('top','150px');
                        $('.sub-product-modal').modal('show');
                    } else {
                        var message = "This Product's available for <span style='text-transform: capitalize'>"+data['product_order_type']+"</span> Order";
                        $('.orderTypeMissMatch .modal-body .message').html(message);
                        $('.orderTypeMissMatch').modal('show');
                    }

                    $('.modal-backdrop').css('display', 'none');
                    dish.css('display', 'block');
                    dish.siblings('.adding-to-cart-button-loader').css('display', 'none');
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
        } else {
            var product_id = $(this).find('.adding-to-cart-button').attr('data-product-id');
            console.log('pro', product_id);
            $(this).find('.adding-to-cart-button').css('display','none');
            $(this).find('.adding-to-cart-button').siblings('.adding-to-cart-button-loader').css('display','block');
            var dish = $(this).find('.adding-to-cart-button');
            $.ajax({
                type: "POST",
                url: '<?= base_url('menu/get_product') ?>',
                data: {'product_id': product_id},
                success: function (data) {
                    if (data['status'] === true) {
                        $('.product-modal-block').html(data['modal']);
                        addProductCart(dish);
                    } else {
                        var message = "This Product's available for <span style='text-transform: capitalize'>"+data['product_order_type']+"</span> Order";
                        $('.orderTypeMissMatch .modal-body .message').html(message);
                        $('.orderTypeMissMatch').modal('show');
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
        }
    });

    $('.orderTypeMissMatch').on('hidden.bs.modal', function () {
        $('.product').find('.adding-to-cart-button').css('display','block');
        $('.product').find('.adding-to-cart-button').siblings('.adding-to-cart-button-loader').css('display','none');
        $('.deals-modal-button').css('display','block');
        $('.deals-modal-button').siblings('.adding-to-cart-button-loader').css('display','none');
    });

    function addProductCart(event) {
        $('#add_to_cart_form').on('submit', function (e) {
            e.preventDefault();
            $('#add_to_cart_form .common-btn').css('display', 'none');
            $('#add_to_cart_form .adding-to-cart-button-loader').css('display', 'none');
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                    $('.product-modal').modal('hide');
                    $('.product-cart-block').empty();
                    $('.product-cart-block').html(data['cart_content']);
                    $('.mobile-cart-block').html(data['mobile_cart']);
                    event.css('display', 'block');
                    event.siblings('.adding-to-cart-button-loader').css('display', 'none');
                    cartScroll();
                    showProductAddedMessage('Successfully added to cart');
                    removeItem();
                    incrementQty();
                    decrementQty();
                    itemHover();

                },
                error: function (error) {
                    removeItem();
                    incrementQty();
                    decrementQty();
                    itemHover();
                }
            });
        });

        $('.product-modal').on('hidden.bs.modal', function (e) {
            // do something...
            $('.adding-to-cart-button').css('display', 'block');
            $('.adding-to-cart-button').siblings('.adding-to-cart-button-loader').css('display', 'none');
        })
    }

    function addSubProductCart(event) {
        $('#add_to_cart_sub_product_form').on('submit', function (e) {
            e.preventDefault();
            $('#add_to_cart_sub_product_form .common-btn').css('display', 'none');
            $('#add_to_cart_sub_product_form .adding-to-cart-button-loader').css('display', 'none');
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                    $('.sub-product-modifier-modal').modal('hide');
                    $('.product-cart-block').html(data['cart_content']);
                    $('.mobile-cart-block').html(data['mobile_cart']);
                    event.css('display', 'block');
                    event.siblings('.adding-to-cart-button-loader').css('display', 'none');
                    cartScroll();
                    showProductAddedMessage('Successfully added to cart');
                    removeItem();
                    incrementQty();
                    decrementQty();
                    itemHover();
                },
                error: function (error) {
                    removeItem();
                    incrementQty();
                    decrementQty();
                    itemHover();
                }
            });
        });

        $('.sub-product-modifier-modal').on('hidden.bs.modal', function (e) {
            $('.get-sub-product-button').css('display', 'block');
            $('.get-sub-product-button').siblings('.adding-to-cart-button-loader').css('display', 'none');
        })
    }

    function showProductAddedMessage($message) {
        if ($message == '') { $message = 'Successfully added to cart'; }
        var messageHtml = '';
        messageHtml += '<div class="alert product-added-message fade show" role="alert">';
        messageHtml += '<strong>'+$message+'</strong>';
        messageHtml += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        messageHtml += '<span aria-hidden="true">&times;</span>';
        messageHtml += '</button>';
        messageHtml += '</div>';

        $('body').append(messageHtml).fadeIn();
        $('.product-added-message ').fadeOut(2000, 'linear');
    }

    function menucontentarea_width_allocation() {
        var width = $(window).width();
        console.log(width);
        if (width > 480) {
            var nav_tabs_width = $('.menutabarea .nav-tabs').width();
            var menucontentarea_width = $('.menucontentarea').width();
            var menucontentarea_grid1_width = nav_tabs_width;
            var menucontentarea_grid2 = menucontentarea_width - nav_tabs_width - 2;

            $('.menucontentarea_grid1').css('width', menucontentarea_grid1_width + 'px');
            $('.menucontentarea_grid2').css('width', menucontentarea_grid2 + 'px');
        } else {
            $('.menucontentarea_grid1').css('width', 0 + 'px');
            $('.menucontentarea_grid2').css('width', '100%');
        }
    }

    $(window).resize(function () {
        menucontentarea_width_allocation();
        // responsive_banner(windows_height,windows_width);
    });


    $('.browse ul li a').click(function () {
        $('.cuisinesearch-menu ul li a').removeClass('active');
        $('.showmenu .category-name-header').removeClass('category-header-active');
        var cat = $(this).attr('data-cat');
        $('.cuisinesearch-menu ul li a[href="' + cat + '"]').addClass('active');
        $(cat).addClass('category-header-active');

        if (cat !== '' && !$(cat + ' div.collapse').hasClass('show')) {
            $('.collapse').removeClass('show');
            $(cat + ' div.collapse').addClass('show');
            $('.expand-plus-minus .fa').removeClass('fa-minus');
            $('.expand-plus-minus .fa').addClass('fa-plus');

            $(cat + ' .expand-plus-minus .fa').removeClass('fa-plus');
            $(cat + ' .expand-plus-minus .fa').addClass('fa-minus');
        }
    });

    var cart = [];
    var isDiscountAvailable = false;
    var discountType = 'amount';
    var discountPercent = 0;
    var discountAmount = 0;
    var products = <?= json_encode($products) ?>;
    var subProducts = <?= json_encode($all_sub_products) ?>;

    function getTotalAmount() {
        var sum = 0;
        if (!cart || !cart.length) { return sum; }
        for (var i = 0; i < cart.length; i = i + 1) {
            sum = sum + cart[i].quantity * cart[i].item.price;
        }
        return sum;
    }

    function getTotalItem() {
        return getCart().length;
    }

    function removeCartItem(index) {
        cart.splice(index, 1);
        setCart(cart);
        presentToast('Product has been removed');
    }


    function setCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    function clearCart() {
        cart = [];
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    function getCart() {
        return cart;
    }

    function insert(data) {
        if (cart.length) {
            var itemIndex = -1;
            itemIndex = cart.findIndex(element => element.id == data.id);
            if (itemIndex >= 0) {
                cart[itemIndex].quantity = cart[itemIndex].quantity + 1;
            } else {
                cart.push(data);
            }
        } else {
            cart.push(data);
        }
    }

    function getProduct(productId) {
        var product = products.filter(function (product) {
            return product.foodItemId == productId;
        });

        if (product.length > 0) {
            return product[0]
        } else {
            return null;
        }
    }

    function getSubProducts(productId) {
        var subProducts = subProducts.filter(function (subProduct) {
            return subProduct.foodItemId == productId;
        });
        return subProducts;
    }

    function getSubProductModal(productId) {
        var subProducts = getSubProducts(productId);

        if (subProducts.length > 0) {
            $.each(subProducts, function (index, subProduct) {});
        }
    }

    function addProduct(productId = 0) {
        var id = productId + '-0';
        getProduct(productId);
        var data = {
            'id': id,
            'product_id': productId,
            'sub_product_id': 0,
            'name': '',
            'qty': 1,
            'price': 0,
            'vat': 0,
            'side_dish': '',
            'cat_level': 3,
        }
    }

    function addSubProduct(subProductId = 0) {}

    function getDiscount() {}

    $(window).scroll(function () {
        if ($(this).scrollTop() > 250) {
            $('.product-category-mobile-menu-block').fadeIn('show');
        } else {
            $('.product-category-mobile-menu-block').fadeOut();
        }
    });


    $('.product-category').on('scrollSpy:enter', function () {
        $('.categoryNameTitle').html($(this).find('.category-name').text());
        //$('.product-category-mobile-menu ul li').removeClass('active');
        var id = $(this).attr('id');
    });

    $('.product-category').scrollSpy();

    $('.product-category-mobile-menu ul li a').click(function () {
        $(this).parents('div.collapse').removeClass('show');
        var cateName = $(this).text();
        var link = $(this).attr('href');
        console.log('Link',link)
        if(link){
            $('.product-category-mobile-menu ul li').removeClass('active');
            $(this).closest('li').addClass('active');
            scroll_if_anchor(link);
        }
    });

    function scroll_if_anchor(href) {
        href = typeof (href) == "string" ? href : $(this).attr("href");
        // You could easily calculate this dynamically if you prefer
        var fromTop = 10;
        // If our Href points to a valid, non-empty anchor, and is on the same page (e.g. #foo)
        // Legacy jQuery and IE7 may have issues: http://stackoverflow.com/q/1593174
        if (href.indexOf("#") == 0) {
            var $target = $(href);

            // Older browser without pushState might flicker here, as they momentarily
            // jump to the wrong position (IE < 10)
            if ($target.length) {
                $('html, body').animate({scrollTop: $target.offset().top - fromTop});
                if (history && "pushState" in history) {
                    history.pushState({}, document.title, window.location.pathname + href);
                    return false;
                }
            }
        }
    }
</script>