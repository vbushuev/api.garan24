
@if($deal->order->getProducts()!==null)
    <h2><i class="first">Ваш</i> заказ</h2>
    @foreach($deal->order->getProducts() as $good)
    
    <ul class="cart-item" id="cartItem-{{$good["product_id"]}}">
        <li class="image">
            <img width="72px" src="{{$good["product_img"] or $good["featured_src"]}}" alt="{{$good["title"] or $good['name']}}">
        </li>
        <li class="name">
            {{$good["title"] or $good["name"]}}
        </li>
        <li class="quantity">{{$good["quantity"]}} шт.</li>
        <li class="amount">@amount($good["quantity"]*$good["regular_price"])</li>
    </ul>
    @endforeach

    <ul class="cart-item" id="cart-shipping">
        <li class="name">
            @if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
                Доставка <b>{{$deal->delivery["name"]}}</b>
                <br /><small>{{$deal->getCustomer()->toAddressString()}}</small>
            @endif
        </li>
        <li class="amount" id="totalDeliveryPrice">
            @if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
                @amount($deal->shipping_cost)
            @endif
        </li>
    </ul>
    <ul class="cart-item" id="carts-total">
        <li class="total">Итого:</li>
        <li class="amount total-amount" id="lblTotalPrice"></li>
    </ul>
@endif
