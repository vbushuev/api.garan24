@extends('magnitolkin.cart.magnitolkin')

@section('content')
<script>
var paymethod = 1;
function optionClickPaymentType(i,t){
    paymethod = i;
}

</script>
<h2><span class="red">Оформление</span> заказа</h2>

<div id="cart-container">

<table id="cart-content" class="table">
<tbody><tr class="cart-content-header">
    <th style="width: 15%;">&nbsp;</th>
    <th style="width: 50%;">Товар</th>
    <th style="width: 15%;">Количество</th>
    <th style="width: 20%; text-align: right;">Стоимость</th>
</tr>

<tr class="cart-item" id="cartItemPos14832">
    <td class="image"><img src="https://magnitolkin.ru/Handlers/CartShopItemImage/?id=14832" alt="Tempo Coax 5"></td>
    <td><a class="name" href="/catalogue/Akustika/coaxial/5_25_inch/11075/" target="_blank">Morel Tempo Coax 5</a></td>
    <td>
        <img id="btn_delete_14832" class="button" src="https://magnitolkin.ru/Files/Images/DeleteCartItem.png" alt="Удалить" title="Удалить" onclick="javascript:removeCartItem(14832)">
        <img id="btn_decrement_14832" class="button" src="https://magnitolkin.ru/Files/Images/DecrementCartItemQuantity.png" onclick="javascript:shopItemDecrementQuantity(this, 14832)" alt="Уменьшить количество" title="Уменьшить количество" style="display: none;">
		<span id="quantity_14832" class="quantity">1</span> <span class="quantity">шт.</span>
        <img id="btn_increment_14832" class="button" src="https://magnitolkin.ru/Files/Images/IncerementCartItemQuantity.png" onclick="javascript:shopItemIncrementQuantity(this, 14832)" alt="Увеличить количество" title="Увеличить количество">
        <!--<script type="text/javascript">Order.addItemToCart(14832, 4581, 1);</script>-->
    </td>
    <td><div class="cost"><span id="totalPrice14832">4&nbsp;581</span> руб.</div></td>
</tr>
<tr class="cart-item">
    <td style="padding:0;">&nbsp;</td>
    <td style="padding:0;"><strong>Доставка заказа</strong></td>
    <td style="padding:0;"><img id="btn_delete_14832" class="button" src="https://magnitolkin.ru/Files/Images/DeleteCartItem.png" alt="Удалить" title="Удалить" onclick="javascript:removeCartItem(14832)"><span id="quantity_14832" class="quantity">1</span> <span class="quantity">шт.</span></td>
    <td style="padding:0;"><div class="cost"><span id="totalDeliveryPrice">300</span> руб.</div></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr></tbody></table>

<div id="order-options" style="margin-left: 10px;">
<style>
    .description {
        display: none;
        border: solid 1px rgba(0,0,0,.2);
        color: rgba(0,0,0,.6);
        font-size: 100%;
        padding: .4em;
        margin: 0 0 0 1.4em;
    }
</style>
<script>
    /*
     * delivery:
     0 - курьер по москве экспресс
     1 - rehmth по москве
     2 - самовывоз
     3 - почтой России
     4 - BoxBerry
     5 - За МКАД
     * payment
     0 - garan24 pay
     1 - delivery by card
     2 - online by card
     3 - cash
    */
    garan.delivery.add({id:"self",name:"Самовывоз",description:"Вы самостоятельно получаете заказ в офисе интернет магазина.",duration:"на следующий рабочий день",cost:"бесплатно"});
    console.debug(garan.delivery.list.self);
    var deliverypayDependence = [
        [true,true,true,true],
        [true,true,true,true],
        [false,true,true,true],
        [true,false,true,true],
        [true,true,true,true],
        [true,true,true,true]
    ];
    var paydeliveryDependence = [
        [true,true,false,true,true,true],
        [true,true,true,false,true,true],
        [true,true,true,true,true,true],
        [true,true,true,true,true,true]
    ];
    function optionClickPaymentType(i,t){
        $(t).parent().parent().parent().find(".description").hide();
        $(t).parent().parent().parent().find("label").removeClass("selected");
        $(t).parent().addClass("selected").parent().find(".description").show();
    }
    function optionClickDeliveryType(i,t){
        $(t).parent().parent().parent().find(".description").hide();
        $(t).parent().parent().parent().find("label").removeClass("selected");
        $(t).parent().addClass("selected").parent().find(".description").show();
        if(i==2)$("[data-payment-id=0]").parent().parent().hide();
        else $("[data-payment-id=0]").parent().parent().show();
        if(i==3)$("[data-payment-id=1]").parent().parent().hide();
        else $("[data-payment-id=1]").parent().parent().show();
    }
