function numbersOnly(sender, e) {
    var key;
    var keychar;

    if (window.event)
        key = window.event.keyCode;
    else if (e)
        key = e.which;
    else
        return true;
    keychar = String.fromCharCode(key);

    // control keys
    if ((key == null) || (key == 0) || (key == 8) ||
    (key == 9) || (key == 13) || (key == 27))
        return true;

        // numbers
    else if ((("0123456789").indexOf(keychar) > -1))
        return true;
    else
        return false;
}

function parseBoolean(value) {
    switch (value.toLowerCase()) {
        case "true":
            return true;
        case "false":
            return false;
        default:
            throw new Error("parseBoolean: Ошибка преобразования строки в тип Boolean.");
    }
};

Array.prototype.remove = function (criteria) {
    return jQuery.grep(this, criteria);
};

Array.prototype.forEach = function (func) {
    var len = this.length;
    if (typeof func != "function")
        throw new TypeError();

    var thisp = arguments[1];
    for (var i = 0; i < len; i++) {
        if (i in this)
            func.call(thisp, this[i], i, this);
    }
};

function isNullOrEmpty(value) {
    var result = value == undefined || value == null;
    if (!result && value.constructor === String) {
        result = value.length == 0;
    } else if (!result && value.length != undefined && value.length != null) {
        result = value.length == 0;
    }
    return result;
}

String.prototype.format = function (formatType) {
    var formattedString = null;
    var inputString = this;

    if (formatType == "N") {
        inputString += '';
        x = inputString.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ' ' + '$2');
        }
        formattedString = x1 + x2;
    }

    return formattedString == null ? inputString : formattedString;
};

function CartItem(id, price, quantity) {
    this._id = id;
    this._price = price;
    this._quantity = quantity;

    this.getId = function () { return this._id; };
    this.getPrice = function () { return this._price; };
    this.getQuantity = function () { return this._quantity; };
    this.getCost = function () {
        var itemCost = this._price * this._quantity;
        console.info("CartItem.getCost(): price = " + this._price + ", quantity = " + this._quantity + ", itemCost = " + itemCost);
        return itemCost;
    }

    this.increaseQuantity = function () { this._quantity++; }
    this.decreaseQuantity = function () { this._quantity > 1 ? this._quantity-- : void (0); }
}

function DeliveryType(id, fixedPrice, ratePerDistanceSegment /* тариф за километр */, isNeedDeliveryAddress, isNeedDeliveryService) {
    this._id = id;
    this._fixedPrice = fixedPrice;
    this._ratePerDistanceSegment = ratePerDistanceSegment;
    this._isNeedDeliveryAddress = parseBoolean(isNeedDeliveryAddress);
    this._isNeedDeliveryService = parseBoolean(isNeedDeliveryService);

    this.getId = function () { return this._id; };
    this.getFixedPrice = function () { return this._fixedPrice; };
    this.getRatePerDistanceSegment = function () { return this._ratePerDistanceSegment; };
    this.isRateByDistance = function () { return this._ratePerDistanceSegment > 0; };
    this.isNeedDeliveryAddress = function () { return this._isNeedDeliveryAddress; };
    this.isNeedDeliveryService = function () { return this._isNeedDeliveryService; };
}

function PaymentType(id, rate, isOnlinePaymentType, isRealTime) {
    this._id = id;
    this._rate = rate;
    this._isOnlinePaymentType = parseBoolean(isOnlinePaymentType);
    this._isRealTime = parseBoolean(isRealTime);

    this.getId = function () { return this._id; };
    this.getRate = function () { return this._rate; };
    this.getTotalCost = function (orderCost) {
        var totalCost = orderCost;

        console.info("PaymentType.getTotalCost(): totalCost = " + totalCost + ", rate = " + this._rate);

        if (this._rate > 0) {
            totalCost = totalCost * (1 + this._rate / 100);
        }
        return totalCost;
    };
    this.isOnlinePaymentType = function () { return this._isOnlinePaymentType; };
    this.isRealTime = function () { return this._isRealTime; };
}

