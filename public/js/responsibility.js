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
    $(".passport-seria").mask("9999");//.insertBefor
    $(".passport-number").mask("999999");
    $(".passport-code").mask("999-999");
    $(".pan").mask("9999 9999 9999 9999");
    $(".expiredate").mask("99/99");
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
    console.debug("Get boxberry cities");
    /*$.ajax({
        url:"http://api.boxberry.de/json.php?token=17324.prpqcdcf&method=ListCities",
        dataType:"json",
        success:function(d,s,x){
            console.debug(d)
        },
        error:function(x,t,e){
            console.debug(t);
        }
    });*/
    console.debug("Get boxberry cities. ENDs");
    //$('.email').append();
    //$('<i class="fa fa-mobile" aria-hidden="true"></i>').insertBefore( ".phone" );
    //$( '<i class="fa fa-envelope-o"></i>' ).insertBefore( ".email" );

})();
