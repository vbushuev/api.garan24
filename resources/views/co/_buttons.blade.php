<div class="row cart-item" id="cart-total">
    <div class="total col-xs-4 col-sm-4 col-md-4 col-lg-4">Сумма заказа:</div>
    <div class="amount cart-total-amount total-amount col-xs-8 col-sm-8 col-md-8 col-lg-8" id="cart-total-price"></div>
</div>
<div class="row cart-item" id="cart-shipping">
    <div class="name col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
            Доставка <b>{{$deal->delivery["name"]}}</b>
            <br /><small>{{$deal->getCustomer()->toAddressString()}}</small>
        @endif
    </div>
    <div class="amount total-amount col-xs-6 col-sm-6 col-md-6 col-lg-6" id="shipping-price">
        @if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
            @amount($deal->shipping_cost)
        @endif
    </div>
</div>
<div class="row cart-item" id="cart-shipping-total">
    <div class="total col-xs-4 col-sm-4 col-md-4 col-lg-4">Итог:</div>
    <div class="amount total-amount col-xs-8 col-sm-8 col-md-8 col-lg-8" id="total-price"></div>
</div>

<div class="row">
    @if($route["back"]!=false)
        <button id="back" class="btn btn-default btn-lg pull-left">← Вернуться</button>
    @endif
    <button id="forward" class="btn btn-success btn-lg pull-right">{{$route["next"]["text"]}}</button>
</div>


<input type="hidden" id="TotalAmountHidden" name="TotalAmountHidden"/>
<input type="hidden" id="ShippingAmountHidden" name="shipping_cost" value="@if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
    @amount($deal->shipping_cost)
@endif"/>
<script>
    window.garan_submit_args= {
        form:$("#form"),
        url:"{{$route["dir"].$route["next"]["href"]}}"
    };
    $(document).ready(function(){

        $("#forward").click(function(){
            garan.form.submit(garan_submit_args);
        })
        $("#back").click(function(){
            //history.go(-1);
            document.location.href = "{{$route["dir"].$route["back"]["href"]}}";
        })
    });
</script>
