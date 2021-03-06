$=jQuery.noConflict();
var web = {
    required:function(){
        var ret = true;
        $(".required input:visible").each(function(e){
            var $t = $(this);
            if($t.val().length==0){
                //$t.hasClass("alert")?null:$t.addClass('alert');
                console.debug("mandatory field "+$t.attr("name"));
                $t.parent(".required").effect("shake");
                $t.focus();
                return false;
            }
            else {
                console.debug("can remove alert class on "+$t.attr("name"));
                $t.removeClass('alert');
            }
        });
        return ret;
    }
};
var Editable = function(s){
    var et = this;
    this.selector = s;
    this.jo = $(s);
    this.close = function(t){
        $(t).removeAttr("contentEditable");
        $(t).parent().find(".editable-ok, .editable-cancel").remove();
        console.debug("Cancel data");
    };
    this.save = function(t){
        console.debug("Saving data");
        var $t=$(t),url=$t.attr("data-rel"),f = $t.attr("data-ref"),v=$t.text();
        //$.ajax();
    };
    this.click = function(t,et){
        var $t = $(t),v = $t.find(".value").text();
        console.debug("Lets edit editable ["+v+"]");
        $t.attr("contentEditable","true");
        $t.after('<a href="javascript:0;" class="editable-ok"><i class="fa fa-check"></i></a>').on("click",function(){et.save(this)});
        $t.after('<a href="javascript:0;" class="editable-cancel"><i class="fa fa-close"></i></a>').on("click",function(){et.close(this)});
        $t.focus();
    };
    $(s).each(function(){
        $(this).on("click",function(){et.click(this,et)});
    });
};
function initEditable(){
    $(".editable-field .editable-value").each(function(){
        var $t = $(this),url=$t.attr("data-rel"),f = $t.attr("data-ref"),v=$t.text();
        $t.on("click",function(){
            var $tt = $(this);
            console.debug("Lets edit editable ["+v+"]");

            $t.attr("contentEditable","true");
            var save = $('<a href="javascript:0;" class="editable-ok"><i class="fa fa-check"></i></a>').on("click",function(){
                console.debug("Saving data "+url+" "+f+" = "+v);
                var new_v= $tt.text().replace(/[\r\n]/,'');
                console.debug(new_v);
                $.ajax({
                    url:url+'&'+f+'='+new_v,
                    type:"get",
                    dataType:"json",
                    complete:function(d){
                        console.debug(d);
                        $tt.removeAttr("contentEditable");
                        $tt.parent().find(".editable-ok, .editable-cancel").remove();
                    }
                });
            });

            var close = $('<a href="javascript:0;" class="editable-cancel"><i class="fa fa-close"></i></a>').on("click",function(){
                $tt.removeAttr("contentEditable");
                $tt.parent().find(".editable-ok, .editable-cancel").remove();
                $tt.text(v);
                console.debug("Cancel data");
            });
            $t.after(close);
            $t.after(save);
            $t.focus();
            $t.blur(function(e){
                setTimeout(function(){$tt.parent().find(".editable-ok, .editable-cancel").remove()},2400);
            });
        });
    });
}
function moveCaretToStart(el) {
    console.debug(el+" caret to start");
    if (typeof el.selectionStart == "number") {
        el.selectionStart = el.selectionEnd = 0;
    } else if (typeof el.createTextRange != "undefined") {
        el.focus();
        var range = el.createTextRange();
        range.collapse(true);
        range.select();
    }
}
function calculateTotal(){
    var total = 0;
    $(".cart-item .amount:not(.total-amount)").each(function(){
        var $t = $(this),amt = $t.text().replace(/\s+/ig,'').replace(/[а-я]+\./ig,''),
            qnt = $t.prev(".quantity").text().replace(/\s+/ig,'').replace(/[а-я\.]+\./ig,'');

        console.debug("total["+total+"] => item cost:["+amt+" x "+qnt+"] isNaN:"+isNaN(amt));
        //total+=(amt.length&&!isNaN(amt))?parseFloat(amt)*qnt:0;
        total+=(amt.length&&!isNaN(amt))?parseFloat(amt):0;
    });
    $("#cart-total-price").html(total.format(2,3,' ','.')+" руб.");
    var shipping = $("#ShippingAmountHidden").val();
    console.debug("var shipping = "+shipping);
    if(typeof shipping=="undefined")shipping=$("shipping-price").text().replace(/\s+/ig,'').replace(/[а-я]+\./ig,'');
    if(typeof shipping!="undefined"){
        shipping=shipping.replace(/\s+/ig,'').replace(/[а-я]+/ig,'');
        console.debug("total["+total+"] => item cost:["+shipping+"] isNaN:"+isNaN(shipping));
        total+=(shipping.length&&!isNaN(shipping))?parseFloat(shipping):0;
    }
    //var tt = total*0.05+garan.currency.rates('EUR')*5;
    //total+=tt;
    //$("#ServiceFeeHidden").val(tt);
    //$("#order-fee").html(tt.format(2,3,' ','.')+" руб.");
    $("#ServiceFeeHidden").val(0);

    //!!!! SALE
    //$("#order-fee").html("<strike>"+$("#order-fee").html()+"</strike><br/>0 руб.");
    //total-=tt;
    //$("#ServiceFeeHidden").val(0);
    //!!!! SALE END
    $("#TotalAmountHidden").val(total);
    $("#total-price").html(total.format(2,3,' ','.')+" руб.");
    $("#shipping-price").val(total.format(2,3,' ','.')+" руб.");
}

