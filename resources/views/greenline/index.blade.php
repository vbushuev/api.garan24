<style>
    @import url("//fonts.googleapis.com/css?family=Lato:100|Open+Sans:300,400,800&subset=latin,cyrillic");
    @import url("//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css");
    @font-face {
        font-family: 'EngraversGothic BT Regular';
        /*src:url("//l.gauzymall.com/css/fonts/tt0586m_.ttf");*/
        src:url("/css/tt0586m_.ttf");
    }
    /*
    .main__area{
        max-width:132rem!important;
    }*/
    .gl-clearfix:after {
        content: "";
        display: table;
        clear: both;
    }

    .gl {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 9999;
        height:50px;
        line-height: 50px;
    }

    .gl-container {
        background-color: #00bf80;
        position: relative;
        height:50px;
        line-height: 50px;
        font-size: 1em!important;
    }

    .gl-container a {
        display: inline-block;
        color: #fff !important;
        text-decoration: none;
        font-family: sans-serif;
        line-height: 1.6em;
        padding: 10px 15px;
    }

    .gl-header {
        width: 100%;
        height:50px;
        line-height: 50px;
    }

    .gl-logo {
        float: left;
        height:50px;
        line-height: 50px;
    }
    .gl-logo a{
        font-family: 'EngraversGothic BT Regular';
        text-transform: uppercase;
        letter-spacing: .2em;
        font-size: 16px;
    }

    .gl-container a:hover {
        color: #444;
    }

    .gl-nav {
        display: none;
    }

    .gl-nav ul {
        display: block;
        list-style: none;
        padding: 0;
        margin: 0;

    }

    .gl-nav ul li {
        display: block;
        height:50px;
        line-height: 50px;
    }

    .gl-nav ul li a {
        font-family: 'Open Sans'!important;
        font-weight: 400!important;
        color:#fff!important;
        font-size: 16px!important;
    }

    .gl-mobile-menu-icon {
        float: right;
    }

    .gl-mobile-menu-icon button {
        background: none;
        border: none;
        color: #fff;
        font-size: 1em;
        line-height: 1.6em;
        padding: 10px 15px;
        text-transform: uppercase;
        font-weight: bold;
        cursor: pointer;
    }

    .gl-mobile-menu-icon button:focus {
        outline: none;
    }

    .gl-mobile-menu-icon button:hover {
        color: #444;
    }

    .gl-mobile-menu-icon button.toggled {
        color: #444;
    }

    .gl-popup-overlay {
        width: 100%;
        height: 100%;
        top: 45px;
        background: rgba(0,0,0,0.7);
        position: fixed;
        z-index: 9997;
        cursor: pointer;
    }

    .gl-popup {
        position: fixed;
        top: 45px;
        background: #fff;
        padding: 15px;
        width: 100%;
        max-width: 1170px;
        z-index: 9998;
        transform: translateX(-50%);
        left: 50%;
        min-height: 20px;
        box-sizing: border-box;
        box-shadow: 0 4px 24px rgba(0,0,0,0.5);
    }

    .gl-popup-close {
        display: block;
        float: right;
        line-height: 40px;
        font-size: 14px;
        text-transform: uppercase;
        background: none;
        border: none;
        cursor: pointer;
        color: #777;
        transition: all 0.2s ease-in;
        padding: 0;
    }

    .gl-popup-close:focus {
        outline: none;
    }

    .gl-popup-close:hover {
        color: red;
    }

    .gl-popup-content {
        max-height: 25em;
        overflow-y: scroll;
        width: 100%;
    }

    .gl-mobile-invisible {
        display: none;
    }

    .gl-popup-content section {
        line-height: 1.6em;
        font-size: 16px;
        font-family: 'Lato', 'Open Sans', Helvetica, Arial, sans-serif;
    }
    .gl-popup-content section p{
        margin-top: .8em;
    }
    .gl-popup-content section ul{
        margin:0 4em;
        text-align: left;
        list-style: disc;
    }
    .gl-popup-content section ul li{

    }
    .gl-popup-content section h1,.gl-popup-content section h2,.gl-popup-content section h3{
        font-weight: 800;
        font-family: 'Lato', 'Open Sans', Helvetica, Arial, sans-serif;
        font-size: 120%;
    }
    @media screen and (min-width: 768px) {

        .gl-logo {
            float: left;
        }

        .gl-nav {
            display: block;
        }

        .gl-nav ul {
            display: inline-block;
        }

        .gl-nav__left {
            float: left;
        }

        .gl-nav__right {
            float: right;
        }

        .gl-nav ul li {
            float: left;
        }

        .gl-header {
            width: auto;
            float: left;
        }

        .gl-mobile-menu-icon {
            display: none;
        }

        .gl-mobile-visible {
            display: none;
        }

        .gl-mobile-invisible {
            display: inline;
        }

    }

    @media screen and (min-width: 1024px) {



    }

    @media screen and (min-width: 1200px) {

        .gl-row {
            width: 1170px;
            margin: 0 auto;
        }

    }
