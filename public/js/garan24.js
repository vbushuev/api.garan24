var _grn = {
    user:{
        id:"",
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
                    console.debug(jqXHR);
                    if(typeof data.code !="undefined"){
                        switch(data.code){
                            case "404":
                            default:{
                                _grn.user.create(_grn.user.email);
                            }break;
                        }
                        return;
                    }
                    _grn.user.id=data.customer.id;
                    data.customer.first_name.length?$("input.name").val(data.customer.first_name):null;
                    data.customer.last_name.length?$("input.surname").val(data.customer.last_name):null;
                    data.customer.billing_address.phone.length?$("input.phone").val(data.customer.billing_address.phone):null;
                    data.customer.billing_address.postcode.length?$("input.postcode").val(data.customer.billing_address.postcode):null;
                    data.customer.billing_address.country.length?$("select.country option").removeAttr("selected").filter("[value="+data.customer.billing_address.country+"]").attr("selected",true):null;
                },
            });
        },
        create:function(mail){
            $.ajax({
                url:"/customer/create/",
                data:{"email":mail},
                success:function(data,status,jqXHR){
                    if(typeof data.code !="undefined"){
                        return;
                    }
                    _grn.user.id=data.customer.id;
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
                        return;
                    }
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
                //$t.detach().appendTo($next);
                $("div.user").slideUp();
                _grn.stage++;
            }break;
            case 1:{
                var $next=$("div.fullname");
                console.debug("name "+$next.length);
                unDisable($next);
                //$t.detach().appendTo($next);
                $("div.postcode").slideUp();
                _grn.stage++;
            }break;
            case 2:{
                var $next=$("div.address");
                unDisable($next);
                //$t.detach().appendTo($next);
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
