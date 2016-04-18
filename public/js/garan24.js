var _grn = {
    user:{
        email:"",
        phone:"",
        title:"",
        name:"",
        surname:"",
        set:function(u){
            _grn.user.email=$("input.email").val();
            _grn.user.phone=$("input.phone").val();
            _grn.user.title=$("input.titles").val();
            _grn.user.name=$("input.name").val();
            _grn.user.surname=$("input.surname").val();
        },
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
    foward:function(){
        var $t = $(this),t = _grn;
        console.debug("stage "+_grn.stage);
        switch(t.stage){
            case 0:{
                _grn.user.set();
                var $next=$("div.postcode");
                unDisable($next);
                $t.detach().appendTo($next);
                _grn.stage++;
            }break;
            case 1:{
                var $next=$("div.fullname");
                console.debug("name "+$next.length);
                unDisable($next);
                $t.detach().appendTo($next);
                _grn.stage++;
            }break;
            case 2:{
                var $next=$("div.address");
                unDisable($next);
                $t.detach().appendTo($next);
                _grn.stage++;
            }break;
            case 3:{
                var $next=$("div.checkout");
                unDisable($next);
                $t.detach();
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