Order = {
    // содержимое корзины
    _cartItems: [],

    // идентификатор заказываемого товара
    _shopItemId: 0,
    // присвоить идентификатор заказываемому товару
    setShopItemId: function (value) { this._shopItemId = value; },
    // получить идентификатор заказываемого товара
    getShopItemId: function () { return this._shopItemId; },

    // стоимость товара
    _shopItemCost: 0,
    // получить идентификатор заказываемого товара
    setShopItemCost: function (value) { this._shopItemCost = value; },

    // способы получения заказа
    _deliveryTypes: [],
    // способы оплаты
    _paymentTypes: [],

    // выбранный способ получения заказа
    _selectedDeliveryType: null,
    // выбранная дата получения заказа
    _selectedDeliveryDate: null,
    // выбранный способ оплаты
    _selectedPaymentType: null,

    // стоимость экспресс-доставки
    _expressDeliveryTypeCost: 600,
    // требуется ли экспресс-доставка
    _isNeedExpressDelivery: false,
    // установить необходимость экспресс-доставки
    setNeedExpressDelivery: function (flag) { this._isNeedExpressDelivery = flag; },
    // узнать необходимость экспресс-доставки
    getNeedExpressDelivery: function () { return this._isNeedExpressDelivery; },

    // расстояние до покупателя
    _distaceToCustomer: 0,
    // установить расстояние до покупателя
    setDistaceToCustomer: function (distance) { this._distaceToCustomer = distance; },
    // получить расстояние до покупателя
    getDistaceToCustomer: function () { return this._distaceToCustomer; },

    // добавить способ получения заказа
    addDeliveryType: function (id, fixedPrice, ratePerDistanceSegment, isNeedDeliveryAddress, isNeedDeliveryService) {
        this._deliveryTypes.push(new DeliveryType(id, fixedPrice, ratePerDistanceSegment, isNeedDeliveryAddress, isNeedDeliveryService));
    },
    // получить выбранный способ получения заказа
    getSelectedDeliveryType: function () { return this._selectedDeliveryType; },
    // установить способ получения заказа
    setDeliveryTypeById: function (id) {
        this._deliveryTypes.forEach(
            function (element) {
                if (element.getId() == id)
                    Order._selectedDeliveryType = element;
            }
        );
    },
    setDefaultDeliveryType: function () {
        this._selectedDeliveryType = this._deliveryTypes[0];
    },

    // получить выбранную дату получения заказа
    getSelectedDeliveryDate: function () { return this._selectedDeliveryDate; },
    // установить дату получения заказа
    setDeliveryDate: function (deliveryDate) {
        Order._selectedDeliveryDate = deliveryDate;
    },

    // добавить способ оплаты заказа
    addPaymentType: function (id, rate, isOnlinePaymentType, isRealTime) {
        this._paymentTypes.push(new PaymentType(id, rate, isOnlinePaymentType, isRealTime));
    },
    // получить выбранный способ оплаты
    getSelectedPaymentType: function () { return this._selectedPaymentType; },
    // установить способ оплаты заказа
    setPaymentTypeById: function (id) {
        this._paymentTypes.forEach(
            function (element) {
                if (element.getId() == id)
                    Order._selectedPaymentType = element;
            }
        );
    },
    setDefaultPaymentType: function () {
        this._selectedPaymentType = this._paymentTypes[0];
    },

    // добавить товар в корзину
    addItemToCart: function (id, price, quantity) { this._cartItems.push(new CartItem(id, price, quantity)); },
    // удалить товар из корзины
    removeItemFromCart: function (id) {
        var criteria = function (value) { return value != id; };
        this._cartItems.remove(criteria);
    },

    getCartItems: function () { return this._cartItems; },
    getCartItemById: function (id) {
        var result = null;
        this._cartItems.forEach(
                function (element, index, array) {
                    if (element.getId() == id)
                        result = element;
                }
            );
        return result;
    },


    // получить стоимость доставки
    getDeliveryCost: function (orderCost) {
        var deliveryType = this.getSelectedDeliveryType();
        var deliveryCost = deliveryType.getFixedPrice();

        if (deliveryType.isRateByDistance()) {
            deliveryCost += deliveryType.getRatePerDistanceSegment() * Order.getDistaceToCustomer();
        }

        if (deliveryType.isNeedDeliveryAddress())
            if (this.getNeedExpressDelivery())
                deliveryCost += this._expressDeliveryTypeCost;

        return deliveryCost;
    },

    // получить полную стоимость заказа
    getTotalCost: function () {
        var itemsCost = 0;

        this._cartItems.forEach(
            function (element) {
                itemsCost += element.getCost();
            }
        );

        console.info("getTotalCost(): itemsCost = " + itemsCost);

        var orderCost = this.getDeliveryCost(itemsCost) + itemsCost;

        console.info("getTotalCost(): orderCost = " + orderCost);

        var totalCost = this.getSelectedPaymentType().getTotalCost(orderCost);

        console.info("getTotalCost(): totalCost = " + totalCost);

        totalCost = Math.round(totalCost);

        return totalCost.toString().format("N");
    }
};