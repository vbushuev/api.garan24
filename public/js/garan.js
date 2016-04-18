/*******************************************************************
 * Woo Commerce keys
 * Key:     ck_a060e095bdafdc57d95fb4df2d19aa9a2d671a91
 * Secret:  cs_4bbfa365ae1850f93f1144ebe666302315831ff0
 ******************************************************************/
function makeDisable(){
    $(".disabled").each(function(){
        $(this).append("<div class=\"disable_overlay\" style=\"position:absolute;background-color:rgba(255,255,255,.7);width:100%;height:100%;top:0;left:0;\"></div>");
        $(this).find("input,select,button").attr("disabled",true);
    })
}
function unDisable(c){
    if(c.hasClass("disabled")){
        c.removeClass("disabled");
        c.find("input,select,button").attr("disabled",false);
        c.find(".disable_overlay").remove();
        console.debug("has disabled class");
    }
}
(function(){
    makeDisable();

})();
