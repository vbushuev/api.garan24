@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
<style>
    .description, .description_shot {
        display: none;
        border: solid 1px rgba(0,0,0,.2);
        color: rgba(0,0,0,.6);
        font-size: 100%;
        padding: .4em;
        margin: 0 0 0 1.4em;
    }
</style>
    <div class="row">
        <h3><i class="first">Способ</i> получения <i class="fa fa-bus" aria-hidden="true"></i></h3>
        <div id="delivery_types" class="list-group required">
            @foreach($delivery as $it)
                <a href="#" class="list-group-item" id="delivery-type-{{$it["id"]}}" data-id="{{$it["id"]}}" data-desc="{{$it["desc"]}}">
                    <h4 class="list-group-item-heading"><i class="fa fa-square-o"></i> {{$it["name"]}}</h4>
                    <p class="list-group-item-text small">{{$it["desc"]}}</p>
                </a>
            @endforeach
        </div>
        @include($viewFolder.'._boxberry')
        @include($viewFolder.'.address')
    </div>

    <input type="hidden" id="delivery_type_id" name="delivery_id" />
    <input type="hidden" id="delivery_type_name" name="delivery_type_name" />
    <input type="hidden" id="delivery_type_desc" name="delivery_type_desc" />
    <input type="hidden" name="billing[country]" value="RU" />
    <input type="hidden" id="boxberry_city" name="billing[city]" value="Москва" />
    <input type="hidden" id="boxberry_address_1" name="billing[address_1]" value="" />
    <input type="hidden" id="boxberry_address_2" name="billing[address_2]" value="" />
    <input type="hidden" id="boxberry_postcode" name="billing[postcode]" value="" />
    <input type="hidden" id="boxberry_id" name="billing[state]" value="0"/>

    <input type="hidden" id="boxberry_name" name="boxbery[name]"/>
    <input type="hidden" id="boxberry_address" name="boxbery[address]"/>
    <input type="hidden" id="boxberry_workschedule" name="boxbery[workschedule]"/>
    <input type="hidden" id="boxberry_phone" name="boxbery[phone]"/>
    <input type="hidden" id="boxberry_period" name="boxbery[period]"/>

    <input type="hidden" id="shipping_price" name="shipping_price" value="" />
    @include("$viewFolder._buttons",["gobackurl"=>"/checkout/?id=".$deal->order->id,"gobacktype"=>"get"])
    <script>
        $(document).ready(function(){

            //$("#forward").prop('disabled', true);
            $("#delivery_types .list-group-item").on("click",function(){
                $(".shipping-type").slideUp();
                var val = $(this).attr("data-id");
                if(val==6){
                    $("#shipping-type-6").slideDown();
                    $("#ShippingAmountHidden").val('');
                    $("#cart-shipping .total").html('');
                    $("#cart-shipping .amount").html('');

                    //$("#shipping_postcode").val("");
                    //$("#shipping_city").val("");
                    //$("#shipping_address_1").val("");
                    if($("#shipping_postcode").val().length){
                        getShippingCost();
                    }
                }
                $("#delivery_type_id").val(val);
                console.debug($(".row.payment"));
                return false;
            });
        });
    </script>
@endsection
