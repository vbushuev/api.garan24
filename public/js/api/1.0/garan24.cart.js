jQuery.noConflict();
(function($) {
    $.extend(window.garan,{
        cart:{
            //carthost:"//service.garan24.ru/cart";
            isframe:false,
            carthost:(document.location.hostname.match(/\.bs2/i))?"http://service.garan24.bs2/cart":"http://l.gauzymall.com/cart",
            id:0,
            cartQuantity:0,
            cartAmount:0.0,
            version:"1.0",
            response_url:"",//garan.cart.carthost+"/clean?id="+this.id,
            inited:false,
            order:{
                order_id:this.id,
                order_url:document.location.href,
                order_total:0.0,
                order_currency:"RUB",
                items:[]
            },
            add2cart:function(){
                if(!arguments.length){console.debug("nodata to add");return false;}
                /*while(!garan.cart.inited){
                    setTimeout(function(){
                        console.debug("wait for cart inittiated ...");
                    }, 600);
                }*/
                var goods = arguments[0];
                $(document).trigger('gcart:add2cart',goods);
                if(!Array.isArray(goods)){
                    var arr = [];
                    arr.push(goods);
                    goods = arr;
                }
                for(var i=0;i<goods.length;++i){
                    var good = goods[i];
                    var cur = (typeof good.currency!="undefiend")?good.currency:((arguments.length>1)?arguments[1]:"EUR");
                    console.debug("Garan24::add2cart "+ good);
                    good.original_price = (isNaN(good.original_price))?good.original_price.replace(/[\,]/,'.').replace(/^\D+/,"").replace(/\D+$/,""):good.original_price;
                    good.regular_price = good.original_price*garan.currency.rates(cur);
                    good.quantity=parseInt(good.quantity);
                    good.title = good.title.replace(/['\+]+/,"");
                    //if(typeof good.sku!="undefined")good.sku=good.shop+'#'+good.sku;
                    good.description=(typeof good.description != "undefined")?good.description:"";
                    good.description+=(typeof good.shop != "undefined")?good.shop+" | "+good.description:good.description;
                    //console.debug(good);
                    if(typeof good.product_id == "undefined"){
                        if((typeof good.shop != "undefined")&&(typeof good.sku != "undefined")){
                            good.product_id = good.shop+"_"+good.sku;
                        }
                        else good.product_id = -1;
                    }
                    if(typeof good.variations != "undefined"){
                        good.description+=' | Размер: '+((typeof good.variations.size != "undefined")?good.variations.size:"не указан");
                        good.description+=' | Цвет: '+((typeof good.variations.color != "undefined")?good.variations.color:"не указан");
                    }
                    good.description+=(typeof good.comments!="undefined")?' | comments:'+good.comments:"";
                    if(!this.alreadyitem(good)){
                        garan.cart.cartQuantity+=good.quantity;
                        garan.cart.order.order_total=garan.cart.order.order_total+(good.regular_price*good.quantity);
                        this.order.items.push(good);
                    }
                }
                garan.cart.cartAmount = garan.cart.order.order_total;
                this.setCartDigits();
                this.showcart();
                this.set();
                ga('send', 'event', 'conversion', 'add2cart', 'add2cart');
            },
            alreadyitem:function(good){
                for(var i in this.order.items){
                    var it = this.order.items[i];
                    if(it.sku==good.sku&&it.title==good.title) {
                        //it.quantity=parseInt(it.quantity)+parseInt(good.quantity);
                        return true;
                    }
                }
                return false;
            },
            editItem:function(){
                //console.debug("Garan24::edit cart item(..)");
                if(!arguments.length){console.debug("nodata to add");return false;}
                var i = arguments[0],good = this.order.items[i];
                //console.debug(good);
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
                //console.debug("Garan24::remove from cart(..)");
                if(!arguments.length){console.debug("nodata to add");return false;}
                var i = arguments[0],good = this.order.items[i];
                var needconfirm = (arguments.length>1)?false:true;
                //console.debug(good);
                if(!needconfirm||confirm('Вы уверены, что хотите удалить Ваш товар из мультикорзины?')){
                    garan.cart.cartQuantity-=good.quantity;
                    garan.cart.cartAmount-=good.regular_price*good.quantity;
                    garan.cart.order.order_total=this.cartAmount;
                    this.order.items.splice(i,1);
                    this.set();
                }
            },
            removeAll:function(){
                //console.debug("Garan24::remove ALL from cart(..)");
                //for(var i in garan.cart.order.items)garan.cart.remove(i,false);
                garan.cart.cartQuantity=0;
                garan.cart.cartAmount=0;
                garan.cart.order.order_total=0;
                delete garan.cart.order.items;
                garan.cart.order.items = [];

            },
            update:function(){
                console.debug("function cart.update is not defined.");
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
                        //console.debug("Created cart.");
                        //console.debug(d);
                        garan.cart.id=d.id;
                        garan.cookie.set("cart_id",d.id,{expires:1,domain:'.bs2'});
                        garan.cookie.set("cart_id",d.id,{expires:1,domain:'.xray.bs2'});
                        garan.cookie.set("cart_id",d.id,{expires:1,domain:'.garan24.ru'});
                        garan.cookie.set("cart_id",d.id,{expires:1,domain:'.gauzymall.com'});
                        garan.cookie.set("cart_id",d.id,{expires:1,domain:'.garan24.bs2'});
                        garan.cart.inited = true;
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
                },t=this;
                //console.debug(this.order);
                //return ;
                $.ajax({
                    url:this.carthost+"/update",
                    type:"get",
                    dataType: "json",
                    crossDomain: true,
                    data:{id:this.id,value:JSON.stringify(rq)},
                    success:function(data){
                        var d=JSON.parse(data);
                        garan.cart.extend(d,t);
                    }
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
                        //console.debug("Getting data");
                        //console.debug(x);
                    },
                    success:function(data){
                        var d=JSON.parse(data);
                        garan.cart.extend(d,t);
                    },
                    error:function(){
                        garan.cart.create();
                    }
                });
            },
            extend:function(d,t){
                var tot = 0 ;
                //var d=data;
                //console.debug(d);
                if(typeof d.order != "undefined"){
                    garan.cart.order=$.extend(garan.cart.order,d.order);
                    garan.cart.cartQuantity = 0;
                    for(var i in garan.cart.order.items){
                        var item = garan.cart.order.items[i];
                        item.quantity=((typeof item.quantity!="undefined") )?item.quantity:1;
                        item.quantity=(isNaN(item.quantity))?item.quantity.replace(/.*(\d+).*/,"$1"):item.quantity;
                        //console.debug(item);
                        garan.cart.cartQuantity+=((typeof item.quantity != "undefined")&&!isNaN(item.quantity))?parseInt(item.quantity):0;
                        tot+=item.regular_price*item.quantity;
                    }
                }
                t.order.order_total = tot;
                t.cartAmount = t.order.order_total;
                garan.cart.setCartDigits();
                garan.cart.showcart();
                garan.cart.inited = true;
            },
            checkout:function(){
                garan.cart.order.order_id = garan.cart.id;
                var rq = {
                    domain_id:8,
                    version: "1.0",
                    response_url: garan.cart.carthost+"/clean?id="+this.id,
                    order:garan.cart.order
                },$m = $("#garan24-overlay");
                var tot = 0;
                for(var i=0;i<rq.order.items.length;++i ) {
                    var itm = rq.order.items[i];
                    if(typeof itm.product_id == "undefined"){
                        if((typeof itm.shop != "undefined")&&(typeof itm.sku != "undefined")){
                            itm.product_id = itm.shop+"_"+itm.sku;
                        }
                        else itm.product_id = -1;
                    }
                    delete itm.variations;
                    delete itm.currency;
                    delete itm.shop;
                    delete itm.sku;
                    rq.order.items[i] = itm;
                    tot+=itm.regular_price*itm.quantity;
                    //console.debug(itm);
                }
                rq.order.order_total = tot;
                $(document).trigger('gcart:beforeCheckout',rq);
                //return ;
                $.ajax({
                    type:"POST",
                    //url:"//service.garan24.ru/checkout/",
                    //url:"http://service.garan24.bs2/checkout/",
                    url:(document.location.hostname.match(/\.bs2/i))?"//service.garan24.bs2/checkout":"http://l.gauzymall.com/checkout",
                    dataType: "json",
                    data:JSON.stringify(rq).replace(/\'/,""),
                    beforeSend:function(){
                        if($("#garan-cart-full").hasClass("garan24-visible")){
                            $("#garan-cart").click();
                        }
                        $m.find("#garan24-overlay-message").show();
                        $m.find(".garan24-overlay-message-text").html("Обрабатываются товары из Вашей корзины...");
                        $m.fadeIn();
                    },
                    complete:function(){
                        $m.delay(4).fadeOut();
                        $(document).trigger('gcart:checkout',rq);
                    },
                    success:function(data){
                        //var d=JSON.parse(data);
                        var d=data;
                        //console.debug("checkout response ");
                        //console.debug(d);
                        if(!d.error){
                            $m.find(".garan24-overlay-message-text").html("Переход на страницу оформления заказа...");
                            console.debug(d);
                            document.location.href=garan.cart.isframe?d.redirect_url:"//gauzymall.com/g24-checkout?order-id="+d.id;
                            //document.location.href = d.redirect_url;
                        }
                    },
                    error:function(x,s){
                        $m.find(".garan24-overlay-message-text").html("Неудалось обработать корзину ["+s+"]");
                    }
                });
            },
            showcart:function(){
                var $c = $(".garan.cart"),g="",tot=0;
                //console.debug("show cart items.#"+garan.cart.order.items.length+" ("+$c.length+")");
                if($c.length){
                    g+='<h3><i class="first">Мультикорзина</i></h3>';
                    if(garan.cart.order.items.length==0){
                        g+="<div class=\"row cart-item\">";
                        g+='<div class="message">Ваша корзина еще пуста.</div>';
                        g+='</div>';
                    }
                    for(var i in garan.cart.order.items){
                        var itm = garan.cart.order.items[i];
                        if((typeof itm.title=="undefined")||!itm.title.length) itm.title = itm.product_url;
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

                    if(garan.cart.order.items.length){
                        $("#forward").show();
                        $("#forward").removeAttr("disabled");
                    }
                }
                else{
                    $c = $(".garan.x-cart");
                    g+='<h2><i class="first">Ваши</i> товары</h2>';
                    g+='<div class="garan-editional-actions"><a href="javascript:{garan.cart.update();}" class="garan-disabled"><i class="fa fa-refresh"></i> Обновить корзину</a></div>';
                    if(garan.cart.order.items.length==0){
                        g+="<div class=\"row-item\">";
                        g+='<div class="message">Ваша корзина еще пуста.</div>';
                        g+='</div>';
                    }
                    g+='<div class="garan-cart-scroll">';
                    for(var i in garan.cart.order.items){
                        var itm = garan.cart.order.items[i];
                        g+='<div class="row-item">';
                        g+='    <div class ="garan-col garan-img col-xs-2 cols-sm-2 col-md-2 col-lg-2"><img src="'+itm.product_img+'" height="100px"/></div>';
                        g+='    <div class ="garan-col garan-name col-xs-7 cols-sm-7 col-md-7 col-lg-7">';
                        g+='        <div class="row-item title">'+itm.title+'</div>';
                        g+='        <div class="row-item variations">';
                        g+='            <div class ="col-xs-4 cols-sm-4 col-md-4 col-lg-4"><i>Магазин</i>: '+itm.shop+'</div>';
                        g+='            <div class ="col-xs-4 cols-sm-4 col-md-4 col-lg-4"><i>Размер</i>: '+(itm.variations&&(typeof itm.variations['size']!="undefined")?itm.variations['size']:' - ')+'</div>';
                        g+='            <div class ="col-xs-4 cols-sm-4 col-md-4 col-lg-4"><i>Цвет</i>: '+(itm.variations&&(typeof itm.variations['color']!="undefined")?itm.variations['color']:' - ')+'</div>';
                        g+='        </div>';
                        g+='    </div>';
                        g+='    <div class ="garan-col garan-quantity col-xs-1 cols-sm-1 col-md-1 col-lg-1 quantity">'+itm.quantity+'<sup>x</sup>';
                        g+='        <a href="javascript:garan.cart.remove('+i+')" style="color:red;">&nbsp;<i class="fa fa-remove"></i></a>';
                        g+='    </div>';
                        g+='    <div class ="garan-col garan-amount col-xs-2 cols-sm-2 col-md-2 col-lg-2 amount">';
                        //g+=garan.number.format(itm.regular_price*itm.quantity,2,3,' ','.')+' руб.';
                        g+=garan.number.format(itm.regular_price,2,3,' ','.')+' руб.';
                        g+='    </div>';
                        g+='</div>';
                        tot+=itm.regular_price*itm.quantity;
                    }
                    g+='</div>';
                    if(garan.cart.order.items.length>0){
                        $(".garan-checkout").removeClass("garan24-button-disabled").addClass("garan24-button-pulse");
                        g+='<div class="row-item garan-total">';
                        g+='Сумма заказа: <strong>'+garan.number.format(tot,2,3,' ','.')+' руб.</strong>';
                        g+='&nbsp;&nbsp;&nbsp;&nbsp;<a class="garan-checkout garan24-button" href="javascript:{garan.cart.checkout();}"><i class="fa fa-shopping-bag"></i> Оформить заказ</a>';
                        g+='</div>';
                    }
                }
                garan.cart.order.order_total = tot;
                $c.html(g);
                $("#garan-helper").text(
                    (garan.cart.order.items.length>0)
                        ?'Если Вы завершили выбор товаров, нажмите "Оформить заказ", чтобы перейти к оформлению доставки'
                        :'Выберите интересующие Вас товары и добавьте их в корзину.'
                );
            },
            setCartDigits:function(){
                if(!$("#garan24-cart-quantity").length){
                    $("#garan-cart").html('<i class="fa fa-shopping-cart" area-hidden="true"></i><sup id="garan24-cart-quantity">0</sup><span id="garan24-cart-amount">0 руб.</span>');
                }
                if(!isNaN(this.cartQuantity)){
                    $("#garan24-cart-quantity").html(this.cartQuantity);
                }
                if(this.order.order_total!=null&&!isNaN(this.order.order_total))$("#garan24-cart-amount").html(this.order.order_total.format(0,3,' ','.')+" руб.");
                $("#garan-helper").text(
                    (garan.cart.order.items.length>0)
                        ?'Если Вы завершили выбор товаров, нажмите "Оформить заказ", чтобы перейти к оформлению доставки'
                        :'Выберите интересующие Вас товары и добавьте их в корзину.'
                );
            },
            init:function(){
                if(this.inited)return;
                this.id = garan.cookie.get("cart_id");
                console.debug("Init cart - "+this.id);
                $(document).trigger('gcart:load',garan.cart.order);
                if(typeof garan.cart.id!="undefined" && this.id.length ){
                    this.get();
                }
                else {
                    this.create();
                }
                this.setCartDigits();
            }
        }
    });
})(jQuery);
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
