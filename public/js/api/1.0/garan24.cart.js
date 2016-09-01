$.extend(window.garan,{
    cookie:{
        get:function(){
            if(arguments.length<=0)return "";
            var n = arguments[0],
                d = (arguments.length>1)?arguments[1]:"",
                v = decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(n).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || d;
            return v;
        },
        set:function(){
            if(arguments.length<=0)return "";
            var n = arguments[0],
                v = (arguments.length>1)?arguments[1]:"",
                o = (arguments.length>2)?arguments[2]:"",
                e = new Date();
            e.setDate(e.getDate()+(typeof o.expires!="undefined")?e.expires:9999);
            document.cookie = encodeURIComponent(n) + "=" + encodeURIComponent(v)
                + "; expires=" + e.toUTCString()
                + (typeof o.domain !="undefined" ? "; domain=" + o.domain : "")
                + (typeof o.path !="undefined" ? "; path=" + o.path : "")
                + (typeof o.secure !="undefined" ? "; secure" : "");
            return true;
        }
    },
    number:{
        format:function(t,n, x, s, c) {
            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                num = parseFloat(t).toFixed(Math.max(0, ~~n));

            return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
        }
    },
    currency:{
        multiplier:1.1,
        EUR:73,
        USD:65,
        GBP:110,
        rates:function(){
            var cur = arguments.length?arguments[0]:false;
            if(!cur) cur = 'EUR';
            return garan.currency.multiplier*garan.currency[cur];
        }
    },
    cart:{
        //carthost:"//service.garan24.ru/cart";
        carthost:(document.location.hostname.match(/\.bs2/i))?"http://service.garan24.bs2/cart":"https://service.garan24.ru/cart",
        id:0,
        currencyRate:72*1.1, //10%
        cartQuantity:0,
        cartAmount:0,
        x_secret:"cs_ddde7647b888f21548ca27c6b80a973b20cc6091",
        x_key:"ck_d80d9961dfe1d5d9dcee803a6d8d674e265c9220",
        version:"1.0",
        response_url:"",//garan.cart.carthost+"/clean?id="+this.id,
        order:{
            order_id:this.id,
            order_url:document.location.href,
            order_total:0,
            order_currency:"RUB",
            items:[]
        },
        add2cart:function(){
            console.debug("Garan24::add2cart(..)");
            if(!arguments.length){console.debug("nodata to add");return false;}
            var good = arguments[0];
            var cur = (arguments.length>1)?arguments[1]:"EUR";
            console.debug(good);
            //if(typeof good.sku!="undefined")good.sku="xrayshopping.babywalz."+good.sku;
            if(!this.alreadyitem(good)){
                good.regular_price*=garan.currency.rates(cur);
                garan.cart.cartQuantity=parseInt(garan.cart.cartQuantity)+parseInt(good.quantity);
                garan.cart.cartAmount+=good.regular_price*good.quantity;
                garan.cart.order.order_total=this.cartAmount;
                this.order.items.push(good);
            }
            this.showcart();
            this.set();
        },
        alreadyitem:function(good){
            for(var i in this.order.items){
                var it = this.order.items[i];
                if(it.sku==good.sku&&it.title==good.title) {
                    it.quantity=parseInt(it.quantity)+parseInt(good.quantity);
                    return true;
                }
            }
            return false;
        },
        remove:function(){
            console.debug("Garan24::remove from cart(..)");
            if(!arguments.length){console.debug("nodata to add");return false;}
            var i = arguments[0],good = this.order.items[i];
            console.debug(good);
            garan.cart.cartQuantity-=good.quantity;
            garan.cart.cartAmount-=good.regular_price*good.quantity;
            garan.cart.order.order_total=this.cartAmount;
            this.order.items.splice(i,1);
            this.showcart();
            this.set();
        },
        setCartDigits:function(){
            if(!$("#garan24-cart-quantity").length){
                $("#garan-cart").html('<i class="fa fa-shopping-cart" area-hidden="true"></i><sup id="garan24-cart-quantity">0</sup><span id="garan24-cart-amount">0 руб.</span><div id="garan-cart-full"></div>');
            }
            if(!isNaN(this.cartQuantity))$("#garan24-cart-quantity").html(this.cartQuantity);
            if(!isNaN(this.order.order_total))$("#garan24-cart-amount").html(this.order.order_total.format(0,3,' ','.')+" руб.");
        },
        create:function(){
            $.ajax({
                url:this.carthost+"/create",
                type:"get",
                dataType: "json",
                crossDomain: true,
                success:function(data){
                    //var d=JSON.parse(data);
                    var d=data;
                    console.debug("Created cart.");
                    console.debug(d);
                    garan.cart.id=d.id;
                    garan.cookie.set("cart_id",d.id,{expires:1,domain:'.bs2'});
                    garan.cookie.set("cart_id",d.id,{expires:1,domain:'.gauzy.bs2'});
                    garan.cookie.set("cart_id",d.id,{expires:1,domain:'.garan24.ru'});
                    garan.cookie.set("cart_id",d.id,{expires:1,domain:'.garan24.com'});
                    garan.cookie.set("cart_id",d.id,{expires:1,domain:'.garan24.bs2'});
                }
            });
        },
        set:function(){
            var rq = {
                x_secret: "cs_ddde7647b888f21548ca27c6b80a973b20cc6091",
                x_key: "ck_d80d9961dfe1d5d9dcee803a6d8d674e265c9220",
                version: "1.0",
                response_url: "//"+document.location.hostname+"/response.php?id="+this.id,
                order:this.order
            };
            console.debug(this.order);
            //return ;
            $.ajax({
                url:this.carthost+"/update",
                type:"get",
                dataType: "json",
                crossDomain: true,
                data:{id:this.id,value:JSON.stringify(rq)},
                success:function(){console.debug("cart updated");}
            });
        },
        get:function(){
            var t = this;
            $.ajax({
                url:this.carthost,
                data:{id:this.id},
                type:"get",
                dataType: "json",
                crossDomain: true,
                //jsonp:false,
                beforeSend:function(x){
                    console.debug("Getting data");
                    //console.debug(x);
                },
                success:function(data){
                    var d=JSON.parse(data);
                    //var d=data;
                    console.debug(d.order);
                    if(typeof d.order != "undefined"){
                        t.order=$.extend(t.order,d.order);
                        for(var i in garan.cart.order.items){
                            var item = t.order.items[i];
                            //console.debug(item);
                            garan.cart.cartQuantity+=((typeof item.quantity != "undefined")&&!isNaN(item.quantity))?item.quantity:0;
                        }
                    }
                    t.cartAmount = t.order.order_total;
                    t.showcart();
                }
            });
        },
        checkout:function(){
            var rq = {
                x_secret: "cs_ddde7647b888f21548ca27c6b80a973b20cc6091",
                x_key: "ck_d80d9961dfe1d5d9dcee803a6d8d674e265c9220",
                version: "1.0",
                response_url: garan.cart.carthost+"/clean?id="+this.id,
                order:this.order
            },$m = $("#garan24-overlay");
            console.debug(this.order);
            //return ;
            $.ajax({
                type:"POST",
                //url:"//service.garan24.ru/checkout/",
                //url:"http://service.garan24.bs2/checkout/",
                url:"https://service.garan24.ru/checkout",
                dataType: "json",
                data:JSON.stringify(rq),
                beforeSend:function(){
                    $m.find(".garan24-overlay-message-text").html("Обрабатываются товары из Вашей корзины...");
                    $m.fadeIn();
                },
                complete:function(){
                    $m.fadeOut();
                },
                success:function(data){
                    //var d=JSON.parse(data);
                    var d=data;
                    console.debug("checkout response ");
                    console.debug(d);
                    if(!d.error){
                        $m.find(".garan24-overlay-message-text").html("Переход на страницу оформления заказа...");
                        document.location.href = d.redirect_url;
                    }
                },
                error:function(x,s){
                    $m.find(".garan24-overlay-message-text").html("Неудалось обработать корзину ["+s+"]");
                }
            });
        },
        showcart:function(){
            /*
            <h2><i class="first">Корзина</i></h2>
            {{--
            @foreach($deal->order->getProducts() as $good)
            <div class="row cart-item" id="cartItem-'+itm.product_id+'" data-ref="'+itm.product_url+'">
                <div class="image col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <img src="'+itm.product_img+'" alt="'+itm.title+'">
                </div>
                <div class="name col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <div class="row">'+itm.title+'</div>
                    <div class="row">
                        <div class="quantity col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            '+itm.quantity+' шт.
                        </div>
                        <div class="amount col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            @amount($good["regular_price"])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            --}}
            <div class="row cart-item" id="cart-total">
                <div class="total col-xs-8 col-sm-8 col-md-8 col-lg-8">Сумма заказа:</div>
                <div class="amount cart-total-amount total-amount col-xs-4 col-sm-4 col-md-4 col-lg-4" id="cart-total-price"></div>
            </div>
            */
            var $c = $(".cart"),g="",tot=0;
            g+='<h2><i class="first">Корзина</i></h2>';
            for(var i in this.order.items){
                var itm = this.order.items[i];
                g+="<div class=\"row cart-item\" id=\"cartItem-"+itm.product_id+"\" data-ref=\""+itm.product_url+"\">";
                var vars = "";
                for(var v in itm.variations){
                    vars+=v+" "+itm.variations[v];
                }
                g+='<div class="image col-xs-4 col-sm-4 col-md-4 col-lg-4">';
                g+='<img height="100px" src="'+itm.product_img+'" alt="'+itm.title+'">';
                g+='</div><div class="name col-xs-2 col-sm-2 col-md-2 col-lg-2">';
                g+='<a href="javascript:garan.cart.remove('+i+')"><i class="fa fa-trash-o"></i></a>';
                g+='</div><div class="name col-xs-6 col-sm-6 col-md-6 col-lg-6">';
                g+='<div class="row">'+itm.title+'</div><div class="row"><div class="quantity col-xs-6 col-sm-6 col-md-6 col-lg-6">';
                g+=itm.quantity+' шт.</div><div class="amount col-xs-6 col-sm-6 col-md-6 col-lg-6">';
                g+=garan.number.format(itm.regular_price*itm.quantity,2,3,' ','.')+' руб.';
                g+='</div></div></div></div>';
                tot+=itm.regular_price*itm.quantity;
            }
            g+="</div>";
            g+='<div class="row cart-item" id="cart-total">';
            g+='<div class="total col-xs-8 col-sm-8 col-md-8 col-lg-8">Сумма заказа:</div>';
            g+='<div class="amount cart-total-amount total-amount col-xs-4 col-sm-4 col-md-4 col-lg-4" id="cart-total-price">'+garan.number.format(tot,2,3,' ','.')+' руб.</div>';
            g+='</div>';
            this.order.order_total = tot;
            $c.html(g);
            if(this.order.items.length){
                $("#forward").show();
                $("#forward").removeAttr("disabled");
            }
        },
        init:function(){
            this.id = garan.cookie.get("cart_id");
            console.debug("Init cart - "+this.id);
            if(typeof garan.cart.id!="undefined" && this.id.length ){
                this.get();
                console.debug("Getting snooper data cart");
            }
            else {
                this.create();
                console.debug("Creating snooper cart");
            }
            this.setCartDigits();
            console.debug("cart loaded!");
        }
    }
});

/*
var p = {
    product_id:-1,
    quantity:qty,
    regular_price:amt,
    title: $(".product-name").text(),
    description: $("[itemprop=productID]:first").text().replace(/[\n\r\s]{0,}/g,""),
    product_url:document.location.href,
    product_img:$(".slick-current.slick-active a.main-image").attr("href"),
    weight:"200",
    dimensions:{
        "height":"100",
        "width":"10",
        "depth":"40"
    },
    variations:varis
}
*/