</style>
<link href="css/greenline.css" rel="stylesheet">
<div class="gl">
    <div class="gl-container">
        <div class="gl-row gl-clearfix">
            <div class="gl-header gl-clearfix">
                <div class="gl-logo">
                    <a href="https://www.gauzymall.com">gauzymall</a>
                </div>
                <div class="gl-mobile-menu-icon">
                    <button id="glMobileMenu"><i class="fa fa-bars" aria-hidden="true"></i></button>
                </div>
            </div>
            <nav class="gl-nav" id="glNav">
                <ul class="gl-nav__left gl-clearfix">
                    <li><a href="javascript:{0}" id="howtobuy">Как купить</a></li>
                    <li><a href="javascript:{0}" id="shipping">Доставка</a></li>
                    <li><a href="javascript:{0}" id="payment">Оплата</a></li>
                    @if(isset($installments)&&count($installments))<li><a href="javascript:{0}" id="installments">Рассрочка</a></li>@endif
                </ul>
                <ul class="gl-nav__right gl-clearfix">
                    @if(strlen(trim($sale)))<li><a href="javascript:{0}" id="sale">Акция</a></li>@endif
                    <li><a href="javascript:{0}" id="about">О нас</a></li>
                    <li><a href="tel:88007075103"><span class="gl-mobile-visible">Телефон </span>8 800 707 51 03</a></li>
                    <li><a href="mailto:info@garan24.ru"><i class="fa fa-envelope-o gl-mobile-invisible" aria-hidden="true"></i><span class="gl-mobile-visible">Электронная почта</span></a></li>
                    <!--<li><a href="#"><i class="fa fa-language gl-mobile-invisible" aria-hidden="true"></i><span class="gl-mobile-visible">Перевод</span></a></li>-->
                </ul>
            </nav>
        </div>
    </div>
</div>
<div class="gl-popup-overlay" id="glPopupOverlay" style="display: none;"></div>
<div class="gl-popup" id="glPopup" style="display: none;">
    <button class="gl-popup-close" id="glPopupClose" ><i class="fa fa-times fa-2x">&nbsp;</i></button>
    <div class="gl-popup-content" id="glPopupContent">
        <section id="section_howtobuy" style="display: none;">{!!$howtobuy!!}</section>
        <section id="section_shipping" style="display: none;">{!!$shipping!!}</section>
        <section id="section_payment" style="display: none;">{!!$payment!!}</section>
        @if(isset($installments))<section id="section_installments" style="display: none;">{!!$installments!!}</section>@endif
        @if(isset($sale))<section id="section_sale" style="display: none;">{!!$sale!!}</section>@endif

        <section id="section_about" style="display: none;">
            @if(isset($about))
                {!!$about!!}
            @else
                <h3>О нас</h3>
                <p><strong>Сервис Gauzymall</strong> – это сервис европейской компании <strong>G24 Europe</strong>, предоставляющий Вам свою помощь в приобретении товаров в зарубежных интернет магазинах с доставкой в Россию.</p>
                <p>Пользуясь нашим сервисом, Вы можете совершать покупки в разных интернет магазинах Европы и других стран, складывая выбранные товары в единую корзину.</p>
                <p>Наши главные преимущества:</p>
                <ul>
                    <li>Удобная услуга «Мультикорзина», дающая возможность делать покупки в разных магазинах, оформляя при этом единый заказ, который будет доставлен одной посылкой с минимальными затратами на доставку.</li>
                    <li>Не нужно никаких дополнительных действий по оформлению заказа и доставки – Вы совершаете покупки привычным образом, так же, как и в любом российском интернет-магазине.</li>
                    <li>Отсутствие предоплаты товара, минимальный платеж  – всего 1 рубль, который осуществляется для проверки Вашей карты. Фактически Вы оплачиваете заказ после его доставки.</li>
                    <li>Стоимость покупок фиксируется в рублях на момент оформления заказа.</li>
                    <li>Оплата покупок производится банковской картой любого российского банка.</li>
                    <li>Нет платы за регистрацию или абонентской платы</li>
                    <li>Минимум дополнительных расходов – Вы оплачиваете только товары, доставку и наши расходы на оплату и оформление Вашего заказа.</li>
                </ul>
                <p>Технологическая поддержка сервиса осуществляется ООО «Гаран 24»</p>
            @endif
        </section>
    </div>
</div>
@include('greenline.scripts')
@if($site=="brandalley")
    @include('greenline.brandalley', ['yandex_metric' => $yandex_metric])
@elseif($site=="ctshirts")
    @include('greenline.ctshirts', ['yandex_metric' => $yandex_metric])
@endif
