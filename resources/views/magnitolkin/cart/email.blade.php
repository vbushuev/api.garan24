@extends('magnitolkin.cart.magnitolkin')

@section('content')

<h2><span class="red">Оформление</span> заказа</h2>

<div id="cart-container">

<table id="cart-content" class="table">
    <tbody>
        <tr class="cart-content-header">
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
        <tr><td colspan="4">&nbsp;</td></tr>
    </tbody>
</table>

<div id="order-form-container">
    <div>
        <div class="page-header">
            <h3>Пожалуйста введите информацию о себе:</h3>
        </div>
        <div class="form-group">
            <label for="email" class="control-label">Электронная почта:</label>
            <input id="email" name="email" class="form-control">
            <p class="text-muted small">Сообщив электронную почту, Вы сможете отслеживать состояние заказа.</p>
        </div>
        <div class="form-group">
            <label for="phone" class="control-label">Телефон:</label>
            <input id="phone" name="phone" class="form-control"  style="width: 13em;" placeholder="8 (900) 100-20-30">
            <p class="text-muted small">Сообщив номер мобильного телефона, Вы сможете получать уведомления об изменении состояние заказа.</p>
        </div>
    </div>
    @include("magnitolkin.cart._buttons")
</div>

@endsection
