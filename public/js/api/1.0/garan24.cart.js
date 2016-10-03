$.extend(window.garan,{
    currency:{
        multiplier:1.05,
        EUR:70.88,
        USD:63.39,
        GBP:82.20,
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
        cartQuantity:0,
        cartAmount:0,
        version:"1.0",
        response_url:"",//garan.cart.carthost+"/clean?id="+this.id,
        inited:false,
        order:{
            order_id:this.id,
            order_url:document.location.href,
            order_total:0,
            order_currency:"RUB",
            items:[]
        },
        add2cart:function(){
            if(!arguments.length){console.debug("nodata to add");return false;}
            var good = arguments[0];
            var cur = (arguments.length>1)?arguments[1]:"EUR";
            console.debug("Garan24::add2cart(");
            console.debug(good);
            console.debug(")");
            good.original_price = good.original_price.replace(/[\,]/,'.').replace(/^\D+/,"").replace(/\D+$/,"");
            good.regular_price = good.original_price*garan.currency.rates(cur);
            good.quantity=parseInt(good.quantity);
            console.debug(good);
            //if(typeof good.sku!="undefined")good.sku=good.shop+'#'+good.sku;
            good.description+=(typeof good.shop != "undefined")?good.shop+" | "+good.description:+"| "+good.description;
            if(typeof good.product_id == "undefined"){
                if((typeof good.shop != "undefined")&&(typeof good.sku != "undefined")){
                    good.product_id = good.shop+"_"+good.sku;
                }
                else good.product_id = -1;
            }
            if(typeof good.variations != "undefined"){
                good.description+=' | Размер: '+(typeof good.variations.size != "undefined")?good.variations.size:"не указан";
                good.description+=' | Цвет: '+(typeof good.variations.color != "undefined")?good.variations.color:"не указан";
            }
            good.description+=(typeof good.comments!="undefined")?' | comments:'+good.comments:"";
            if(!this.alreadyitem(good)){
                garan.cart.cartQuantity=parseInt(garan.cart.cartQuantity)+parseInt(good.quantity);
                garan.cart.cartAmount+=good.regular_price*good.quantity;
                garan.cart.order.order_total=this.cartAmount;
                this.order.items.push(good);
            }
            this.setCartDigits();
            this.showcart();
            this.set();
        },
        alreadyitem:function(good){
            return false;
            for(var i in this.order.items){
                var it = this.order.items[i];
                if(it.sku==good.sku&&it.title==good.title) {
                    it.quantity=parseInt(it.quantity)+parseInt(good.quantity);
                    return true;
                }
            }
            return false;
        },
        editItem:function(){
            console.debug("Garan24::edit cart item(..)");
            if(!arguments.length){console.debug("nodata to add");return false;}
            var i = arguments[0],good = this.order.items[i];
            console.debug(good);
            if(typeof decollectData !="undefined"){
                decollectData(good,i);
            }
        },
        saveItem:function(){
            var i = arguments[0];
            var good = arguments[1];
            garan.cart.remove(i);
            garan.cart.add2cart(good);
        },
        remove:function(){
            console.debug("Garan24::remove from cart(..)");
            if(!arguments.length){console.debug("nodata to add");return false;}
            var i = arguments[0],good = this.order.items[i];
            var needconfirm = (arguments.length>1)?false:true;
            console.debug(good);
            if(!needconfirm||confirm('Вы уверены, что хотите удалить Ваш товар из мультикорзины?')){
                garan.cart.cartQuantity-=good.quantity;
                garan.cart.cartAmount-=good.regular_price*good.quantity;
                garan.cart.order.order_total=this.cartAmount;
                this.order.items.splice(i,1);
                this.showcart();
                this.set();
            }
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
                    garan.cookie.set("cart_id",d.id,{expires:1,domain:'.xray.bs2'});
                    garan.cookie.set("cart_id",d.id,{expires:1,domain:'.garan24.ru'});
                    garan.cookie.set("cart_id",d.id,{expires:1,domain:'.gauzymall.com'});
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
                    var d=JSON.parse(data),tot=0;
                    //var d=data;
                    console.debug(d);
                    if(typeof d.order != "undefined"){
                        garan.cart.order=$.extend(garan.cart.order,d.order);
                        for(var i in garan.cart.order.items){
                            var item = garan.cart.order.items[i];
                            item.quantity=(isNaN(item.quantity))?item.quantity.replace(/.*(\d+).*/,"$1"):item.quantity;
                            //console.debug(item);
                            garan.cart.cartQuantity+=((typeof item.quantity != "undefined")&&!isNaN(item.quantity))?parseInt(item.quantity):0;
                            tot+=item.regular_price;
                        }
                    }
                    t.order.order_total = tot;
                    t.cartAmount = t.order.order_total;
                    t.setCartDigits();
                    t.showcart();
                },
                error:function(){

                    garan.cart.create();
                }
            });
        },
        checkout:function(){
            garan.cart.order.order_id = garan.cart.id;
            var rq = {
                //x_secret: "cs_ddde7647b888f21548ca27c6b80a973b20cc6091",
                //x_key: "ck_d80d9961dfe1d5d9dcee803a6d8d674e265c9220",
                //x_secret: "cs_b594c5ce8216f5295218800cb51dff474c870f3f",
                //x_key: "ck_9563c1d74c086f1ec72499f8b2ccf4963ac2d444",
                /* GauzyMALL -2 */
                //x_secret: "cs_a9b8f4b535f845f82509c1cfa6bea5d094219dce",
                //x_key: "ck_653d001502fc0b8e1b5e562582f678ce7b966b85",
                /*XRAY shopping*/
                //x_secret: "cs_ae2ab1d5fa2c7a1135907df7a4e0d355e3e2b713",
                //x_key:"ck_6407eb8bd1a6e118e509ce1e7b9d1f3740bda1db",
                /* test */
                //x_key:"ck_388a0b6c5cc1f391d6fab43b87b1a344ec2c7384",
                //x_secret:"cs_be6251768285569537f9f26dceb455d30802d51f",
                domain_id:10,
                version: "1.0",
                response_url: garan.cart.carthost+"/clean?id="+this.id,
                order:garan.cart.order
            },$m = $("#garan24-overlay");
            for(var i in garan.cart.order.items) {
                var itm = garan.cart.order.items[i];
                delete itm.variations;
                delete itm.currency;
                delete itm.shop;
                rq.order.items[i] = itm;
                if(typeof itm.product_id == "undefined"){
                    if((typeof itm.shop != "undefined")&&(typeof itm.sku != "undefined")){
                        itm.product_id = itm.shop+"_"+itm.sku;
                    }
                    else itm.product_id = -1;
                }
                console.debug(itm);
            }

            //return ;
            $.ajax({
                type:"POST",
                //url:"//service.garan24.ru/checkout/",
                //url:"http://service.garan24.bs2/checkout/",
                url:(document.location.hostname.match(/\.bs2/i))?"//service.garan24.bs2/checkout":"https://service.garan24.ru/checkout",
                dataType: "json",
                data:JSON.stringify(rq),
                beforeSend:function(){
                    $m.find(".garan24-overlay-message-text").html("Обрабатываются товары из Вашей корзины...");
                    $m.fadeIn();
                },
                complete:function(){
                    $m.delay(4).fadeOut();
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
            console.debug("show cart");
            var $c = $(".garan.cart"),g="",tot=0;
            g+='<h3><i class="first">Мультикорзина</i></h3>';
            if(garan.cart.order.items.length==0){
                g+="<div class=\"row cart-item\">";
                g+='<div class="message">Ваша корзина еще пуста.</div>';
                g+='</div>';
            }
            for(var i in garan.cart.order.items){
                var itm = garan.cart.order.items[i];
                if(!itm.title.length) itm.title = itm.product_url;
                g+="<div class=\"row cart-item\" id=\"cartItem-"+itm.product_id+"\" data-ref=\""+itm.product_url+"\">";

                /*
                g+='<div class="image col-xs-4 col-sm-4 col-md-4 col-lg-4">';
                g+='    <img height="100px" src="'+itm.product_img+'" alt="'+itm.title+'">';
                g+='</div>';
                */
                g+='<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">';
                g+='  <div class="row" style="font-weight:700;">'+itm.title+'</div>';
                g+='  <div class="row" style="margin-top:4px;">';
                if(typeof itm.variations != "undefined"){
                    if(typeof itm.variations["color"]!="undefined"&&itm.variations["color"].length){
                        g+='    <div class="color col-xs-4 col-sm-4 col-md-4 col-lg-4">'
                        g+=         '<b>Цвет</b>: '+itm.variations["color"];
                        g+='    </div>';
                    }
                    if(typeof itm.variations["size"]!="undefined"&&itm.variations["size"].length){
                        g+='    <div class="size col-xs-4 col-sm-4 col-md-4 col-lg-4">'
                        g+=         '<b>Размер</b>: '+itm.variations["size"];
                        g+='    </div>';
                    }
                }
                g+='  </div>';
                if(typeof itm.shop!="undefined"){
                    g+='<div class="row shop" style="font-style: italic;">';
                    //g+='<div class="shop col-xs-6 col-sm-6 col-md-6 col-lg-6">'
                    g+= 'Магазин:' +itm.shop;
                    //g+='</div>';
                    g+='</div>';
                }
                g+='</div>';
                g+='<div class="edit col-xs-2 col-sm-2 col-md-2 col-lg-2">'
                g+='    <a href="javascript:garan.cart.editItem('+i+')"><i class="fa fa-pencil"></i> Изменить</a>'
                g+='</div>';

                if(itm.regular_price>0)g+='<div class="quantity col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center">'+itm.quantity+'<sup>x</sup></div>';
                g+='<div class="amount col-xs-2 col-sm-2 col-md-2 col-lg-2">';
                if(itm.regular_price>0)g+=garan.number.format(itm.regular_price*itm.quantity,2,3,' ','.')+' руб.';
                g+='<a href="javascript:garan.cart.remove('+i+')" style="color:red;">&nbsp;<i class="fa fa-remove"></i></a>';
                g+='</div>';

                g+='</div>';
                tot+=itm.regular_price*itm.quantity;
            }
            g+="</div>";
            if(garan.cart.order.items.length>0){
                g+='<div class="row cart-item" id="cart-total">';
                g+='<div class="total col-xs-8 col-sm-8 col-md-8 col-lg-8">Сумма заказа:</div>';
                g+='<div class="amount cart-total-amount total-amount col-xs-4 col-sm-4 col-md-4 col-lg-4" id="cart-total-price">'+garan.number.format(tot,2,3,' ','.')+' руб.</div>';
                g+='</div>';
            }
            garan.cart.order.order_total = tot;
            $c.html(g);
            if(garan.cart.order.items.length){
                $("#forward").show();
                $("#forward").removeAttr("disabled");
            }
        },
        setCartDigits:function(){
            if(!$("#garan24-cart-quantity").length){
                $("#garan-cart").html('<i class="fa fa-shopping-cart" area-hidden="true"></i><sup id="garan24-cart-quantity">0</sup><span id="garan24-cart-amount">0 руб.</span>');
            }
            if(!isNaN(this.cartQuantity))$("#garan24-cart-quantity").html(this.cartQuantity);
            if(this.order.order_total!=null&&!isNaN(this.order.order_total))$("#garan24-cart-amount").html(this.order.order_total.format(0,3,' ','.')+" руб.");
        },
        init:function(){
            if(this.inited)return;
            this.id = garan.cookie.get("cart_id");
            console.debug("Init cart - "+this.id);
            if(typeof garan.cart.id!="undefined" && this.id.length ){
                this.get();
            }
            else {
                this.create();
            }
            this.setCartDigits();
            this.inited=true;
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
