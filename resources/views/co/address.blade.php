@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
<style>
    .garan-message{
        font-family: "Open Sans";
        font-size: 90%;
        text-align: center;
    }
    .garan-sorry{
        color: rgba(197,17,98 ,1);
    }
</style>
    <h3><i class="first">Ваш</i> адрес: </h3>
    <div class="form-group">
        <label for="billing[postcode]" class="control-label">Ваш почтовый индекс:</label>
        @include('elements.inputs.text',["id"=>"shipping_postcode","required"=>"required","icon"=>"map-marker","name"=>"billing[postcode]","text"=>"Почтовый индекс","value"=>$deal->getCustomer()->toArray()["billing_address"]["postcode"]])
    </div>
    <div class="form-group">
        <label for="billing[postcode]" class="control-label">Ваш город:</label>
        @include('elements.inputs.text',["id"=>"shipping_city","icon"=>"bank","name"=>"billing[city]","text"=>"Город","value"=>$deal->getCustomer()->toArray()["billing_address"]["city"]])
    </div>
    <div class="form-group">
        <label for="billing[postcode]" class="control-label">Улица и дом:</label>
        @include('elements.inputs.text',["id"=>"shipping_address_1","icon"=>"building-o","name"=>"billing[address_1]","text"=>"Адрес","value"=>$deal->getCustomer()->toArray()["billing_address"]["address_1"]])
    </div>
    <div class="garan-message" style="margin-bottom:2em;"></div>
    <div class="input-group hide">
    <input type="hidden" name="billing[country]" value="RU" />
    <input type="hidden" id="boxberry_city" name="billing[city]" value="Москва" />
    <input type="hidden" id="boxberry_address_1" name="billing[address_1]" value="" />
    <input type="hidden" id="boxberry_postcode" name="billing[postcode]" value="" />
    <input type="hidden" id="shipping_price" name="shipping_price" value="" />
    <input type="hidden" id="TotalAmountHidden" name="TotalAmountHidden"/>
    <input type="hidden" id="ShippingAmountHidden" name="shipping_cost" value="@if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
        @amount($deal->shipping_cost)
    @endif"/>
    </div>
    @include("$viewFolder._buttons")
    <script>
        function getShippingCost(){
            var t = $("#shipping_postcode").get(), $t = $("#shipping_postcode"), v = $t.val(),$m=$("#cart-shipping .total");
            var callback = (arguments.length)?arguments[0]:(function(){});
            if(v.length==6){
                $.ajax({
                    url:"https://service.garan24.ru/shipping/bb",
                    method:"post",
                    dataType:"json",
                    data:JSON.stringify({
                        method:"ZipCheck",
                        data:{Zip:v}
                    }),
                    beforeSend:function(){
                        $m.html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span>Уточняю стоимость ...</span>');
                    },
                    success:function(d,s,x){
                        console.debug(d);
                        console.debug("d[0].ExpressDelivery: "+d[0].ExpressDelivery);
                        if(d[0].ExpressDelivery){
                            $m.html("");
                            $.ajax({
                                url:"https://service.garan24.ru/shipping/bb",
                                method:"post",
                                dataType:"json",
                                data:JSON.stringify({
                                    method:"DeliveryCostsF",
                                    data:{
                                        weight:1000,
                                        type:2,
                                        target:v,
                                        ordersum:0
                                    }
                                }),
                                success:function(d,s,x){
                                    console.debug(d);
                                    var price = Math.floor(d.price_base*80)+150;
                                    console.debug("d.price_base: "+price);
                                    $("#ShippingAmountHidden").val(price);
                                    $m.html("Стоимость доставки <strong>"+price.format(2)+" руб.</strong>");
                                    calculateTotal();
                                    var delivery_address = 'Доставка <b>Boxberry</b> курьером';
                                    delivery_address+= "<br /><small>"+$("#shipping_city").val()+", "+$("#shipping_postcode").val()+", "+$("#shipping_address_1").val()+"</small>";
                                    price = parseInt(price);
                                    $("#cart-shipping .total").html(delivery_address);
                                    $("#cart-shipping .amount").html(price.format(0,3,' ','.')+" руб.");
                                    callback();
                                },
                                error:function(x,t,e){
                                    $m.html("<div class='garan-sorry'>В данный момент сервис расчета доставки не доступен. Уточнить стоимость доставки можно у наших операторов.</div>");
                                }
                            });
                        }
                        else{
                            $m.html("<div class='garan-sorry'>По адресам почтового индекса <strong>"+v+"</strong> Доставка курьером не осуществляется. Попробуйте выбрать ближайший к Вам пункт выдачи заказов Boxberry.</div>");
                        }
                    },
                    error:function(x,t,e){
                        $m.html("<div class='garan-sorry'>В данный момент сервис расчета доставки не доступен. Уточнить стоимость доставки можно у наших операторов.</div>");
                    }
                });
            }
        }
        $(document).ready(function(){
            $("#shipping_postcode,#shipping_city,#shipping_address_1").on("change keyup blur",function(){
                getShippingCost();
            });
            if(!$("#ShippingAmountHidden").val().length){
                $("#forward").click(function(){
                    getShippingCost(garan.form.submit(garan_submit_args));
                    ;
                });
            }
        });
    </script>
@endsection
