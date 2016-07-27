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
        total+=(amt.length&&!isNaN(amt))?parseFloat(amt)*qnt:0;
    });
    $("#cart-total-price").html(total.format(2,3,' ','.')+" руб.");
    var shipping = $("#ShippingAmountHidden").val();
    if(typeof shipping!="undefined"){
        shipping=shipping.replace(/\s+/ig,'').replace(/[а-я]+\./ig,'');
        console.debug("total["+total+"] => item cost:["+shipping+"] isNaN:"+isNaN(shipping));
        total+=(shipping.length&&!isNaN(shipping))?parseFloat(shipping):0;
    }
    $("#total-price").html(total.format(2,3,' ','.')+" руб.");
    $("#shipping-price").val(total.format(2,3,' ','.')+" руб.");
}
(function(){
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

    $(".phone").mask("+7(999) 999 99 99");//.insertBefor
    $(".postcode").mask("999999");//.insertBefor
    //$(".passport-seria").mask("9999");//.insertBefor
    //$(".passport-number").mask("999999");
    //$(".passport-code").mask("999-999");
    $(".pan").mask("9999 9999 9999 9999");
    $(".expiredate").mask("99/99");
    $(".date").mask("99.99.9999");
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
    $("a").each(function(){
        var $t=$(this), mesid=$t.attr("href").replace(/[\/\:\.\-]+/ig,"_"),_ahref =encodeURIComponent($t.attr("href"));
        if($t.attr("target")=="__blank"){ // only external links
            $t.attr("href","#"+mesid).removeAttr("target");
            $.ajax({
                url:"//service.garan24.ru/crd?_href="+_ahref,
                success:function(d,s,x){
                    var cont = $(d).find("#post-110").html();
                    if(typeof cont!="undefined" && cont.length==0)cont=$(d).find("body");
                    console.debug(cont);

                    $("body").append('<div id="'+mesid+'" class="helper-box">'
                        +'<a href="#" class="helper-box-item-close"><i class="fa fa-close fa-2x"></i></a>'
                        +'<div class="helper-box-item-lg">'
                        +cont
                    +'</div></div>');
                },
                error:function(x,t,e){}
            });
        }
        if($t.hasClass("post-link")){
            $t.click(function(){
                var where = $t.attr("href");
                $("body").append('<form method="post" action="'+where+'"></form>').submit();
                //return false;
            });
        }
    });
})();
