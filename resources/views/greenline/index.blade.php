<style>
    @import url("//fonts.googleapis.com/css?family=Lato:100|Open+Sans:300,400,800&subset=latin,cyrillic");
    @import url("//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css");
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
    }

    .gl-container a {
        display: inline-block;
        color: #fff;
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
        font-family: 'Lato', 'Open Sans', Helvetica, Arial, sans-serif;
        font-weight: normal;
        font-size: 0.9em;
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
        font-size: 1em;
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
        font-size: 1.2em;
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
                    <a href="https://www.gauzymall.com"><strong>Gauzymall</strong></a>
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
                    @if(isset($installments))<li><a href="javascript:{0}" id="installments">Рассрочка</a></li>@endif
                </ul>
                <ul class="gl-nav__right gl-clearfix">
                    @if(isset($sale))<li><a href="javascript:{0}" id="sale">Акция</a></li>@endif
                    <li><a href="javascript:{0}" id="about">О нас</a></li>
                    <li><a href="tel:88007075103"><span class="gl-mobile-visible">Телефон </span>8 800 707 51 03</a></li>
                    <li><a href="mailto:info@garan24.ru"><i class="fa fa-envelope-o gl-mobile-invisible" aria-hidden="true"></i><span class="gl-mobile-visible">Электронная почта</span></a></li>
                    <li><a href="#"><i class="fa fa-language gl-mobile-invisible" aria-hidden="true"></i><span class="gl-mobile-visible">Перевод</span></a></li>
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
<script>
var gl_mobile_menu = document.getElementById( "glMobileMenu" );

gl_mobile_menu.addEventListener( "click", handle_nav_click, false );

function handle_nav_click() {

    var gl_nav = document.getElementById( "glNav" );

    var gl_nav_display_prop = getComputedStyle( gl_nav ).display;

    if ( gl_nav_display_prop == 'none' ) {

        show_navigation();

    } else if ( gl_nav_display_prop == 'block' ) {

        hide_navigation();

    }

}

function setClass( el, className ) {

    if ( el.classList )

        el.classList.add( className );

    else

        el.className += ' ' + className;

}

function removeClass( el, className ) {

    if ( el.classList )

        el.classList.remove( className );

    else

        el.className = el.className.replace( new RegExp( '(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi' ), ' ' );

}

window.addEventListener( 'resize', handle_nav_resize, false );

function handle_nav_resize() {

    if ( window.innerWidth < 768 ) {

        hide_navigation();

    } else {

        show_navigation();

    }

}

function show_navigation() {

    var gl_nav = document.getElementById( "glNav" );

    gl_nav.style.display = 'block';

    setClass( gl_mobile_menu, 'toggled' );

}

function hide_navigation() {

    var gl_nav = document.getElementById( "glNav" );

    gl_nav.style.display = 'none';

    removeClass( gl_mobile_menu, 'toggled' );

}

var gl_popup_overlay = document.getElementById( "glPopupOverlay" );

gl_popup_overlay.addEventListener( "click", handle_overlay_click, false );

var gl_popup_close = document.getElementById( "glPopupClose" );

gl_popup_close.addEventListener( "click", handle_close_click, false );

var gl_popup = document.getElementById( "glPopup" );

function handle_overlay_click(){

    close_gl_popup();

}

function handle_close_click(){

    close_gl_popup();

}

document.addEventListener( 'keyup', function( e ) {

    if( e.keyCode == 27 ) {

        close_gl_popup();

    }

}, false );

function close_gl_popup(){

    gl_popup_overlay.style.display = 'none';
    gl_popup.style.display = 'none';

    var gl_popup_content = document.getElementById( 'glPopupContent' );

    var gl_sections = gl_popup_content.children;

    for ( var index = 0; index < gl_sections.length; ++index) {
        gl_sections[index].style.display = 'none';
    }

}

function openPopup( section_id ) {

    close_gl_popup();

    var gl_section = document.getElementById( section_id );

    gl_popup_overlay.style.display = 'block';

    gl_popup.style.display = 'block';

    gl_section.style.display = 'block';

}
var ba = {
    checkout:function (){
        var its = this.parse();
        xG.checkout(its);
    },
    parse:function(){
        var pp = [];
        var rows = document.getElementsByClassName("cart-item");
        console.debug("items found "+rows.length);
        for(var i= 0;i<rows.length;++i){
            var row = rows[i];
            var cells = row.getElementsByTagName("td");
            var price_spans = cells[1].getElementsByTagName("div")[0].getElementsByTagName("span");
            console.debug(price_spans);
            var origprice =(price_spans.length>2)?price_spans[1].innerHTML:price_spans[0].innerHTML;
            var price =(price_spans.length>2)?price_spans[2].innerHTML:price_spans[1].innerHTML;
            var sale =(price_spans.length>2)?price_spans[4].innerHTML:price_spans[1].innerHTML;
            origprice = origprice.replace(/[^\d\.,]/ig,"").replace(/,/ig,".").replace(/\.$/,"");
            price = price.replace(/[^\d\.,]/ig,"").replace(/,/ig,".").replace(/\.$/,"");
            sale = sale.replace(/[^\d\.,]/ig,"").replace(/,/ig,".").replace(/\.$/,"");
            var p = {
                shop:"brandalley",
                quantity:cells[4].getElementsByClassName("quantity")[0].getElementsByTagName("span")[0].getElementsByTagName("input")[0].value,
                currency:'EUR',
                original_price:origprice,
                regular_price:price,
                sale_price:sale,
                title:cells[0].getElementsByTagName("div")[2].getElementsByTagName("div")[0].getElementsByTagName("a")[0].innerHTML.replace(/[`']/,''),
                description:cells[0].getElementsByTagName("div")[2].getElementsByTagName("div")[1].getElementsByTagName("a")[0].innerHTML.replace(/[`']/,''),
                product_img:"http:"+cells[0].getElementsByTagName("div")[0].getElementsByTagName("a")[0].getElementsByTagName("img")[0].getAttribute("src"),
                product_url:"https://www-v6.brandalley.fr"+cells[0].getElementsByTagName("div")[2].getElementsByTagName("div")[1].getElementsByTagName("a")[0].getAttribute("href"),
                sku:"BRA"+cells[0].getElementsByTagName("div")[2].getElementsByTagName("div")[1].getElementsByTagName("a")[0].getAttribute("href").replace(/\D/g,''),
                variations:{
                    size:(typeof cells[0].getElementsByTagName("div")[2].getElementsByClassName("info_product_sup")[0]!="undefined")?cells[0].getElementsByTagName("div")[2].getElementsByClassName("info_product_sup")[0].innerHTML:"",
                    color:""
                }
            };
            pp.push(p);
        };
        console.log(pp);
        return pp;
    }
};


    document.getElementById( 'howtobuy' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_howtobuy' );}, false );
    document.getElementById( 'shipping' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_shipping' );}, false );
    document.getElementById( 'payment' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_payment' );}, false );
    document.getElementById( 'installments' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_installments' );}, false );
    document.getElementById( 'sale' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_sale' );}, false );
    document.getElementById( 'about' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_about' );}, false );

    var tohide = [];
    tohide = tohide.concat(document.getElementsByClassName( 'footer_paiement' ));
    tohide = tohide.concat(document.getElementsByClassName( 'bon_achat' ))
    console.debug(tohide);
    for(var i=0;i<tohide.length;++i){
        var itm = tohide[i][0];
        if(itm!=null && typeof itm!="undefined") itm.style.display = 'none';
    }

    var checkout = document.getElementById( 'panier-valider' );
    if(typeof checkout != 'undefined' && checkout != null){
        checkout.setAttribute("href","javascript:{0}");
        var clone = checkout.cloneNode();
        //while (checkout.firstChild) {clone.appendChild(checkout.lastChild);}
        checkout.parentNode.replaceChild(clone, checkout);
        clone.innerHTML = 'Оформить заказ';
        clone.addEventListener( 'click', function( event ){
            event.preventDefault();
            event.stopPropagation();
            ba.checkout();
        }, false );
    }
    <!-- Currencies -->
    var pe = [];
    var priceElements = document.getElementsByClassName("block_price");
    if(priceElements!=null && typeof priceElements!="undefined"){
        for (var i=0;i<priceElements.length;++i) {
            var el = priceElements[i];
            //console.debug(el);
            if(el==null || typeof el=="undefined")break;
            var el1 = el.getElementsByTagName("span");
            if(el1!=null){
                if(el1.length>1){
                    pe.push(el1[1]);
                    pe.push(el1[2]);
                }
                else pe.push(el1[0]);
            }

        }
    }
    priceElements = document.getElementsByClassName("price_total");
    if(priceElements!=null && typeof priceElements!="undefined"){
        for (var i=0;i<priceElements.length;++i) {
            pe.push(priceElements[i]);
        }
    }
    xG.currency.get(pe,"EUR");

    <!-- Yandex.Metrika counter -->
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter{{$yandexCounterId}} = new Ya.Metrika({
                    id:{{$yandexCounterId}},
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
