<script>
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
                var price_spans = row.querySelectorAll(".price_unitaire span");
                console.debug(price_spans);
                var origprice =(price_spans.length>10)?price_spans[10].innerHTML:price_spans[3].innerHTML
                var price =(price_spans.length>1)?price_spans[1].innerHTML:price_spans[1].innerHTML;
                var sale =(price_spans.length>2)?price_spans[2].innerHTML:price_spans[1].innerHTML;
                origprice = origprice.replace(/[^\d\.,]/ig,"").replace(/,/ig,".").replace(/\.$/,"");
                price = price.replace(/[^\d\.,]/ig,"").replace(/,/ig,".").replace(/\.$/,"");
                sale = sale.replace(/[^\d\.,]/ig,"").replace(/,/ig,".").replace(/\.$/,"");
                var p = {
                    shop:"brandalley",
                    quantity:row.querySelector("#item_quantity").value,
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
xG.hide(".code_promo_form,.bon_achat,.wishlist_part,#account-user-group,#sticky_footer,.charity,.accroche,.lire_suite,#_EAPM");
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
        yaCounter.reachGoal( 'PLACE-ORDER' );
        console.log( 'Reached goal: PLACE-ORDER' );
        try{
            xG.checkout(ba.parse());
        }
        catch(e){
            xG.ajax({
                url:"https://l.gauzymall.com/error",
                type:"post",
                data:JSON().stringify({
                    site:"brandalley",
                    url:document.location.host,
                    error:e
                })
            });
        }
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

var brandalley_func = function() {
    var pe = document.querySelectorAll("#price,.price_total,.price_unitaire,.block_price,.total_command_right,.group_price_article");
    //console.debug(pe);
    xG.currency.get(pe,"EUR",/(\d+[\.,]\d+)[\s\r\n]*&nbsp;€/gmu);
    xG.hide(".modal_add_shipping");
    var addcart = document.querySelectorAll( '.button_add_cart:not(.xg_countered)' );
    if ( addcart != null && typeof addcart != "undefined" ) {
        for ( var i=0; i<addcart.length; ++i ) {
            if ( addcart[i] != null ) {
                addcart[i].value="Добавить в корзину";
                addcart[i].addEventListener( 'click', function( event ) {
                    console.debug('Added to cart');
                    yaCounter.reachGoal( 'ADD-TO-CART' );
                    console.log( 'Reached goal: ADD-TO-CART' );
                }, false );
                addcart[i].classList.add('xg_countered');
            }

        }

    }


}
brandalley_func();

XMLHttpRequest.prototype.send = (function(orig){
    return function(){
        this.addEventListener("loadend", function(){
            //console.debug(this);
            if(this.responseURL.match(/addonetocart/)){
                if(yaCounter!=null&&typeof(yaCounter)!="undefined"){
                    yaCounter.reachGoal( 'ADD-TO-CART' );
                    console.log( 'Reached goal: ADD-TO-CART' );
                }
            }
            brandalley_func();
        }, false);
        return orig.apply(this, arguments);
    }
})(XMLHttpRequest.prototype.send);
</script>
