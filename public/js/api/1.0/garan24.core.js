window.garan = {
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
            console.debug("VARS json"+vars.json());
            console.debug("VARS html"+vars.html());
            htmlForm.submit();
            return false;
        },
        required:function(){
            var args = arguments.length?arguments[0]:{form:$("form:first")}, ret=true;;
            args.form.find(".input-group.required input:visible,.input-group.required select:visible,.input-group.required textarea:visible").each(function(){
                var $t = $(this), check = true,val = $t.val(),
                    emailRegEx = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                check = check&($t.val().length>0);
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
    preorder:{
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
};
(function(){

})();
