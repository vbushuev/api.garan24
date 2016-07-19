
@if($deal->order->getProducts()!==null)
    <h2><i class="first">Ваш</i> заказ</h2>
    @foreach($deal->order->getProducts() as $good)
    <div class="row cart-item" id="cartItem-{{$good["product_id"]}}">
        <div class="image col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <img src="{{$good["product_img"] or $good["featured_src"]}}" alt="{{$good["title"] or $good['name']}}">
        </div>
        <div class="name col-xs-8 col-sm-8 col-md-8 col-lg-8">
            {{$good["title"] or $good["name"]}}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="quantity col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    {{$good["quantity"]}} шт.
                </div>
                <div class="amount col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    @amount($good["quantity"]*$good["regular_price"])
                </div>
            </div>
        </div>
    </div>
    @endforeach


@endif
