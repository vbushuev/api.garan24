@extends('checkout.layout')
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
    <h2><span class="red">Оформление</span> заказа</h2>
    <div id="order-form-container">
        @include('checkout.goods',['goods'=>$goods])
        <div id="order-options" style="margin-left: 10px;">
            <div id="delivery">
                <div class="notice">
                    <div class="icon"><img src="https://magnitolkin.ru/Files/Images/SectionPayment.png" alt="!"></div>
                    <div class="comment">
                        <div class="section_type_header">Способ оплаты</div>
                        <div class="section_type_comment">Укажите предпочитаемый способ оплаты. Скорость прохождения платежа влияет на сроки доставки товара.</div>
                    </div>
                </div>
                <div class="notice right">
                    <div class="icon"><img src="https://magnitolkin.ru/Files/Images/SectionDelivery.png" alt="!"></div>
                    <div class="comment">
                        <div class="section_type_header">Способ получения</div>
                        <div class="section_type_comment">Чтобы узнать полную стоимость заказа укажите способ получения товара</div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div id="delivery_types">
                    <!--<script type="text/javascript">Order.addDeliveryType(2, 0, 0, "False", "False");</script>-->
                    @foreach($delivery as $dt)
                        <div class="radio">
                            <label class="selected">
                                <input type="radio" id="delivery_type_{{$dt["id"]}}" checked="checked" name="delivery_types" onclick="javascript:optionClickDeliveryType({{$dt["id"]}}, this)" data-delivery-id="{{$dt["id"]}}">
                                {{$dt["name"]}}
                            </label>
                            <div class="description" style="display:block;">{!!$dt["desc"]!!}<br/><strong>Срок</strong> - до {{$dt["timelaps"]}} часов<br /><strong>Стоимость</strong> - {{$dt["price"]}}руб.</div>
                        </div>
                    @endforeach
                </div>
                <div id="payment_types">
                    @foreach($payments as $pt)
                        <div class="radio">
                            <label class="selected">
                                <input type="radio" id="payment_type_{{$pt["id"]}}" checked="checked" name="payment_types" onclick="javascript:optionClickPaymentType({{$pt["id"]}}, this)" data-payment-id="{{$pt["id"]}}">
                                {{$pt["name"]}}
                            </label>
                            <div class="description description_shot" style="display:block;">
                                {{$pt["desc"]}}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="clearfix"></div>
            <div id="total_cost">
                <div class="label">Полная стоимость:</div>
                <div class="cost_value"><span id="lblTotalPrice">4 881</span> руб.</div>
            </div>
            <div class="clearfix"></div>
        </div>

        <input type="hidden" id="delivery_type_id" name="delivery_type_id" />
        <input type="hidden" id="delivery_type_name" name="delivery_type_name" />
        <input type="hidden" id="delivery_type_desc" name="delivery_type_desc" />
        <input type="hidden" id="payment_type_id" name="payment_type_id" />
        <input type="hidden" id="payment_type_name" name="payment_type_name" />
        <input type="hidden" id="payment_type_desc" name="payment_type_desc" />
        @include("checkout._buttons")
    </div>
    <script>
        /*
         * delivery:
         0 - курьер по москве экспресс
         1 - rehmth по москве
         2 - самовывоз
         3 - почтой России
         4 - BoxBerry
         5 - За МКАД
         * payment
         0 - garan24 pay
         1 - delivery by card
         2 - online by card
         3 - cash
        */
        garan.delivery.add({id:"curier_express",name:"",description:"Доставка осуществляется курьерской службой интернет магазина.",duration:"3 часа",cost:"600"});
        garan.delivery.add({id:"curier",name:"Доставка курьером по Москве",description:"Доставка осуществляется курьерской службой интернет магазина.",duration:"на следующий рабочий день",cost:"300"});
        garan.delivery.add({id:"self",name:"Самовывоз",description:"Вы самостоятельно получаете заказ в офисе интернет магазина.",duration:"на следующий рабочий день",cost:"бесплатно"});
        garan.delivery.add({id:"post",name:"Доставка по России",description:"Доставка по России осуществляется Почтой России.",duration:"до 20 дней",cost:"300"});
        garan.delivery.add({id:"boxberry",name:"Доставка BoxBerry",description:"Доставка производится до ближайшего к Вам пункта выдачи заказов Boxberry.",duration:"до 11 дней",cost:"300"});
        garan.delivery.add({id:"curier_mkad",name:"Доставка курьером за МКАД",description:"Доставка осуществляется курьерской службой интернет магазина",duration:"на следующий рабочий день",cost:"300руб. + 30руб. за каждый километр от МКАД"});
        var deliverypayDependence = [
            [true,true,true,true],
            [true,true,true,true],
            [false,true,true,true],
            [true,false,true,true],
            [true,true,true,true],
            [true,true,true,true]
        ];
        var paydeliveryDependence = [
            [true,true,false,true,true,true],
            [true,true,true,false,true,true],
            [true,true,true,true,true,true],
            [true,true,true,true,true,true]
        ];
        var currentPay  = 2;
        var currentDelivery = 1;
        var currentDescription = '.description';
        /**
         * Number.prototype.format(n, x, s, c)
         *
         * @param integer n: length of decimal
         * @param integer x: length of whole part
         * @param mixed   s: sections delimiter
         * @param mixed   c: decimal delimiter
         */
        Number.prototype.format = function(n, x, s, c) {
            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                num = this.toFixed(Math.max(0, ~~n));

            return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
        };
        function caclulateTotal(i){
            var totalDelivery = isNaN(garan.delivery.list[i].cost)?garan.delivery.list[i].cost:parseInt(garan.delivery.list[i].cost);
            var total = 0;
            $(".productPrice").each(function(){
                total+=parseInt($(this).text().replace(/\s+/ig,''));
            });
            total += isNaN(garan.delivery.list[i].cost)?0:parseInt(garan.delivery.list[i].cost);
            $("#totalDeliveryPrice").html(isNaN(totalDelivery)?totalDelivery:totalDelivery.format(0,3,' ','.')+" руб.");
            $("#lblTotalPrice").html(total.format(0,3,' ','.'));
        }
        function optionClickPaymentType(i,t){
            currentPay = i;
            currentDescription = (currentDelivery==0 || currentDelivery==1 || currentDelivery==2 || currentDelivery==5 )?".description_shot":'.description';
            $(t).parent().parent().parent().find(".description,.description_shot").hide();
            $(t).parent().parent().parent().find("label").removeClass("selected");
            $(t).parent().addClass("selected").parent().find(currentDescription).show();

            window.garan_submit_args.url = (i==0)?"../checkout/passport":"../checkout/card";
            setHiddenValues();
        }
        function optionClickDeliveryType(i,t){
            currentDelivery = i;
            currentDescription = (currentDelivery==0 || currentDelivery==1 || currentDelivery==2 || currentDelivery==5 )?".description_shot":'.description';
            $("#payment_types .description:visible,#payment_types .description_shot:visible").hide().parent().find(currentDescription).show();
            $(t).parent().parent().parent().find(".description").hide();
            $(t).parent().parent().parent().find("label").removeClass("selected");
            $(t).parent().addClass("selected").parent().find(".description").show();
            if(i==2){$("[data-payment-id=0]").parent().parent().hide();optionClickPaymentType(2,"[data-payment-id=2]");}
            else {$("[data-payment-id=0]").parent().parent().show();}
            if(i==3){$("[data-payment-id=1]").parent().parent().hide();optionClickPaymentType(2,"[data-payment-id=2]");}
            else $("[data-payment-id=1]").parent().parent().show();
            caclulateTotal(i);
            $(".delivery-row").show();
            window.garan_submit_args.url = (i==0 || i==1 || i==5)?"../checkout/thanks":"../checkout/card";
            setHiddenValues();

        }
        function setHiddenValues(){
            var selected_payment = $("#payment_types input:checked");
            var selected_delivery = $("#delivery_types input:checked");
            $("#delivery_type_id").val(selected_delivery.attr("data-delivery-id"));
            $("#delivery_type_name").val(selected_delivery.parent().text());
            $("#delivery_type_desc").val(selected_delivery.parent().parent().find(".description").html());

            $("#payment_type_id").val(selected_payment.attr("data-payment-id"));
            $("#payment_type_name").val(selected_payment.parent().text());
            $("#payment_type_desc").val(selected_payment.parent().parent().find(currentDescription).html());
        }
        $(document).ready(function(){
            optionClickPaymentType(2);
            optionClickDeliveryType(1);
            //caclulateTotal(1);
        });
    </script>
@endsection
