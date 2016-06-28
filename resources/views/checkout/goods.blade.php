
<table id="cart-content" class="table">
<tbody><tr class="cart-content-header">
    <th style="width: 15%;">&nbsp;</th>
    <th style="width: 50%;">Товар</th>
    <th style="width: 15%;">Количество</th>
    <th style="width: 20%; text-align: right;">Стоимость</th>
</tr>
@if (isset($goods))
@foreach($goods as $good)
<tr class="cart-item" id="cartItem-{{$good["product_id"]}}">
    <td class="image">

        <img width="70" src="{{$good["product_img"] or $good["featured_src"]}}" alt="{{$good["title"] or $good['name']}}">
    </td>
    <td>
        <a class="name" href="{{$good["product_url"] or ''}}" target="_blank">{{$good["title"] or $good["name"]}}</a>
    </td>
    <td>
    <!--
        <img id="btn_delete_14832" class="button" src="https://magnitolkin.ru/Files/Images/DeleteCartItem.png" alt="Удалить" title="Удалить" onclick="javascript:removeCartItem(14832)">
        <img id="btn_decrement_14832" class="button" src="https://magnitolkin.ru/Files/Images/DecrementCartItemQuantity.png" onclick="javascript:shopItemDecrementQuantity(this, 14832)" alt="Уменьшить количество" title="Уменьшить количество" style="display: none;">
    -->
        <span id="quantity_14832" class="quantity">{{$good["quantity"]}}</span> <span class="quantity">шт.</span>
    <!--
        <img id="btn_increment_14832" class="button" src="https://magnitolkin.ru/Files/Images/IncerementCartItemQuantity.png" onclick="javascript:shopItemIncrementQuantity(this, 14832)" alt="Увеличить количество" title="Увеличить количество">
    -->
        <!--<script type="text/javascript">Order.addItemToCart(14832, 4581, 1);</script>-->
    </td>

    <td><div class="cost"><span class="productPrice">{{$good["quantity"]*$good["regular_price"]}}</span> руб.</div></td>
</tr>
@endforeach
@else
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
@endif
<tr class="cart-item delivery-row" style="height:auto;display:none;">
    <td style="padding:.4em;">&nbsp;</td>
    <td style="padding:.4em;"><strong>Доставка заказа</strong></td>
    <td style="padding:.4em;">
        <span id="quantity_14832" class="quantity">1</span> <span class="quantity">шт.</span></td>
    <td style="padding:.4em;">
        <div class="cost" id="totalDeliveryPrice"></div>
    </td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr></tbody></table>
