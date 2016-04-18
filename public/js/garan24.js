var _grn = {
    user:{
        email:"",
        phone:"",
        title:"",
        name:"",
        surname:"",
        set:function(u){
            _grn.user.email=$("input.email").val();
            _grn.user.check();
            _grn.user.phone=$("input.phone").val();
            _grn.user.title=$("input.titles").val();
            _grn.user.name=$("input.name").val();
            _grn.user.surname=$("input.surname").val();
        },
        check:function(){
            $.ajax({
                url:"/customer/"+_grn.user.email,
                dataType: "json",
                success: function(data,status,jqXHR){
                    $("input.name").val(data.customer.billing_address.first_name);
                    $("input.surname").val(data.customer.billing_address.last_name);
                    $("input.phone").val(data.customer.billing_address.phone);
                    $("input.postcode").val(data.customer.billing_address.postcode);
                    $("select.country option[val='"+data.customer.billing_address.country+"']").attr("selected",true);
                }
            });
        }
    },
    order:{
        items:[]
    },
    shipping:{
        postcode:"",
        country:"",
        set:function(){
            _grn.shipping.postcode=$("input.postcode").val();
            _grn.shipping.country=$("select.country").val();
        }
    },
    stage:0,
    mandatory:function(){
        var ret = true;
        $(".required:visible").each(function(e){
            var $t = $(this);
            if($t.val().length==0){
                $t.hasClass("alert")?null:$t.addClass('alert');
                console.debug("mandatory field "+$t.attr("id"));
                ret = false;
            }
            else {
                console.debug("can remove alert class on "+$t.attr("id"));
                $t.removeClass('alert');
            }
        });
        return ret;
    },
    foward:function(){
        var $t = $(this),t = _grn;
        if(!_grn.mandatory())return;
        switch(t.stage){
            case 0:{
                _grn.user.set();
                var $next=$("div.postcode");
                unDisable($next);
                $t.detach().appendTo($next);
                $("div.user").slideUp();
                _grn.stage++;
            }break;
            case 1:{
                var $next=$("div.fullname");
                console.debug("name "+$next.length);
                unDisable($next);
                $t.detach().appendTo($next);
                $("div.postcode").slideUp();
                _grn.stage++;
            }break;
            case 2:{
                var $next=$("div.address");
                unDisable($next);
                $t.detach().appendTo($next);
                $("div.fullname").slideUp();
                _grn.stage++;
            }break;
            case 3:{
                var $next=$("div.checkout");
                unDisable($next);
                $t.detach();
                $("div.address").slideUp();
                _grn.stage++;
            }break;
            case 4:{}break;
        }
    },
    checkout:function(){}
};
var Garan24 = function(data){
    $.extend(_grn,data);
}
/******************************************************************************
 *
 *****************************************************************************/
$("#foward").on("click",_grn.foward);
$("#checkout").on("click",_grn.checkout);
