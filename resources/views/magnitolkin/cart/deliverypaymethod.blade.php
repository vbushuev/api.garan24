@extends('magnitolkin.cart.magnitolkin')

@section('content')

<h2><span class="red">Оформление</span> заказа</h2>

<div id="cart-container">

@include('magnitolkin.cart.goods')
<div id="order-options" style="margin-left: 10px;">
<style>
    .description {
        display: none;
        border: solid 1px rgba(0,0,0,.2);
        color: rgba(0,0,0,.6);
        font-size: 100%;
        padding: .4em;
        margin: 0 0 0 1.4em;
    }
</style>
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
    garan.delivery.add({id:"post",name:"Доставка по России",description:"Доставка по России осуществляется Почтой России.",duration:"до 20 дней",cost:"по тарифам"});
    garan.delivery.add({id:"boxberry",name:"Доставка BoxBerry",description:"Доставка производится до ближайшего к Вам пункта выдачи заказов Boxberry.",duration:"до 11 дней",cost:"по тарифам"});
    garan.delivery.add({id:"curier_mkad",name:"Доставка курьером за МКАД",description:"Доставка осуществляется курьерской службой интернет магазина",duration:"на следующий рабочий день",cost:"300руб. + 30руб. за каждый километр от МКАД"});
    console.debug(garan.delivery.list);
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
    function optionClickPaymentType(i,t){
        $(t).parent().parent().parent().find(".description").hide();
        $(t).parent().parent().parent().find("label").removeClass("selected");
        $(t).parent().addClass("selected").parent().find(".description").show();
        if(i==0){
            $("#btnMakeOrder").unbind('click').click(function(){
                document.location.href = "../magnitolkin/passport";
            })
        }

        else{
            $("#btnMakeOrder").unbind('click').click(function(){
                document.location.href = "../magnitolkin/checkcard";
            })
        }
    }
    function optionClickDeliveryType(i,t){
        $(t).parent().parent().parent().find(".description").hide();
        $(t).parent().parent().parent().find("label").removeClass("selected");
        $(t).parent().addClass("selected").parent().find(".description").show();
        if(i==2)$("[data-payment-id=0]").parent().parent().hide();
        else $("[data-payment-id=0]").parent().parent().show();
        if(i==3)$("[data-payment-id=1]").parent().parent().hide();
        else $("[data-payment-id=1]").parent().parent().show();

        var totalDelivery = isNaN(garan.delivery.list[i].cost)?garan.delivery.list[i].cost:parseInt(garan.delivery.list[i].cost);
        var total = parseInt($("#totalPrice14832").text().replace(/\s+/ig,''));
        total += isNaN(garan.delivery.list[i].cost)?0:parseInt(garan.delivery.list[i].cost);
        $("#totalDeliveryPrice").html(isNaN(totalDelivery)?totalDelivery:totalDelivery.format(0,3,' ','.')+" руб.");
        $("#lblTotalPrice").html(total.format(0,3,' ','.'));
        $(".delivery-row").show();
        if(i==0 || i==1 || i==5){
            $("#btnMakeOrder").unbind('click').click(function(){document.location.href = "../magnitolkin/thanks";});
        }
        else{
            $("#btnMakeOrder").unbind('click').click(function(){document.location.href = "../magnitolkin/checkcard";});
        }
    }
    $(document).ready(function(){
        optionClickDeliveryType(1);
    });
