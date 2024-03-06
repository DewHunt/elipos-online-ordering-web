 function CartServiceProvider () {
        this.cart = [];
        this.isDiscountAvailable = false;
        this.discountType = 'amount';
        this.discountPercent = 0;
        this.discountAmount = 0;
        this.orderType='Collection';
        if (localStorage.getItem('cart')) {
            this.cart = JSON.parse(localStorage.getItem('cart'));
        }
    };
    CartServiceProvider.prototype.getTotalAmount = function () {
        var sum = 0;
        if (!this.cart || !this.cart.length) {
            return sum;
        }
        for (var i = 0; i < this.cart.length; i = i + 1) {
            if (this.cart[i].isDeals) {
                console.log(this.cart[i]);
                sum = sum + this.cart[i].quantity * this.cart[i].price;
            }
            else {
                sum = sum + this.cart[i].quantity * this.cart[i].item.price;
            }
        }
        return sum;
    };
    CartServiceProvider.prototype.getTotalItem = function () {
        return this.getCart().length;
    };
    CartServiceProvider.prototype.removeCartItem = function (index) {
        this.cart.splice(index, 1);
        this.setCart(this.cart);
        this.showMessage('Product has been removed');
    };

    CartServiceProvider.prototype.setCart = function (cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    };

    CartServiceProvider.prototype.clearCart = function () {
        this.cart = [];
        localStorage.setItem('cart', JSON.stringify(this.cart));
    };

    CartServiceProvider.prototype.getCart = function () {
        return this.cart;
    };

    CartServiceProvider.prototype.insert = function (data) {
        if (localStorage.getItem('cart')) {
            this.cart = JSON.parse(localStorage.getItem('cart'));
        }
        if (this.cart.length) {
            var itemIndex = -1;
            itemIndex = this.cart.findIndex(function (element) { return element.id == data.id; });
            if (itemIndex >= 0) {
                this.cart[itemIndex].quantity = this.cart[itemIndex].quantity + 1;
            }
            else {
                this.cart.push(data);
            }
        }
        else {
            this.cart.push(data);
        }
        localStorage.setItem('cart', JSON.stringify(this.cart));
        if (localStorage.getItem('cart')) {
            this.cart = JSON.parse(localStorage.getItem('cart'));
        }
        this.showMessage('Product is added to your cart');
    };
    CartServiceProvider.prototype.showMessage = function (message) {

    };

    CartServiceProvider.prototype.get_discount_details = function () {
        var _this = this;
     /*   if (this.authServiceProvider.isLogged()) {
            var customerInfo = JSON.parse(localStorage.getItem('userData'));
            this.authServiceProvider.postData({ 'customer_id': customerInfo.id }, 'set_order/get_discount_details').then(function (result) {
                _this.isDiscountAvailable = result['is_discount_available'];
                if (_this.isDiscountAvailable) {
                    var discountDetails = result['discount_details'];
                    _this.discountType = discountDetails.discount_type;
                    _this.discountPercent = discountDetails.percent;
                    if (_this.discountType == 'amount') {
                        _this.discountAmount = discountDetails.amount;
                    }
                }
                else {
                    _this.discountAmount = 0;
                    _this.discountType = 'amount';
                    _this.discountPercent = 0;
                }
            }).catch(function (err) {
                _this.discountAmount = 0;
                _this.discountType = 'amount';
                _this.discountPercent = 0;
            });
        }
        else {

        }*/

        this.discountAmount = 0;
        this.discountType = 'amount';
        this.discountPercent = 0;
    };
    CartServiceProvider.prototype.getDiscount = function () {
        if (this.discountType == 'percent') {
            this.discountAmount = (this.getTotalAmount() * this.discountPercent) / 100;
            return this.discountAmount;
        }
        else {
            return this.discountAmount;
        }
    };
    CartServiceProvider.prototype.isCartIsValidAsOrderType = function (orderType) {
        if (!this.cart || !this.cart.length) {
            return true;
        }
        var storageOrderType = localStorage.getItem('orderType');
        var searchOrderType = 'none';
        if (orderType == 'delivery') {
            searchOrderType = 'collection';
        }
        else if (orderType == 'collection') {
            searchOrderType = 'delivery';
        }
        var cartItemReturn = this.cart.find(function (cartItem) { return cartItem.orderType === searchOrderType; });
        if (cartItemReturn) {
            return false;
        }
        else {
            return true;
        }
    };
    CartServiceProvider.prototype.showCartContainOrderTypeItem = function ( $message) {


    };
    CartServiceProvider.prototype.getCartValidationAlertMessage = function (orderType, customMessages) {
        if (orderType == 'collection') {
            return { title: customMessages.titleDelivery, message: customMessages.messageDelivery };
        }
        else if (orderType == 'delivery') {
            return { title: customMessages.titleCollection, message: customMessages.messageCollection };
        }
        else if (orderType == 'none') {
            return { title: '', message: '' };
        }
        else {
            return { title: '', message: '' };
        }
    };
