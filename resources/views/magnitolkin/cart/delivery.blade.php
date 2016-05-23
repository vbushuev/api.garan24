@extends('magnitolkin.cart.magnitolkin')
@section('content')
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
<tr><td colspan="4">&nbsp;</td></tr></tbody></table>

<div id="order-options" style="margin-left: 10px;">

    <div id="delivery">
        <div class="notice">
            <div class="icon"><img src="https://magnitolkin.ru/Files/Images/SectionDelivery.png" alt="!"></div>
            <div class="comment">
                <div class="section_type_header">Способ получения</div>
                <div class="section_type_comment">Чтобы узнать полную стоимость заказа укажите способ получения товара</div>
            </div>
        </div>
        <style>
            .description {
                display: none;
                border: solid 1px rgba(0,0,0,.2);
                color: rgba(0,0,0,.6);
                font-size: 90%;
                padding: .4em;
                margin: 0 0 0 1.4em;
            }
        </style>
        <script>
            function optionClickDeliveryType(i,t){
                $(".description").hide();
                $(t).parent().parent().parent().find("label").removeClass("selected");
                $(t).parent().addClass("selected").parent().find(".description").show();
            }
        </script>
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
                    <input type="radio" id="delivery_type_7" name="delivery_types" onclick="javascript:optionClickDeliveryType(7, this)" data-delivery-id="7">
                    Доставка курьером по Москве (экспресс)
                </label>
                <div class="description">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - 3 часа с момента заказа<br /><strong>Стоимость</strong> - 600руб.</div>
            </div>
            <!--<script type="text/javascript">Order.addDeliveryType(7, 0, 0, "True", "False");</script>-->

            <div class="radio">
                <label>
                    <input type="radio" id="delivery_type_6" name="delivery_types" onclick="javascript:optionClickDeliveryType(6, this)" data-delivery-id="6">
                    Доставка по России
                </label>
                <div class="description">Доставка по России осуществляется Почтой России.<br/><strong>Срок</strong> - до 20 дней<br /><strong>Стоимость</strong> - 300руб.</div>
            </div>
            <!--<script type="text/javascript">Order.addDeliveryType(6, 300, 0, "True", "True");</script>-->

            <div class="radio">
                <label>
                    <input type="radio" id="delivery_type_9" name="delivery_types" onclick="javascript:optionClickDeliveryType(9, this)" data-delivery-id="9">
                    Доставка службой BoxBerry
                </label>
                <div class="description">Доставка производится до ближайшего к Вам пункта выдачи заказов Boxberry.<br/><strong>Срок</strong> - до 10 дней<br /><strong>Стоимость</strong> - 200руб.</div>
            </div>
            <!--<script type="text/javascript">Order.addDeliveryType(9, 0, 0, "True", "True");</script>-->

            <div class="radio">
                <label>
                    <input type="radio" id="delivery_type_3" name="delivery_types" onclick="javascript:optionClickDeliveryType(3, this)" data-delivery-id="3">
                    Доставка курьером за пределы МКАД
                </label>
                <div class="description">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - на следующий рабочий день<br /><strong>Стоимость</strong> - 300руб. + 30руб. за каждый километр от МКАД</div>
            </div>
            <!--<script type="text/javascript">Order.addDeliveryType(3, 0, 30, "True", "False");</script>-->
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div>
        <div id="delivery-calculator" style="display: none;">
            <div class="heading">Стоимость доставки</div>
            <div style="background-color: #efefef; border:1px solid; border-color: #ffffff #cecece #cecece #ffffff;">
                <div style="text-align: left; margin-left: 15px; margin-top: 10px;" class="comment">Расстояние от Москвы:</div>
                <div class="pad">
                    <div>
                        <input type="text" id="txtDistanceToCustomer" autocomplete="off" onkeypress="javascript:return numbersOnly(this,event);" onkeyup="javascript:inputDeliveryCalculatorDistanceChanged(this);" value="" maxlength="3"> км
                        <span class="multisign">×</span>
                        <span class="rate"><span>0</span> руб./км</span>
                    </div>
                    <div class="result">
                        <div class="result_delivery_price"><span>0</span> руб.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

</div>
</div>

<div id="order-form-container">

    @include("magnitolkin.cart._buttons")
</div>
@include("magnitolkin.cart._boxberry")

@endsection
