@include('greenline.styles')
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
                    @if(strlen(trim($sale)))<li><a href="javascript:{0}" id="sale">Акция</a></li>@endif
                    <!--<li id="xr_g_searchField"><input  id="xr_g_searchInput" type="text" placeholder="Поиск товаров"</li>-->
                </ul>
                <ul class="gl-nav__right gl-clearfix">

                    <li><a href="javascript:{0}" id="about"><i class="fa fa-info"></i>&nbsp;</a></li>
                    <li><a href="tel:88007075103"><i class="fa fa-phone"></i> 8 800 707 51 03</a></li>
                    <li><a href="mailto:info@garan24.ru"><i class="fa fa-envelope-o gl-mobile-invisible" aria-hidden="true"></i><span class="gl-mobile-visible">Электронная почта</span>&nbsp;</a></li>
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


    <!-- Yandex.Metrika counter -->
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter{{$yandex_metric or $yandexCounterId}} = new Ya.Metrika({
                    id:{{$yandex_metric or $yandexCounterId}},
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

    if(document.getElementById( 'howtobuy' )!=null)document.getElementById( 'howtobuy' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_howtobuy' );}, false );
    if(document.getElementById( 'shipping' )!=null)document.getElementById( 'shipping' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_shipping' );}, false );
    if(document.getElementById( 'payment' )!=null)document.getElementById( 'payment' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_payment' );}, false );
    if(document.getElementById( 'installments' )!=null)document.getElementById( 'installments' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_installments' );}, false );
    if(document.getElementById( 'sale' )!=null)document.getElementById( 'sale' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_sale' );}, false );
    if(document.getElementById( 'about' )!=null)document.getElementById( 'about' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_about' );}, false );
    if(document.getElementById( 'search')!=null)document.getElementById( 'search' ).addEventListener('click',function(e){
        e.preventDefault();
        console.debug("Let's search");
        var sf = document.getElementById( 'xr_g_searchField');
        if(sf == null) return;
        sf.style.display="inline-block";
    },false);
    @if($site=="brandalley")
        var ba = {
            parse:function(){
                var pp = [];
                var rows = document.getElementsByClassName("cart-item");
                console.debug("items found "+rows.length);
                for(var i= 0;i<rows.length;++i){
                    var row = rows[i],p=null;
                    if(xG.isMobile.any()){
                        console.debug("Mobile version");

                        var origprice =row.querySelector(".price_unitaire .xg_converted").innerHTML;
                        var price =row.querySelectorAll(".price_unitaire span")[1].innerHTML;
                        var sale =price;
                        origprice = origprice.replace(/[^\d\.,]/ig,"").replace(/,/ig,".").replace(/\.$/,"");
                        price = price.replace(/[^\d\.,]/ig,"").replace(/,/ig,".").replace(/\.$/,"");
                        sale = sale.replace(/[^\d\.,]/ig,"").replace(/,/ig,".").replace(/\.$/,"");
                        var p = {
                            shop:"brandalley",
                            quantity:row.nextSibling.nextSibling.querySelector(".block_quantity form .quantity span input").value,
                            currency:'EUR',
                            original_price:origprice,
                            regular_price:price,
                            sale_price:sale,
                            title:row.querySelector(".title_product a").innerHTML.replace(/[`']/,''),
                            description:row.querySelector(".ss_title_product a").innerHTML.replace(/[`']/,''),
                            product_img:"http:"+row.querySelector(".articleItemImg img").getAttribute("src"),
                            product_url:"https://www.brandalley.fr"+row.querySelector(".title_product a").getAttribute("href"),
                            sku:"BRA"+row.querySelector(".title_product a").getAttribute("href").replace(/\D/g,''),
                            variations:{
                                size:row.querySelector(".info_product_sup").innerHTML,
                                color:""
                            }
                        };
                    }
                    else {
                        var cells = row.getElementsByTagName("td");
                        var price_spans = cells[1].getElementsByTagName("div")[0].getElementsByTagName("span");
                        console.debug(price_spans);
                        var origprice =(price_spans.length>2)?price_spans[1].innerHTML:price_spans[0].innerHTML;
                        var price =(price_spans.length>2)?price_spans[2].innerHTML:price_spans[1].innerHTML;
                        var sale =(price_spans.length>4)?price_spans[4].innerHTML:price_spans[1].innerHTML;
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
                            product_url:"https://www.brandalley.fr"+cells[0].getElementsByTagName("div")[2].getElementsByTagName("div")[1].getElementsByTagName("a")[0].getAttribute("href"),
                            sku:"BRA"+cells[0].getElementsByTagName("div")[2].getElementsByTagName("div")[1].getElementsByTagName("a")[0].getAttribute("href").replace(/\D/g,''),
                            variations:{
                                size:(typeof cells[0].getElementsByTagName("div")[2].getElementsByClassName("info_product_sup")[0]!="undefined")?cells[0].getElementsByTagName("div")[2].getElementsByClassName("info_product_sup")[0].innerHTML:"",
                                color:""
                            }
                        };
                    }
                    (p!=null)?pp.push(p):{};
                };
                console.log(pp);
                return pp;
            }
        };
        //xG.hide(".footer_paiement,.bon_achat,.wishlist_part,#account-user-group,#sticky_footer");
        xG.hide(".code_promo_form,.bon_achat,.wishlist_part,#account-user-group,#sticky_footer");
        var add2cart = document.querySelectorAll(".button_add_cart");
        for(var i=0;i<add2cart.length;++i){
            add2cart[i].value("Добавить в корзину");
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
                var its = ba.parse();
                xG.checkout(its);
            }, false );
        }
        <!-- Currencies -->
        var pe = xG._getElement("#big_total");
        var priceElements = document.getElementsByClassName("total_command_right");
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
        priceElements = document.getElementsByClassName("price_unitaire");
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
        xG.currency.get(pe,"EUR");

        var addcart = document.getElementsByClassName( 'button_add_cart' );
        console.debug(addcart);
        if(addcart!=null&&typeof addcart!="undefined"){
            for(var i=0;i<addcart.length;++i){
                if(addcart[i]!=null)addcart[i].value="Добавить в корзину";
            }
        }
        XMLHttpRequest.prototype.send = (function(orig){
            return function(){
                if (!/MSIE/.test(navigator.userAgent)){
                    this.addEventListener("loadend", function(){
                        var addcart = document.getElementsByClassName( 'button_add_cart' );
                        console.debug(addcart);
                        if(addcart!=null&&typeof addcart!="undefined"){
                            for(var i=0;i<addcart.length;++i){
                                if(addcart[i]!=null)addcart[i].value="Добавить в корзину";
                            }
                        }
                    }, false);
                } else {
                    var xhr = this,
                    waiter = setInterval(function(){
                        if(xhr.readyState && xhr.readyState == 4){
                            //ctshirts_func();
                            clearInterval(waiter);
                        }
                    }, 50);
                }

                return orig.apply(this, arguments);
            }
        })(XMLHttpRequest.prototype.send);
    @elseif($site=="ctshirts")
        xG.hide(".header__user-link,.iconlink--phone,#js-coupon-code,.order-shipping,.item-list__total,.content__block--changecountry");
        var ctshirts_func = function(){
            var ma = document.querySelector("#navigation > div");
            if(ma!=null)ma.style.maxWidth = "132rem";
            //console.debug(ma);
            //for(var j=0;j<ma.length;++j){ma[j].style.maxWidth = "132rem";}
            var pe = xG._getElement(".item-total,#js-order-subtotal,.price,.item-list__was-price"),pes = document.getElementsByClassName('item-list__td--price');
            for(var i=0;i<pes.length;++i){
                var e = pes[i].getElementsByTagName("b");
                if(e!=null && e.length)pe.push(e[0]);
                else pe.push(pes[i]);
            }
            xG.currency.get(pe,"GBP");
            var checkouts = document.getElementsByClassName("form__checkout-btn");
            if(typeof checkouts != 'undefined' && checkouts != null){
                for(var i=0;i<checkouts.length;++i){
                    var checkout = checkouts[i];
                    if(checkout.classList.contains('xg_catched'))continue;
                    checkout.innerHTML = 'Оформить заказ';
                    checkout.classList.add('xg_catched');
                    //checkout.removeAttribute("type");
                    //console.debug(checkout);
                    checkout.addEventListener( 'click', function( e ){
                        e.preventDefault();
                        e.stopPropagation();
                        var its = [];
                        //parse
                        var rows = document.getElementById('cart-table').getElementsByTagName('tbody')[0].getElementsByClassName('cart-row');
                        for(var r=0; r<rows.length;++r){
                            //r=r*2;
                            var row = rows[r];
                            if(row==null)continue;
                            var cells = row.getElementsByTagName('td');
                            console.debug(cells[4].getElementsByTagName("div"));
                            var origprice =cells[4].getElementsByTagName("b")[0].innerHTML.replace(/[^\d\.]+/g,""),
                                price = (cells[4].getElementsByTagName("div").length)?cells[4].getElementsByTagName("div")[1].innerHTML.replace(/[^\d\.]+/g,""):cells[4].getElementsByTagName("b")[1].innerHTML.replace(/[^\d\.]+/g,""),
                                sale = cells[4].getElementsByTagName("b")[1].innerHTML.replace(/[^\d\.]+/g,"");
                            price = price.replace(/\.$/,"");
                            sale = sale.replace(/\.$/,"");
                            var p = {
                                shop:"ctshirts",
                                quantity:cells[3].getElementsByTagName("input")[1].value,
                                currency:'GBP',
                                original_price:origprice,
                                regular_price:price,
                                sale_price:sale,
                                title:cells[1].getElementsByTagName("div")[0].getElementsByTagName("div")[0].getElementsByTagName("a")[0].innerHTML.replace(/[`']/,''),
                            //  description:cells[1].getElementsByTagName("div")[2].getElementsByTagName("div")[1].getElementsByTagName("a")[0].innerHTML.replace(/[`']/,''),
                                product_img:cells[0].getElementsByTagName("a")[0].getElementsByTagName("img")[0].getAttribute("src").replace(/\?.+$/,""),
                                //product_img:"http://demandware.edgesuite.net/sits_pod28/dw/image/v2/AAWJ_PRD/on/demandware.static/-/Sites-ctshirts-master/default/dw197d168d/hi-res/FOB0186RYL_a.jpg",
                                product_url:"http:"+cells[0].getElementsByTagName("a")[0].getAttribute("href").replace(/\/\/.+?gauzymall\.com/,"//www.ctshirts.com"),
                                sku:"CTS"+cells[1].getElementsByTagName("div")[0].getElementsByTagName("div")[1].getElementsByTagName("span")[0].innerHTML.substr(0,10),
                                variations:{
                                    size:""
                                }
                            };
                            if(row.getElementsByClassName('attribute--value value js-beltSize')[0])
                            p.variations.size = row.getElementsByClassName('attribute--value value js-beltSize')[0].textContent.trim();

                            else if(row.getElementsByClassName('attribute--value value js-collarSize')[0]){
                                p.variations.size = "collar "+row.getElementsByClassName('attribute--value value js-collarSize')[0].textContent.trim();
                                p.variations.size += " sleeve "+ row.getElementsByClassName('attribute--value value js-sleeveLength')[0].textContent.trim();
                                p.variations.size += " cuff "+ row.getElementsByClassName('attribute--value value js-cuffType')[0].textContent.trim();
                            }

                            else if(row.getElementsByClassName('attribute--value value js-shoeSize')[0])
                            p.variations.size = row.getElementsByClassName('attribute--value value js-shoeSize')[0].textContent.trim();

                            else if(row.getElementsByClassName('attribute--value value js-simpleSize')[0])
                            p.variations.size = row.getElementsByClassName('attribute--value value js-simpleSize')[0].textContent.trim();

                            else if(row.getElementsByClassName('attribute--value value js-casualShirtSize')[0])
                            p.variations.size = row.getElementsByClassName('attribute--value value js-casualShirtSize')[0].textContent.trim();

                            else if(row.getElementsByClassName('attribute--value value js-jacketSize')[0]){
                                p.variations.size = row.getElementsByClassName('attribute--value value js-jacketSize')[0].textContent.trim();
                                if(row.getElementsByClassName('attribute--value value js-jacketLength')[0]){
                                    p.variations.size += '/'+row.getElementsByClassName('attribute--value value js-jacketLength')[0].textContent.trim();
                                }
                            }

                            else if(row.getElementsByClassName('attribute--value value js-trouserWaist')[0]){
                                p.variations.size = row.getElementsByClassName('attribute--value value js-trouserWaist')[0].textContent.trim();
                                if(row.getElementsByClassName('attribute--value value js-trouserLength')[0]){
                                    p.variations.size += '/'+row.getElementsByClassName('attribute--value value js-trouserLength')[0].textContent.trim();
                                }
                            }
                            its.push(p);
                        }
                        console.debug(its);
                        xG.checkout(its);
                        return false;
                    }, false );
                }
            }

        };
        window.ctshirts_func = ctshirts_func;
        ctshirts_func();

        XMLHttpRequest.prototype.send = (function(orig){
            return function(){
                if (!/MSIE/.test(navigator.userAgent)){
                    this.addEventListener("loadend", function(){
                        ctshirts_func();
                    }, false);
                } else {
                    var xhr = this,
                    waiter = setInterval(function(){
                        if(xhr.readyState && xhr.readyState == 4){
                            //ctshirts_func();
                            clearInterval(waiter);
                        }
                    }, 50);
                }

                return orig.apply(this, arguments);
            }
        })(XMLHttpRequest.prototype.send);
    @endif


</script>

<!-- /Yandex.Metrika counter -->