</script>
<div id="delivery">
    <div class="notice">
        <div class="icon"><img src="https://magnitolkin.ru/Files/Images/SectionDelivery.png" alt="!"></div>
        <div class="comment">
            <div class="section_type_header">Способ получения</div>
            <div class="section_type_comment">Чтобы узнать полную стоимость заказа укажите способ получения товара</div>
        </div>
    </div>
    <div class="notice right">
        <div class="icon"><img src="https://magnitolkin.ru/Files/Images/SectionPayment.png" alt="!"></div>
        <div class="comment">
            <div class="section_type_header">Способ оплаты</div>
            <div class="section_type_comment">Укажите предпочитаемый способ оплаты. Скорость прохождения платежа влияет на сроки доставки товара.</div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="delivery_types">
        <div class="radio">
            <label class="selected">
                <input type="radio" id="delivery_type_2" name="delivery_types" checked="checked" onclick="javascript:optionClickDeliveryType(2, this)" data-delivery-id="2">
                Самовывоз
            </label>
            <div class="description" style="display:block;">
                Вы самостоятельно получаете заказ в офисе интернет магазина.<br/><strong>Срок</strong> - на следующий рабочий день<br /><strong>Стоимость</strong> - бесплатно
            </div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(2, 0, 0, "False", "False");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="delivery_type_1" name="delivery_types" onclick="javascript:optionClickDeliveryType(1, this)" data-delivery-id="1">
                Доставка курьером по Москве
            </label>
            <div class="description">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - на следующий рабочий день<br /><strong>Стоимость</strong> - 300руб.</div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(1, 0, 0, "True", "False");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="delivery_type_0" name="delivery_types" onclick="javascript:optionClickDeliveryType(0, this)" data-delivery-id="0">
                Доставка курьером по Москве (экспресс)
            </label>
            <div class="description">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - 3 часа с момента заказа<br /><strong>Стоимость</strong> - 600руб.</div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(7, 0, 0, "True", "False");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="delivery_type_3" name="delivery_types" onclick="javascript:optionClickDeliveryType(3, this)" data-delivery-id="3">
                Доставка по России
            </label>
            <div class="description">Доставка по России осуществляется Почтой России.<br/><strong>Срок</strong> - до 20 дней<br /><strong>Стоимость</strong> - 300руб.</div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(6, 300, 0, "True", "True");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="delivery_type_4" name="delivery_types" onclick="javascript:optionClickDeliveryType(4, this)" data-delivery-id="4">
                Доставка службой BoxBerry
            </label>
            <div class="description">Доставка производится до ближайшего к Вам пункта выдачи заказов Boxberry.<br/><strong>Срок</strong> - до 10 дней<br /><strong>Стоимость</strong> - 200руб.</div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(9, 0, 0, "True", "True");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="delivery_type_5" name="delivery_types" onclick="javascript:optionClickDeliveryType(5, this)" data-delivery-id="5">
                Доставка курьером за пределы МКАД
            </label>
            <div class="description">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - на следующий рабочий день<br /><strong>Стоимость</strong> - 300руб. + 30руб. за каждый километр от МКАД</div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(3, 0, 30, "True", "False");</script>-->
    </div>
    <div id="payment_types">
        <div class="radio">
            <label class="selected">
                <input type="radio" id="payment_type_2" checked="checked" name="payment_types" onclick="javascript:optionClickPaymentType(2, this)" data-payment-id="2">
                Оплатить картой сейчас
            </label>
            <div class="description" style="display:block;">
                На следующем экране Вам нужно будет указать реквизиты своей банковской карты, после чего с нее будет списана полная стоимость заказа.
            </div>
        </div>
        <!--<script type="text/javascript">Order.addPaymentType(2, 0, "False", "True");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="payment_type_3" name="payment_types" onclick="javascript:optionClickPaymentType(3, this)" data-payment-id="3">
                Оплатить наличными при получении
            </label>
            <div class="description">
                Вы оплачиваете полную стоимость заказа наличными курьеру или сотруднику пункта выдачи заказов при получении заказа.<br />
                Чтобы оплатить заказ наличными при получении для выбранного Вами способа получения заказа, Вам необходимо сейчас сделать предоплату стоимости доставки банковской картой.
            </div>
        </div>
        <!--<script type="text/javascript">Order.addPaymentType(3, 0, "True", "True");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="payment_type_1" name="payment_types" onclick="javascript:optionClickPaymentType(1, this)" data-payment-id="1">
                Оплатить картой при получении
            </label>
            <div class="description">
                Вы оплачиваете полную стоимость заказа банковской картой Visa\MC курьеру или сотруднику пункта выдачи заказов при получении заказа.<br />
                Чтобы оплатить заказ банковской картой
                при получении для выбранного Вами способа получения заказа,
                Необходимо сейчас сделать предоплату стоимости доставки банковской картой.
            </div>
        </div>

        <div class="radio" style="display:none;">
            <label>
                <input type="radio" id="payment_type_0" name="payment_types" onclick="javascript:optionClickPaymentType(0, this)" data-payment-id="0">
                Оплатить картой после получения (в течение 14 дней)
            </label>
            <div class="description">
                Сумма полной стоимости заказа будет списана с Вашей карты автоматически через 14 дней после получения Вами заказа. Услуга предоставляется бесплатно сервисом Гаран24.
            </div>
        </div>
        <!--<script type="text/javascript">Order.addPaymentType(1, 0, "False", "False");</script>-->
    </div>


</div>
    <div id="payment">
<div class="clearfix"></div>
    </div>

    <div id="total_cost">
        <div class="label">Полная стоимость:</div>
        <div class="cost_value"><span id="lblTotalPrice">4 881</span> руб.</div>
    </div>
    <div class="clearfix"></div>
    @include("magnitolkin.cart._buttons")
</div>
</div>

@endsection
