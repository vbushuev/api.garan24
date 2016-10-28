jQuery.noConflict();
(function($) {
    window.garan = {
        service:{
            host:(document.location.hostname.match(/\.bs2/i))?"http://service.garan24.bs2":"http://l.gauzymall.com"
        },
        currency:{
            //multiplier:1.05,
            multiplier:1.00,
            EUR:69.00,
            USD:62.39,
            GBP:76.00,
            RUB:1.00,
            rates:function(){
                var cur = arguments.length?arguments[0]:false;
                if(!cur) cur = 'EUR';
                return garan.currency.multiplier*garan.currency[cur];
            },
            get:function(){
                var cb = (arguments.length&&typeof arguments[0]=="function")?arguments[0]:function(){};
                $.ajax({
                    url:garan.service.host+"/currency",
                    type:"get",
                    dataType: "json",
                    crossDomain: true,
                    success:function(data){
                        var d=data;
                        if(Array.isArray(d)){
                            for(var i=0; i<d.length;++i){
                                var c = d[i];
                                garan.currency[c.iso_code] = c.value;
                            }
                        }
                        cb(d);
                    }
                });
            },
            converter:{
                options:{
                    replacement:/[^\d\.\,]/,
                    selector:".amount",
                    currency:"EUR"
                },
                /* Convert currency values into rubles
                 * @param json Object
                 * replacement - RegEx of value search may be array
                 * selector - selector string for html elements consists values, may be array so replacement[i] is for selector[i] and so on. Also each selector can has one replacement
                 * currency - what the original currency (EUR,GBP,USD)
                 */
                action:function(){
                    var b = garan.cookie.get("g.currency.convert"), //i don't know why
                        o = $.extend(this.options,arguments.length?arguments[0]:{}),
                        rub = '&#8381;'
                        c = garan.currency.rates(o.currency);
                    if(typeof o.selector == "string") o.selector = [o.selector];
                    for(var i=0;i<o.selector.length;++i){
                        var ss = o.selector[i]
                            rr = (typeof o.replacement == "array")?o.replacement[i]:o.replacement;
                        $(ss).each(function(){
                            var txt = $(this).text();
                            if($(this).is(":visible")&&txt.match(rr)){
                                var amt = $(this).clone();
                                amt.html($(this).text().replace(rr,function(){
                                    var m = arguments[0],
                                        r = arguments[1].replace(/[\,]/,".").replace(/\s*/,"");
                                    //console.debug(r);
                                    r = parseFloat(r)*c;
                                    return garan.number.format(r,2,3,' ','.')+" "+rub;
                                }));
                                $(this).hide();
                                amt.insertAfter($(this));
                            }
                        });
                    }
                }
            }
        },
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
                    o = (arguments.length>2)?arguments[2]:{path:'/',domain:document.location.hostname},/*o.expires:9999, o.secure*/
                    e = new Date();
                e.setDate(e.getDate()+((typeof o.expires!="undefined")?o.expires:9999));
                document.cookie = encodeURIComponent(n) + "=" + encodeURIComponent(v)
                    + "; expires=" + e.toUTCString()
                    + (typeof o.domain !="undefined" ? "; domain=" + o.domain : "")
                    + (typeof o.path !="undefined" ? "; path=" + o.path : "")
                    + (typeof o.secure !="undefined" ? "; secure" : "");
                return true;
            },
            delete:function(){
                if(arguments.length<=0)return "";
                var n = arguments[0],
                    e = (arguments.length>1)?arguments[1]:{path:"/",domain:document.location.hostname};
                document.cookie = n + "=" + ((e.path) ? ";path="+e.path:"")+((e.domain)?";domain="+e.domain:"") +";expires=Thu, 01 Jan 1970 00:00:01 GMT";
            }
        },
        form:{
            submit:function(){
                var args = arguments.length?arguments[0]:{form:$("form:first")};
                if(!garan.form.required(args))return false;
                var vars= new garan.form.getvars(args);
                var htmlForm = $('<form method="post" action="'+args.url+'">'// enctype="multipart/form-data">'
                    +vars.html()
                    +'</form>');
                htmlForm.appendTo("body");
                console.debug("VARS"+vars);
                htmlForm.submit();
                return false;
            },
            goback:function(){
                var args = arguments.length?arguments[0]:{form:$("form:first")};
                var vars= new garan.form.getvars(args);
                var htmlForm = $('<form method="'+args.type+'" action="'+args.url+'">'// enctype="multipart/form-data">'
                    //+vars.html()
                    +'</form>');
                htmlForm.appendTo("body");
                console.debug("goback vars"+vars);
                htmlForm.submit();
                return false;
            },
            required:function(){
                var args = arguments.length?arguments[0]:{form:$("form:first")}, ret=true;
                console.debug("required list-group "+$(".list-group.required").length);
                console.debug("required list-group active"+$(".list-group.required").find(".list-group-item.active").length);
                args.form.find(".list-group.required").each(function(){
                    var $t = $(this), check = true,val = $t.val();
                    check = check&($t.find(".list-group-item.active").length);
                    console.debug(".list-group-item.active["+check+"] "+$t.find(".list-group-item.active").length)
                    if(!check){
                        $t.effect("shake");
                        ret = false;
                        return false;
                    }
                });
                if(!ret) return ret;
                args.form.find(".input-group.required input:visible,.input-group.required select:visible,.input-group.required textarea:visible,.input-field.required input:visible").each(function(){
                    var $t = $(this), check = true,val = $t.val(),
                        emailRegEx = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

                    check = check&(val.length>0);
                    if($t.hasClass("email"))check = check&emailRegEx.test(val);
                    if(!check){
                        //$t.hasClass("alert")?null:$t.addClass('alert');
                        $t.parent(".required").effect("shake");
                        $t.focus();
                        ret = false;
                        return false;
                    }
                });
                return ret;
            },
            getvars:function(){
                var args = arguments.length?arguments[0]:{form:$("form:first")};
                this.ret = {};
                var tt = this;
                args.form.find("input,select,textarea").each(function(){
                    var $t = $(this),n=$t.attr("name"),v=$t.val();
                    if($t.hasClass("phone")){
                        v=v.replace(/[\(\)\s]/ig,'');
                    }
                    if(n!="undefined"&&v.length)tt.ret[n] = v;
                });
                tt.json=function(){return tt.ret;};
                tt.html=function(){
                    var s="";
                    $.each(tt.ret,function(i,v){
                        s+='<input type="hidden" name="'+i+'" value="'+v+'">';
                    });
                    return s;
                };
            }
        },
        number:{
            format:function(t,n, x, s, c) {
                var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                    num = parseFloat(t).toFixed(Math.max(0, ~~n));

                return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
            }
        },
    };
})(jQuery);


