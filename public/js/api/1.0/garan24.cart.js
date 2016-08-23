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
    cart:{
        var t = this;
        //carthost:"//service.garan24.ru/cart";
        carthost:(document.location.hostname.match(/\.bs2/i))?"http://service.garan24.bs2/cart":"https://service.garan24.ru/cart",
        id:$g.cookie.get("cart_id"),
        currencyRate:72*1.1, //10%
        cartQuantity:0,
        cartAmount:0,
        x_secret:"cs_ddde7647b888f21548ca27c6b80a973b20cc6091",
        x_key:"ck_d80d9961dfe1d5d9dcee803a6d8d674e265c9220",
        version:"1.0",
        response_url:garan.cart.carthost+"/clean?id="+this.id,
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
            console.debug(good);
            garan.cart.cartQuantity+=good.quantity;
            garan.cart.cartAmount+=good.regular_price*good.quantity;
            garan.cart.order.order_total=this.cartAmount;
            this.order.items.push(good);
            this.setCartDigits();
            this.set();
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
            this.setCartDigits();
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
                    G.id=d.id;
                    $g.cookie.set("cart_id",d.id,{expires:1,domain:'.gauzy.bs2'});
                    $g.cookie.set("cart_id",d.id,{expires:1,domain:'.xray.garan24.ru'});
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
                        t.order=$.extend(G.order,d.order);
                        for(var i in t.order.items){
                            var item = t.order.items[i];
                            //console.debug(item);
                            t.cartQuantity+=((typeof item.quantity != "undefined")&&!isNaN(item.quantity))?item.quantity:0;
                        }
                    }
                    t.cartAmount = t.order.order_total;
                    t.setCartDigits();
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
            var $c = $("#garan-cart-full"),g="";
            if($c.hasClass("garan24-visible")){
                $c.removeClass("garan24-visible").slideUp();
                return;
            }
            g+="<table>";
            for(var i in this.order.items){
                g+="<tr>";
                var itm = this.order.items[i];
                var vars = "";
                for(var v in itm.variations){
                    vars+=v+" "+itm.variations[v];
                }
                g+="<td width='20%'><img alt='"+itm.title+"' src='"+itm.product_img+"'/></td>";
                g+="<td width='5%' style='text-align:left;'><span class='small'>х"+itm.quantity+"</span></td>";
                g+="<td width='5%'><a href='javascript:G.remove("+i+")'><i class='fa fa-trash-o'></i></a></td>";
                g+="<td width='50%' style='text-align:left;'>"+itm.title+" <span class='small'>"+vars+"</span></td>";
                g+="<td width='20%' style='text-align:right;'><span class='currency-amount'>"+itm.regular_price.format(0,3,' ','.')+" руб.</span></td>";
                g+="</tr>";
            }
            g+="<tr class='total'><td>Итого:</td><td colspan='4'>"+this.order.order_total.format(0,3,' ','.')+" руб.</td></tr>";
            g+="</table>";

            $c.addClass("garan24-visible").html(g).slideDown();
        },
        init:function(){
            console.debug("Init cart - "+this.id);
            if(typeof garan.cart.id!="undefined" && this.id.length ){
                this.get();
                console.debug("Getting snooper data cart");
            }
            else {
                this.create();
                console.debug("Creating snooper cart");
            }
            $("body").animate({
                    paddingTop:"56px"
                },
                800,
                function() {
                    $("#garan24-toper").slideDown();
                }
            );
            $("#garan-checkout").click(function(){G.checkout();});
            $("#garan-cart").click(function(){G.showcart();});
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
