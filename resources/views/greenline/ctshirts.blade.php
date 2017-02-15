<script>

var ctshirts_func = function(){
    xG.hide("#browser-check,.header__user-link,.iconlink--phone,#js-coupon-code,.order-shipping,.item-list__total,.content__block--changecountry");
    var addtocart = document.getElementById( 'add-to-cart' );
    if ( addtocart != null ) {
            if(!xG.hasClass(addtocart,'xg_countered')){
            addtocart.addEventListener( 'click', function( event ) {

                console.debug('Added to cart');

                yaCounter.reachGoal( 'ADD-TO-CART' );

                console.log( 'Reached goal: ADD-TO-CART' );

            }, false );
            addtocart.classList.add('xg_countered');
        }
    }
    var ma = document.querySelector("#navigation > div");if(ma!=null)ma.style.maxWidth = "132rem";

    // Currency rates
    xG.currency.get(document.querySelectorAll(".item-list__addgift > b,#js-cart-youve-saved-area > b,.discount,.item-total,#js-order-subtotal,.price,.item-list__was-price,.minicart__item-total-price,.minicart__totals-value,.tile__pricing--listing,.promotional-message,.ct-m-slot__title,.item-list__td--price"),"GBP");
    //no shipping
    var shipping = document.querySelector("#cart-items-form > div.js-order-totals-section.panel--flexed.item-list__header--footer-helper > table");
    if(shipping!=null)shipping.style.display = 'none';

    //var checkouts = document.querySelectorAll(".form__checkout-btn");
    var checkouts = document.querySelectorAll(".item-list__checkout-btn");
    //var checkouts = document.querySelectorAll(".js-cart-action-checkout");
    if(typeof checkouts != 'undefined' && checkouts != null){
        for(var i=0;i<checkouts.length;++i){
            var checkoutOrig = checkouts[i],
                checkout = checkoutOrig.cloneNode();
            //if(xG.hasClass(checkoutOrig,"xr_g_checkout_catched"))continue;
            checkoutOrig.parentNode.replaceChild(checkout,checkoutOrig);

            //checkout.setAttribute("href","javascript:{0}");
            //checkout.setAttribute("style","display:block;width:20em;float:right;height:3em;line-height:3em;font-size:1.5em;text-align:center;padding:0 1.5em;background-color:#00bf80;color:#fff;text-decoration:none;");
            checkout.innerHTML = 'Оформить заказ >>';
            checkout.removeAttribute("type");
            checkout.classList.remove("item-list__checkout-btn");
            //checkout.classList.add("xr_g_checkout_catched");

            checkout.addEventListener( 'click', function( e ){
                e.preventDefault();
                e.stopPropagation();
                var its = [];
                //parse
                //var rows = document.querySelectorAll('#cart-table .cart-row');
                var rows = document.querySelectorAll('#cart-table .cart-row');
                for(var r=0; r<rows.length;++r){
                    //r=r*2;
                    var row = rows[r];
                    if(row==null)continue;
                    var origprice = row.querySelector(".item-price.xg_original_converted .item-list__was-price.xg_original_converted"),
                        price = row.querySelector(".item-price.xg_converted .item-list__was-price.xg_converted"),
                        sale = row.querySelector(".item-price.xg_converted > b");
                    if(origprice==null){
                        origprice = row.querySelector(".item-price.xg_original_converted > b");
                        price = row.querySelector(".item-price.xg_converted > b");
                        sale = price;
                    }
                    if(origprice==null)continue;
                    origprice = origprice.innerHTML.replace(/[^\d\.]+/g,"").replace(/\.$/,"");
                    price = price.innerHTML.replace(/[^\d\.]+/g,"").replace(/\.$/,"");
                    sale = sale.innerHTML.replace(/[^\d\.]+/g,"").replace(/\.$/,"");
                    var p = {
                        shop:"ctshirts",
                        quantity:row.querySelector(".item-quantity > input[type='text'].js-qty").value,
                        currency:'GBP',
                        original_price:origprice,
                        regular_price:price,
                        sale_price:sale,
                        title:row.querySelector(".item-details > div.product-list-item > div.name a").innerHTML.replace(/[`']/,''),
                        product_img:row.querySelector(".item-image a img").getAttribute("src").replace(/\?.+$/,""),
                        product_url:"http:"+row.querySelector(".item-image a").getAttribute("href").replace(/\/\/.+?gauzymall\.com/,"//www.ctshirts.com"),
                        sku:"CTS"+row.querySelector(".item-details > div.product-list-item > .sku > .value").innerHTML.substr(0,10),
                        variations:{
                            size:"",
                            adds:[]
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
                    var adds = row.nextSibling;
                    while(adds!=null){
                        if(xG.hasClass(adds,'cart-row'))break;
                        if(adds.nodeType==1&&xG.hasClass(adds,'item-list__row')&&adds.style.display!="none"){
                            console.debug("adds found");
                            var pa = {
                                value:encodeURIComponent(adds.querySelector(".item-list__td--details").innerHTML.trim()),
                                price:adds.querySelector(".item-price.xg_converted").innerHTML.replace(/[^\d\.]+/g,"").replace(/\.$/,""),
                                original_price:adds.querySelector(".item-price.xg_original_converted").innerHTML.replace(/[^\d\.]+/g,"").replace(/\.$/,"")
                            };
                            console.debug(pa);
                            p.variations.adds.push(pa);
                        }
                        adds = adds.nextSibling;
                    }
                    its.push(p);
                }
                console.debug(its);
                xG.checkout(its);
                yaCounter.reachGoal( 'PLACE-ORDER' );
                console.log( 'Reached goal: PLACE-ORDER' );
                return false;
            }, false );
            console.debug(checkout);
        }
    }
};
window.ctshirts_func = ctshirts_func;
ctshirts_func();
XMLHttpRequest.prototype.send = (function(orig){
    return function(){
        this.addEventListener("loadend", function(){
            ctshirts_func();
        }, false);
        return orig.apply(this, arguments);
    }
})(XMLHttpRequest.prototype.send);

</script>
