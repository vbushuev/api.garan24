@extends('magnitolkin.cart.magnitolkin')

@section('content')
<!--<script>
var ymaps = {init:function(){}},Order={getCartItems:function(){return [];}};

</script>-->
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


<div id="order-form-container">
    <div>
        <div class="page-header">
            <h3>Обязательно укажите:</h3>
        </div>

        <div class="form-group" id="PersonLastName">
            <label for="txtLastName" class="control-label">Фамилия:</label>
            <input id="txtLastName" name="txtLastName" class="form-control">
        </div>
        <div class="form-group" id="PersonFirstName">
            <label for="txtFirstName" class="control-label">Ваше имя:</label>
            <input id="txtFirstName" name="txtFirstName" class="form-control">
        </div>
        <div class="form-group" id="PersonMiddleName">
            <label for="txtMiddleName" class="control-label">Отчество:</label>
            <input id="txtMiddleName" name="txtMiddleName" class="form-control">
        </div>
        <div id="DeliveryAddressContainer" class="form-group">
            <label class="control-label">Адрес доставки:</label>
            <button id="btn-boxberry-map" data-toggle="modal" data-target="#boxberry-map-modal" class="btn btn-info" style="display: none;">Выбрать пункт доставки </button>
            <textarea id="txtDeliveryAddress" name="txtDeliveryAddress" cols="20" rows="5" class="form-control"></textarea>
            <input type="hidden" id="boxberryIndex" name="boxberryIndex" value="">
        </div>
        <div class="form-group">
            <textarea id="txtComment" name="txtComment" class="form-control" placeholder="Дополнительная информация (вопросы) к заказу" rows="5"></textarea>
        </div>

    </div>

    <div style="margin-top: 15px;">
        <button id="btnReturnToCart" class="btn btn-default btn-lg pull-left">← Вернуться</button>
        <button id="btnMakeOrder" class="btn btn-success btn-lg pull-right">Продолжить</button>
        <div class="clearfix"></div>
    </div>
</div>
<script>
$(document).ready(function(){
    $("#order-form-container").show();
    $("#btnMakeOrder").click(function(){
        document.location.href = "../magnitolkin/delivery"
    })
    $("#btnReturnToCart").click(function(){
        document.location.href = "../magnitolkin/checkout"
    })
});
</script>
@endsection
