@extends('democheckout.layout')

@section('content')
<script>
var paymethod = 1;
function optionClickPaymentType(i,t){
    paymethod = i;
}

</script>
<h2><span class="red">Оформление</span> заказа</h2>

<div id="cart-container">
@include('democheckout.goods',['goods'=>$goods])

<div id="order-options" style="margin-left: 10px;">

    <div id="payment">
        <div class="notice">
            <div class="icon"><img src="https://magnitolkin.ru/Files/Images/SectionPayment.png" alt="!"></div>
            <div class="comment">
                <div class="section_type_header">Способ оплаты</div>
                <div class="section_type_comment">Укажите предпочитаемый способ оплаты. Скорость прохождения платежа влияет на сроки доставки товара.</div>
            </div>
        </div>
        <style>
            .description {
                display: none;
                border: solid 1px rgba(0,0,0,.2);
                color: rgba(0,0,0,.6);
                font-size: 100%;
                width: 320px;
                padding: .4em;
                margin: 0 0 0 1.4em;
            }
        </style>
        <script>
            function optionClickPaymentType(i,t){
                $(".description").hide();
                $(t).parent().parent().parent().find("label").removeClass("selected");
                $(t).parent().addClass("selected").parent().find(".description").show();
            }
        </script>
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
                    <input type="radio" id="payment_type_4" name="payment_types" onclick="javascript:optionClickPaymentType(4, this)" data-payment-id="1">
                    Оплатить картой после получения (в течение 14 дней)
                </label>
                <div class="description">
                    Сумма полной стоимости заказа будет списана с Вашей карты автоматически через 14 дней после получения Вами заказа. Услуга предоставляется бесплатно сервисом Гаран24.
                </div>
            </div>
            <!--<script type="text/javascript">Order.addPaymentType(1, 0, "False", "False");</script>-->
        </div>
        <div class="clearfix"></div>
    </div>

    <div id="total_cost">
        <div class="label">Полная стоимость:</div>
        <div class="cost_value"><span id="lblTotalPrice">4 881</span> руб.</div>
    <!--
        <div style="margin-top: 15px;">
            <button id="btnCheckout" class="btn btn-success btn-lg">Перейти к оплате</button>
        </div>
        <script>
        $(document).ready(function(){
            $("#btnCheckout").click(function(){
                document.location.href = "../magnitolkin/checkcard";
            })
        });
        </script>
    -->

    </div>
    <div class="clearfix"></div>
    @include("magnitolkin.cart._buttons")
</div>
</div>

@endsection
