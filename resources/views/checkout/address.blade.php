<a href="#" id="DeliveryAddressContainerOpener">Выбрать адрес доставки</a>
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
<div id="DeliveryAddressContainer" class="form-group" class="garan24-popup" style="background-color:rgba(255,255,255,1);padding 1em;">
    <label class="control-label">Ваш адрес:</label>
    <div class="row" style="display:none;">
        <div class="col-lg-6">
            <div class="form-group">
                @include('elements.inputs.combo',[
                    "required" => "required",
                    "name"=>"billing[country]",
                    "text"=>"Страна",
                    "values"=>[
                        ["key"=>"RU","value"=>"Россия"],
                        ["key"=>"BY","value"=>"Белоруссия"],
                        ["key"=>"KZ","value"=>"Казахстан"],
                        "divider",
                        ["key"=>"GB","value"=>"United Kingdom"],
                        ["key"=>"US","value"=>"United States"],
                        ["key"=>"LX","value"=>"Luxemburg"]
                    ]
                ])
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                @include('elements.inputs.text',["name"=>"billing[state]","text"=>"Район","value"=>$customer["billing_address"]["state"]])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                @include('elements.inputs.text',["id"=>"shipping_postcode","name"=>"billing[postcode]","text"=>"Почтовый индекс","value"=>$customer["billing_address"]["postcode"]])
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                @include('elements.inputs.text',["id"=>"shipping_city","name"=>"billing[city]","text"=>"Город","value"=>$customer["billing_address"]["city"]])
            </div>
        </div>
    </div>
    <div class="form-group">
        @include('elements.inputs.text',["id"=>"shipping_address_1","name"=>"billing[address_1]","text"=>"Адрес","value"=>$customer["billing_address"]["address_1"]])
    </div>
    <div class="garan-message">

    </div>
</div>
<input type="hidden" name="billing[country]" value="RU" />
<input type="hidden" id="boxberry_city" name="billing[city]" value="Москва" />
<input type="hidden" id="boxberry_address_1" name="billing[address_1]" value="" />
<input type="hidden" id="boxberry_postcode" name="billing[postcode]" value="" />
<input type="hidden" id="shipping_price" name="shipping_price" value="" />
<script>
    $(document).ready(function(){
        var addrdialog = $( "#DeliveryAddressContainer" ).dialog({
          autoOpen: false,
          //height: 400,
          width: 640,
          modal: true,
          buttons: {
            "Выбрать": function() {
                var price = $("#ShippingAmountHidden").val();
                $("#totalDeliveryPrice").text(price+" руб.");
                caclulateTotal();
                var delivery_address = "Доставка <a href='https://boxberry.ru' taget='__blank'>Boxberry</a>";
                delivery_address+= "<br /><small>"+$("#shipping_city").val()+", "+$("#shipping_postcode").val()+", "+$("#shipping_address_1").val()+"</small>";
                $(".delivery-address").html(delivery_address);
                addrdialog.dialog( "close" );
                $("#boxberry_postcode").val($("#shipping_postcode").val());
                $("#boxberry_city").val($("#shipping_city").val());
                $("#boxberry_address_1").val($("#shipping_address_1").val());
            }
          },
          close: function() {}
        });
        $("#DeliveryAddressContainerOpener").on("click",function(){
            console.debug("open dialog "+addrdialog);
            addrdialog.dialog("open");
        });
        $("#shipping_postcode").on("change keyup blur",function(){
            var t = this, $t = $(this), v = $t.val(),$m=$("#DeliveryAddressContainer .garan-message");
            $.ajax({
                url:"https://service.garan24.ru/shipping/bb",
                method:"post",
                dataType:"json",
                data:JSON.stringify({
                    method:"ZipCheck",
                    data:{Zip:v}
                }),
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
                                $m.html("Стоимость доставки <strong>"+price+" руб.</strong>");
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

        });
    });
</script>
