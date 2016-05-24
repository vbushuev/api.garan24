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
    //$('.email').append();
    //$('<i class="fa fa-mobile" aria-hidden="true"></i>').insertBefore( ".phone" );
    //$( '<i class="fa fa-envelope-o"></i>' ).insertBefore( ".email" );
})();