</script>
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

        <div class="radio">
            <label class="selected">
                <input type="radio" id="delivery_type_1" checked="checked" name="delivery_types" onclick="javascript:optionClickDeliveryType(1, this)" data-delivery-id="1">
                Доставка курьером по Москве
            </label>
            <div class="description" style="display:block;">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - на следующий рабочий день<br /><strong>Стоимость</strong> - 300руб.</div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(1, 0, 0, "True", "False");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="delivery_type_0" name="delivery_types" onclick="javascript:optionClickDeliveryType(0, this)" data-delivery-id="0">
                Доставка курьером по Москве (экспресс)
            </label>
            <div class="description">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - 3 часа с момента заказа<br /><strong>Стоимость</strong> - 600руб.</div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(7, 0, 0, "True", "False");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="delivery_type_3" name="delivery_types" onclick="javascript:optionClickDeliveryType(3, this)" data-delivery-id="3">
                Доставка по России
            </label>
            <div class="description">Доставка по России осуществляется Почтой России.<br/><strong>Срок</strong> - до 20 дней<br /><strong>Стоимость</strong> - 300руб.</div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(6, 300, 0, "True", "True");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="delivery_type_4" name="delivery_types" onclick="javascript:optionClickDeliveryType(4, this)" data-delivery-id="4">
                Доставка службой BoxBerry
            </label>
            <div class="description">Доставка производится до ближайшего к Вам пункта выдачи заказов Boxberry.<br/><strong>Срок</strong> - до 10 дней<br /><strong>Стоимость</strong> - 200руб.</div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(9, 0, 0, "True", "True");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="delivery_type_5" name="delivery_types" onclick="javascript:optionClickDeliveryType(5, this)" data-delivery-id="5">
                Доставка курьером за пределы МКАД
            </label>
            <div class="description">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - на следующий рабочий день<br /><strong>Стоимость</strong> - 300руб. + 30руб. за каждый километр от МКАД</div>
        </div>
        <!--<script type="text/javascript">Order.addDeliveryType(3, 0, 30, "True", "False");</script>-->
        <div class="radio">
            <label>
                <input type="radio" id="delivery_type_2" name="delivery_types" onclick="javascript:optionClickDeliveryType(2, this)" data-delivery-id="2">
                Самовывоз
            </label>
            <div class="description">
                Вы самостоятельно получаете заказ в офисе интернет магазина.<br/><strong>Срок</strong> - на следующий рабочий день<br /><strong>Стоимость</strong> - бесплатно
            </div>
        </div>
    </div>
    <div id="payment_types">
        <div class="radio">
            <label class="selected">
                <input type="radio" id="payment_type_2" checked="checked" name="payment_types" onclick="javascript:optionClickPaymentType(2, this)" data-payment-id="2">
                Оплатить картой сейчас
            </label>
            <div class="description" style="display:block;">
                На следующем экране Вам нужно будет указать реквизиты своей банковской карты, после чего с нее будет списана полная стоимость заказа.
            </div>
        </div>
        <!--<script type="text/javascript">Order.addPaymentType(2, 0, "False", "True");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="payment_type_3" name="payment_types" onclick="javascript:optionClickPaymentType(3, this)" data-payment-id="3">
                Оплатить наличными при получении
            </label>
            <div class="description">
                Вы оплачиваете полную стоимость заказа наличными курьеру или сотруднику пункта выдачи заказов при получении заказа.<br />
                Чтобы оплатить заказ наличными при получении для выбранного Вами способа получения заказа, Вам необходимо сейчас сделать предоплату стоимости доставки банковской картой.
            </div>
        </div>
        <!--<script type="text/javascript">Order.addPaymentType(3, 0, "True", "True");</script>-->

        <div class="radio">
            <label>
                <input type="radio" id="payment_type_1" name="payment_types" onclick="javascript:optionClickPaymentType(1, this)" data-payment-id="1">
                Оплатить картой при получении
            </label>
            <div class="description">
                Вы оплачиваете полную стоимость заказа банковской картой Visa\MC курьеру или сотруднику пункта выдачи заказов при получении заказа.<br />
                Чтобы оплатить заказ банковской картой
                при получении для выбранного Вами способа получения заказа,
                Необходимо сейчас сделать предоплату стоимости доставки банковской картой.
            </div>
        </div>

        <div class="radio">
            <label>
                <input type="radio" id="payment_type_0" name="payment_types" onclick="javascript:optionClickPaymentType(0, this)" data-payment-id="0">
                Оплатить картой после получения (в течение 14 дней)
            </label>
            <div class="description">
                Сумма полной стоимости заказа будет списана с Вашей карты автоматически через 14 дней после получения Вами заказа. Услуга предоставляется бесплатно сервисом Гаран24.
            </div>
        </div>
        <!--<script type="text/javascript">Order.addPaymentType(1, 0, "False", "False");</script>-->
    </div>


</div>
<div class="clearfix"></div>
<div class="form-group">
    @include('elements.inputs.checkbox',["name"=>"agree1","text"=>"Я согласен с условиями."])
    <p class="text-muted small">Указав согласие, Вы принимаете <a href="https://garan24.ru/terms" target="__blank">соглашение</a> Гаран24</p>
</div>
<div class="clearfix"></div>
    <div id="total_cost">
        <div class="label">Полная стоимость:</div>
        <div class="cost_value"><span id="lblTotalPrice">4 881</span> руб.</div>
    </div>
    <div class="clearfix"></div>
    @include("magnitolkin.cart._buttons")
</div>
</div>

@endsection