/**
 * Number.prototype.format(n, x, s, c)
 *
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
 */
 Number.prototype.format = function(n, x, s, c) {
     var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
         num = this.toFixed(Math.max(0, ~~n));

     return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
 };

/*preorder:{
    x_secret: "cs_89f95570b4bd18759b8501cd16e4756ab03a544c",
    x_key: "ck_7575374a55d17741f3999e8c98725c6471030d6c",
    version: "1.0",
    order: {
        order_url: "http://demostore.garan24.ru",
        order_id: 58,
        payment_details: {
        method_id: "garan24",
        method_title: "Garan24 Pay",
        paid: false
    },
    billing_address: {
        first_name: "\u0412\u043b\u0430\u0434\u0438\u043c\u0438\u0440",
        last_name: "\u0411\u0443\u0448\u0443\u0435\u0432",
        address_1: "\u041c\u043e\u043b\u043e\u0434\u0446\u043e\u0432\u0430",
        city: "\u041c\u043e\u0441\u043a\u0432\u0430",
        state: "",
        postcode: "127221",
        country: "RU",
        phone: "9265766710",
        email: "yanusdnd@inbox.ru"
    },
    line_items: {
        65: {
            name: "Jacket",
            type: "line_item",
            item_meta: {
                _qty: ["1"],
                _tax_class: [""],
                _product_id: ["9"],
                _variation_id: ["0"],
                _line_subtotal: ["79"],
                _line_total: ["79"],
                _line_subtotal_tax: ["0"],
                _line_tax: ["0"],
                _line_tax_data: ["a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"]
            },
            item_meta_array: {
                427: {
                    key: "_qty",
                    value: "1"
                },
            428: {
                key: "_tax_class",
                value: ""
    },
            429: {
                key: "_product_id",
                value: "9"
    },
            430: {
                key: "_variation_id",
                value: "0"
    },
            431: {
                key: "_line_subtotal",
                value: "79"
    },
            432: {
                key: "_line_total",
                value: "79"
    },
            433: {
                key: "_line_subtotal_tax",
                value: "0"
    },
            434: {
                key: "_line_tax",
                value: "0"
    },
            435: {
                key: "_line_tax_data",
                value: "a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"
    }
},
        qty: "1",
        tax_class: "",
        product_id: "9",
        variation_id: "0",
        line_subtotal: "79",
        line_total: "79",
        line_subtotal_tax: "0",
        line_tax: "0",
        line_tax_data: "a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"
},
    66: {
        name: "Office package #1",
        type: "line_item",
        item_meta: {
            _qty: ["1"],
            _tax_class: [""],
            _product_id: ["32"],
            _variation_id: ["0"],
            _line_subtotal: ["650"],
            _line_total: ["650"],
            _line_subtotal_tax: ["0"],
            _line_tax: ["0"],
            _line_tax_data: ["a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"]
},
        item_meta_array: {
            436: {
                key: "_qty",
                value: "1"
    },
            437: {
                key: "_tax_class",
                value: ""
    },
            438: {
                key: "_product_id",
                value: "32"
    },
            439: {
                key: "_variation_id",
                value: "0"
    },
            440: {
                key: "_line_subtotal",
                value: "650"
    },
            441: {
                key: "_line_total",
                value: "650"
    },
            442: {
                key: "_line_subtotal_tax",
                value: "0"
    },
            443: {
                key: "_line_tax",
                value: "0"
    },
            444: {
                key: "_line_tax_data",
                value: "a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"
    }
},
        qty: "1",
        tax_class: "",
        product_id: "32",
        variation_id: "0",
        line_subtotal: "650",
        line_total: "650",
        line_subtotal_tax: "0",
        line_tax: "0",
        line_tax_data: "a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"
},
    67: {
        name: "Sofa design",
        type: "line_item",
        item_meta: {
            _qty: ["1"],
            _tax_class: [""],
            _product_id: ["24"],
            _variation_id: ["0"],
            _line_subtotal: ["148"],
            _line_total: ["148"],
            _line_subtotal_tax: ["0"],
            _line_tax: ["0"],
            _line_tax_data: ["a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"]
},
        item_meta_array: {
            445: {
                key: "_qty",
                value: "1"
    },
            446: {
                key: "_tax_class",
                value: ""
    },
            447: {
                key: "_product_id",
                value: "24"
    },
            448: {
                key: "_variation_id",
                value: "0"
    },
            449: {
                key: "_line_subtotal",
                value: "148"
    },
            450: {
                key: "_line_total",
                value: "148"
    },
            451: {
                key: "_line_subtotal_tax",
                value: "0"
    },
            452: {
                key: "_line_tax",
                value: "0"
    },
            453: {
                key: "_line_tax_data",
                value: "a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"
    }
},
        qty: "1",
        tax_class: "",
        product_id: "24",
        variation_id: "0",
        line_subtotal: "148",
        line_total: "148",
        line_subtotal_tax: "0",
        line_tax: "0",
        line_tax_data: "a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"
}
},
    order_total: "877.00",
    order_currency: "EUR",
    customer_ip_address: "31.173.82.154",
    customer_user_agent: "Mozilla\/5.0 (Windows NT 10.0; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/50.0.2661.94 Safari\/537.36"
}
}
customer_resource:{
    display:function(){

    },
    check:function(){
        if(!arguments.length || typeof arguments[0].email == "undefined") return {};
        var r=arguments[0];
        $.ajax({
            url:"/customer/"+r.email,
            dataType: "json",
            success: function(data,status,jqXHR){
                console.debug(jqXHR);
                if(typeof data.code !="undefined"){
                    if(data.code == "404"){
                        //garan.customer.create(r);
                    }
                    r.failed();
                }else {
                    $.extend(garan.customer,data);
                    r.success();
                }
            },
            error: function(jqXHR,textStatus){
                console.error(textStatus);
            }
        });
    },
    create:function(mail){
        if(!arguments.length || typeof arguments[0].email == "undefined") return {};
        var r=arguments[0];
        $.ajax({
            url:"/customer/create/",
            data:r,
            success:function(data,status,jqXHR){
                if(typeof data.code !="undefined"){
                    r.failed();
                }
                $.extend(garan.customer,data);
                r.success();
            }
        });
    },
    update:function(){
        $.ajax({
            url:"/customer/"+_grn.user.id,
            method:"PUT",
            data:_grn.user,
            success:function(data,status,jqXHR){
                if(typeof data.code !="undefined"){
                    console.error("code:"+data.code+". Message:"+data.message);

                }
            }
        });
    }
},

*/
