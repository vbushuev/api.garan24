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
<div id="shipping-type-6" class="shipping-type" style="display:none;">
    <div class="form-group">
        <label for="billing[postcode]" class="control-label">Ваш почтовый индекс:</label>
        @include('elements.inputs.text',["id"=>"shipping_postcode","required"=>"required","icon"=>"map-marker","name"=>"billing[postcode]","text"=>"Почтовый индекс","value"=>$deal->getCustomer()->toArray()["billing_address"]["postcode"]])
    </div>
    <div class="form-group">
        <label for="billing[city]" class="control-label">Ваш город:</label>
        @include('elements.inputs.text',["id"=>"shipping_city","icon"=>"bank","name"=>"billing[city]","text"=>"Город","value"=>$deal->getCustomer()->toArray()["billing_address"]["city"]])
    </div>
    <div class="form-group">
        <label for="billing[address_1]" class="control-label">Улица и дом:</label>
        @include('elements.inputs.text',["id"=>"shipping_address_1","icon"=>"building-o","name"=>"billing[address_1]","text"=>"Адрес","value"=>$deal->getCustomer()->toArray()["billing_address"]["address_1"]])
    </div>
    <div class="garan-message" style="margin-bottom:2em;"></div>

    <script>
        function getShippingCost(){
            var t = $("#shipping_postcode").get(), $t = $("#shipping_postcode"), v = $t.val(),$m=$("#cart-shipping .total");
            var callback = (arguments.length)?arguments[0]:(function(){});
            if(v.length==6){
                $.ajax({
                    url:"//l.gauzymall.com/shipping/bb",
                    method:"post",
                    dataType:"json",
                    data:JSON.stringify({
                        method:"ZipCheck",
                        data:{Zip:v}
                    }),
                    beforeSend:function(){
                        //$m.html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span>Уточняю стоимость ...</span>');
                    },
                    success:function(d,s,x){
                        console.debug(d);
                        console.debug("d[0].ExpressDelivery: "+d[0].ExpressDelivery);
                        if(d[0].ExpressDelivery){
                            $m.html("");
                            $.ajax({
                                url:"//l.gauzymall.com/shipping/bb",
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

                                    var delivery_address = 'Доставка <b>Boxberry Курьер</b>';
                                    var delivery_address_2 = '<br /><small>Ориентировочный срок: 20 дн.</small>';
                                    delivery_address+= "<br /><small class='shipping-city'>"+$("#shipping_city").val()+"</small>, "+$("#shipping_postcode").val()+", <small class='shipping-address-1'>"+$("#shipping_address_1").val()+"</small>";
                                    delivery_address+= delivery_address_2;
                                    $("#boxberry_address_2").val(delivery_address_2);
                                    price = parseInt(price);
                                    $("#cart-shipping .total").html(delivery_address);
                                    $("#cart-shipping .amount").html(price.format(0,3,' ','.')+" руб.");
                                    //SALE
                                    $("#cart-shipping .amount").html("<strike>"+$("#cart-shipping .amount").html()+"</strike><br/>0 руб.");
                                    $("#ShippingAmountHidden").val(0);
                                    //$("#cart-shipping .amount").css("text-decoration","line-through");

                                    $("#boxberry_postcode").val($("#shipping_postcode").val());
                                    $("#boxberry_city").val($("#shipping_city").val());
                                    $("#boxberry_address_1").val($("#shipping_address_1").val());
                                    $("#boxberry_address_2").val("");

                                    calculateTotal();
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
            $("#shipping_postcode").on("change keyup blur",function(){
                getShippingCost();
            });
            $("#shipping_city").on("change keyup blur",function(){
                $(".shipping-city").text($(this).val());
            });
            $("#shipping_address_1").on("change keyup blur",function(){
                $(".shipping-address-1").text($(this).val());
            });
            $("#forward").click(function(){
                if(!$("#ShippingAmountHidden").val().length){
                    getShippingCost(garan.form.submit(garan_submit_args));
                }
            });

        });
    </script>
</div>
