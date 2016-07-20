
@if($deal->order->getProducts()!==null)
    <h2><i class="first">Ваш</i> заказ</h2>
    @foreach($deal->order->getProducts() as $good)
    <div class="row cart-item" id="cartItem-{{$good["product_id"]}}" data-ref="{{$good["product_url"]}}">
        <div class="image col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <img src="{{$good["product_img"] or $good["featured_src"]}}" alt="{{$good["title"] or $good['name']}}">
        </div>
        <div class="name col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <div class="row">{{$good["title"] or $good["name"]}}</div>
            <div class="row">
                <div class="quantity col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    {{$good["quantity"]}} шт.
                </div>
                <div class="amount col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    @amount($good["quantity"]*$good["regular_price"])
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="row cart-item" id="cart-total">
        <div class="total col-xs-8 col-sm-8 col-md-8 col-lg-8">Сумма заказа:</div>
        <div class="amount cart-total-amount total-amount col-xs-4 col-sm-4 col-md-4 col-lg-4" id="cart-total-price"></div>
    </div>
    <div class="row cart-item" id="cart-shipping">
        <div class="total col-xs-8 col-sm-8 col-md-8 col-lg-8">
            @if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
                Доставка <b>{{$deal->delivery["name"]}}</b>
                <br /><small>{{$deal->getCustomer()->toAddressString()}}</small>
            @endif
        </div>
        <div class="amount total-amount col-xs-4 col-sm-4 col-md-4 col-lg-4" id="shipping-price">
            @if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
                @amount($deal->shipping_cost)
            @endif
        </div>
    </div>
    <div class="row cart-item" id="cart-shipping-total">
        <div class="total col-xs-8 col-sm-8 col-md-8 col-lg-8">Итог:</div>
        <div class="amount total-amount col-xs-4 col-sm-4 col-md-4 col-lg-4" id="total-price"></div>
    </div>
@endif