(function(){
    jQuery.fn.controlInput = function(){
        var re = arguments.length?arguments[0]:/\d+\.?\d{0,2}/i;
        return this.each(function(){
            $(this).keydown(function(e){

                // Allow: backspace, delete, tab, escape, enter, ctrl+A and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 191]) !== -1 ||
                    // Allow: Ctrl+A
                    ((e.keyCode == 65 ||e.keyCode == 86) && e.ctrlKey) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39) ){
                        // let it happen, don't do anything
                        console.debug("allow");
                        return;
                }
                var charValue = String.fromCharCode(e.keyCode),
                    valid =re.test(charValue);
                if (!valid)e.preventDefault();
            });
        });
    }
    /*
    $.animate(
        {
            color:bcolor,
            borderColor:bcolor,
            backgroundColor:fcolor
        },
        400,
        "swing",
        function(){$t.removeClass("-animating");}
    );
    */
    //$.mask.definitions['~']='\+7';

    garan.currency.get();
    $(".phone").mask("+7(999) 999 99 99");//.insertBefor
    $(".postcode").mask("999999");//.insertBefor
    //$(".passport-seria").mask("9999");//.insertBefor
    //$(".passport-number").mask("999999");
    //$(".passport-code").mask("999-999");
    //$(".pan").mask("9999 9999 9999 9999");
    $(".expiredate").mask("99/99");
    $(".date").mask("99.99.9999");
    //$(".amount").controlInput();
    $(".input-group input").blur(function(){
        var $t = $(this),icon = $t.parent().find('i.fa');
        if(icon.hasClass('fa-square-o')&&$t.val().length){
            icon.removeClass('fa-square-o');
            icon.addClass('fa-check-square-o');
        }
        else if(icon.hasClass('fa-check-square-o')&&!$t.val().length){
            icon.removeClass('fa-check-square-o');
            icon.addClass('fa-square-o');
        }
    });
    $("input,textarea").on("focus",function(){
        //console.debug("Moving caret to Start");
        var $t=$(this);
        moveCaretToStart($t.get());
    });
    $(".combo .dropdown-menu li a").css("cursor","pointer").click(function(){
        var $t=$(this),
            parent=$t.parent().parent().parent(),
            textval=parent.find(".combo-value"),
            keyval=parent.find("input[type='hidden']"),
            val=$t.attr("data-value"),
            text=$t.find(".combo-item-value").text(),
            icon = $t.find(".fa");
        parent.find('.fa-check-square-o')
            .removeClass('fa-check-square-o')
            .addClass('fa-square-o');
        if(icon.hasClass('fa-square-o')){
            icon.removeClass('fa-square-o');
            icon.addClass('fa-check-square-o').delay(200);
        }
        keyval.val(val);
        textval.text(text);
    });
    calculateTotal();
    /*helper section*/
    $(".helper").on("mouseover",function(){
        var sec = $(".helped.active:last").attr("data-helper");
        $(".helper-box-item."+sec).show();
        $(".helper-text").html($(".helper-box-item."+sec).text()).show();
    }).on("mouseout",function(){
        $(".helper-text").hide();
    }).on("click",function(){
        var sec = $(".helped.active:last").attr("data-helper");
        $(".helper-box-item."+sec).show();
    });
    /*$(".helper-box-item-close").on("click",function(){
        $(this).parent(".helper-box-item").slideUp();
    });*/
    $(".list-group-item").on("click",function(){
        var $t = $(this), $i = $t.find(".fa"), $p = $t.parent(".list-group");
        $p.find(".list-group-item").removeClass("active");
        $p.find(".list-group-item .fa").removeClass("fa-check-square-o").removeClass("fa-square-o").addClass("fa-square-o");
        $t.addClass("active");
        $i.removeClass("fa-square-o").addClass("fa-check-square-o");
    });

    $("a[target='__blanko']").each(function(){
        var $t=$(this),
            mesid=$t.attr("href").replace(/[\/\:\.\-]+/ig,"_"),
            _ahref =encodeURIComponent($t.attr("href"));
        if(typeof mesid == "undefined") return;
        $t.removeAttr("target");
        $t.click(function(e){
            e.preventDefault();
            console.debug("mesid="+mesid+" is making modal...");
            $.ajax({
                url:((document.location.hostname.match(/\.bs2/i))?"http://service.garan24.bs2":"https://service.garan24.ru")+"/crd?_href="+_ahref,
                beforeSend:function(){
                    $("body").append('<div id="'+mesid+'" class="modal-box"><div class="modal-box-item-lg" style="align:center;vertical-align:middle;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div></div>');
                },
                success:function(d,s,x){
                    var cont = d;
                    /*var cont = $(d).find("#post-110").html();
                    if(typeof cont!="undefined" && cont.length==0)cont=$(d).find("body");
                    else {cont = d;}*/
                    console.debug("got modal content.");
                    $("#"+mesid).html('<a href="javascript:{$(\'#'+mesid+'\').hide().remove();}" class="modal-box-item-close"><i class="fa fa-close fa-2x"></i></a>'
                    +'<div class="modal-box-item-lg">'
                    +cont
                    +'</div>').find("header").remove();
                },
                error:function(x,t,e){}
            });
        });
    });
    $("a.post-link").each(function(){
        var $t=$(this),
            mesid=$t.attr("href"),//.replace(/[\/\:\.\-]+/ig,"_"),
            _ahref =encodeURIComponent($t.attr("href"));
        if(typeof mesid == "undefined") return;
        $t.click(function(){
            var where = $t.attr("href");
            $("body").append('<form method="post" action="'+where+'"></form>').submit();
            //return false;
        });
    });
    // GoogleAnalytics
    if(typeof ga!="undefined"){
        console.debug("GA events.");
        $("[name='email']").on("blur",function(){
            var $t = $(this),v = $(this).val();
            ga('send','event','checkout','email',v,1);
            console.debug("GA event: email["+v+"] entered.");
        });
        $("[name='phone']").on("blur",function(){
            var $t = $(this),v = $(this).val();
            ga('send','event','checkout','phone',v,1);
            console.debug("GA event: phone["+v+"] entered.");
        });
    }

    $(document).ready(function(){
        initEditable();
        /*$("#form #back").unbind("click").on("click",function(e){
            e.preventDefault();
            e.stopPropagation();
            history.go(-1);
        });*/
    });
})();
