<div id="checkout-cart-content">
<div class="page-header">
    <h3>Ваша корзина</h3>
</div>

@if (isset($goods))
@foreach($goods as $good)
<ul class="cart-item" id="cartItem-{{$good["product_id"]}}">
    <li class="image">
        <img width="64px" src="{{$good["product_img"] or $good["featured_src"]}}" alt="{{$good["title"] or $good['name']}}">
    </li>
    <li class="name">
        <a class="name" href="{{$good["product_url"] or ''}}" target="_blank">{{$good["title"] or $good["name"]}}</a>&nbsp;&nbsp;<sup>x&nbsp;{{$good["quantity"]}}</sup>
        <br />
        <span class="productPrice">{{$good["quantity"]*$good["regular_price"]}}</span> руб.
    </li>
</ul>


@endforeach
@else
<table id="cart-content" class="table">
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

<tr class="cart-item delivery-row" style="height:auto;display:none;">
    <td style="padding:.4em;">&nbsp;</td>
    <td style="padding:.4em;"><strong>Доставка заказа</strong></td>
    <td style="padding:.4em;">&nbsp;</td>
    <td style="padding:.4em;">
        <div class="cost" id="totalDeliveryPrice"></div>
    </td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr></tbody>
</table>
@endif
</div>
