@extends('cart.layout')
@section('content')
<style>
    #add2cartform *{
        font-size: 10pt;
    }
    #add2cartform .control-label {
        display: block;
    }
    #add2cartform .form-group {
        margin-bottom: 10px;
    }
    #garan24-overlay{
        height: 100%;
        width: 100%;
        position:fixed;
        top:56px;left: 0;
        background-color: rgba(0,0,0,.3);
        z-index:999;
        display: none;
    }
    #garan24-overlay-cover{
        position: absolute;
        top:0;left: 0;bottom: 0;right: 0;
    }
    #garan24-overlay-message{
        z-index:1000;
        background-color: rgba(255,255,255,1);
        overflow: auto;
        position: relative;
        margin: 6em 20%;
        padding: 2em;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        font-size: 14pt;
        text-align: center;
    }
    .fill-data{
        cursor: pointer;
        font-size: 12pt;
        display: inline-block;
        height: 36px;
        line-height: 36px;
    }
    #sugestion {
        font-size: 14pt;
    }
    #sugestion .image{
        text-align: center;
        padding:10px;
    }
    #sugestion .name{
        padding:10px;
        padding-left:20px;
    }
    #sugestion .fa{
        margin-left: -18px;
    }
    #sugestion .image img{
        display: inline-block;
    }
</style>

<div id="garan24-overlay">
    <!--<div id="garan24-overlay-cover"></div>-->
    <div id="garan24-overlay-message">
        <span class="garan24-overlay-message-text">here is message</span><br />
        <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
    </div>
</div>
<div class="row">
    <div id="form" class="form col-xs-12 col-sm-12 col-md-5 col-lg-5">
        <h3><i class="first">Мой</i> товар</h3>
        <!--<a href="/euro-sizes.html" rel="modal:open">Таблица размеров</a>-->

        <div id="add2cartform" style="padding:0;margin:0;">
            <div class="form-group url-field">
                <label for="email" class="control-label">Скопируйте в это поле ссылку на товар:</label>
                @include('elements.inputs.input',['id'=>'productUrl','name'=>'url','text'=>'URL ссылка на товар','required'=>"required", "icon"=>"external-link"])
            </div>
            <div class="after-url" style="padding:0;margin:0;">
            <div class="form-group">
                <label for="title" class="control-label">Скопируйте сюда наименование товара:</label>
                @include('elements.inputs.input',['name'=>'title','text'=>'Наименование товара','required'=>"required", "icon"=>"file-text"])
            </div>
            <div class="form-group" style="display:none;">
                <label for="sku" class="control-label">Артикул товара:</label>
                @include('elements.inputs.input',['name'=>'sku','text'=>'Код товара', "icon"=>"barcode"])
            </div>

            <div class="form-group">
                <label for="color" class="control-label">Скопируйте или впишите Цвет товара (если есть выбор):</label>
                @include('elements.inputs.input',['name'=>'color','text'=>'например: серый', "icon"=>"circle-o"])
            </div>
            <div class="form-group">
                <label for="dimensions" class="control-label">Укажите размер (если есть выбор):</label>
                @include('elements.inputs.input',['name'=>'size','text'=>'например: М или 36', "icon"=>"circle-o"])
                <a href="http://gauzymall.com/g24-sizes" target="__blank">Таблица размеров</a>
            </div>
            <div class="form-group">
                <label for="amount" class="control-label">Впишите стоимость товара:</label>
                @include('elements.inputs.amount',['text'=>'Стоимость товара','required'=>"required", "values"=>[
                    ["key"=>"EUR","icon"=>"euro","value"=>"Евро","selected"=>"true"],
                    ["key"=>"GBP","icon"=>"gbp","value"=>"Фунт"],
                    ["key"=>"USD","icon"=>"usd","value"=>"Доллар"]
                ] ])
            </div>

            <div class="form-group">
                <label for="quantity" class="control-label">Количество:</label>
                @include('elements.inputs.input',['name'=>'quantity','type'=>'number','text'=>'Кол-во','required'=>"required", "icon"=>"circle-o", "value" => "1"])
            </div>

            <!--
            <div class="form-group">
                <label for="weight" class="control-label">Вес товара:</label>
                @include('elements.inputs.input',['name'=>'weight','text'=>'Вес товара', "icon"=>"circle-o"])
            </div>
            -->
            <div class="form-group">
                <label for="comments" class="control-label">Комментарии к товару:</label>
                <textarea id="comments" name="comments" class="form-control" placeholder="Комментарии к товару, промокод или информация о скидке. Пишите любую информацию." rows="3"></textarea>
            </div>
            </div>
            <div class="row cart-buttons">
                <input type="hidden" name="img" />
                <a id="edit" class="btn btn-default btn-lg" style="display:none;"><i class="fa fa-pencil"></i> Сохранить</a>
                <button id="add2cart" class="btn btn-default btn-lg pull-right" disabled="disabled"><i class="fa fa-cart-plus"></i> Добавить</button>
            </div>
            <h3><i class="first">Внимательно</i> проверьте все поля покупки: размер, цвет, кол-во и цену.</h3>

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
        <div class="cart">
            @include('cart.goods')
        </div>

        <button id="forward" class="btn btn-success btn-lg pull-right" disabled="disabled">Оформить заказ</button>
    </div>
    <div id="sugestion" class=" col-xs-12 col-sm-12 col-md-6 col-lg-6"></div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

    </div>
</div>
<script src="/js/responsibility.js"></script>
<script>
    var collectData = function(){
        var varis = [];
        var domain = document.createElement("a");
        domain.href=$("[name='url']").val();
        var img = $("[name='img']").val();
        if(img.length==0) img = "http://service.garan24.ru/default.png";
        return {
            shop:domain.hostname,
            comments:$("[name='comments']").val(),
            product_id:-1,
            quantity:$("[name='quantity']").val(),
            regular_price:$("[name='amount']").val().replace(/\,/,'.'),
            original_price:$("[name='amount']").val().replace(/\,/,'.'),
            title: $("[name='title']").val(),
            description: $("[name='title']").val(),
            product_url:$("[name='url']").val(),
            product_img:img,
            weight:$("[name='weight']").val(),
            dimensions:{
                "height":"100",
                "width":"10",
                "depth":"40"
            },
            //sku:$("[name='sku']").val(),
            variations:{
                color: $("[name='color']").val(),
                size: $("[name='size']").val()
            }
        }
    }
    var decollectData = function(){
        var p = arguments[0], i = arguments[1];
        $("[name='quantity']").val(p.quantity);
        $("[name='amount']").val(p.original_price);
        $("[name='title']").val(p.title);
        $("[name='comments']").val((typeof p.comments!="undefined" && p.comments.length)?p.comments:"");

        $("[name='url']").val(p.product_url);
        $("[name='img']").val(p.product_img);
        $("[name='weight']").val(p.weight);
        $("[name='color']").val(p.variations.color);
        $("[name='size']").val(p.variations.size);
        $("#edit").show();
        $("#add2cart").attr("disabled","disabled");
        $("#edit").unbind("click").on("click",function(){
            garan.cart.remove(i,false);
            $("#add2cart").click();
            $("#edit").hide();
        });
    }
    window.collectData = collectData;
    $(document).ready(function(){
        garan.cart.init();
        //$("#productUrl").on("blur change",function(){
        $("#productUrl").on("keyup",function(){
            var $t=$(this),
                $v=$(this).val(),
                re=/^(http|https)\:\/\/[0-9a-z\.\#\?\&\-\;\%\/\=]+$/i;
            console.debug("url changed v="+$v+ " test re="+re.test($v));
            //$(".cart").removeClass("col-md-8").removeClass("col-lg-8").addClass("col-md-12").addClass("col-lg-12");
            //$("#iframe").removeClass("col-xs-0").removeClass("col-sm-0").removeClass("col-md-0").removeClass("col-lg-0")
                //.addClass("col-xs-12").addClass("col-sm-12").addClass("col-md-8").addClass("col-lg-8")
                //.html('<iframe src="'+$v+'" width="100%" height="800px" style="border:none;overflow:auto;"></iframe>');

            $("#add2cart").removeAttr("disabled");
            $.ajax({
                url:"/cart/parseproduct",
                type:"post",
                dataType:"json",
                data: $v,
                beforeSend:function(){
                    $("#add2cartform").css({
                        "-webkit-filter": "blur(2px)",
                        "-moz-filter": "blur(2px)",
                        "-o-filter":"blur(2px)",
                        "-ms-filter": "blur(2px)",
                        "filter": "blur(2px)"
                    });
                    $('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>')
                    .css({zIndex:400,position:"absolute",top:"40%",left:"40%"})
                    .appendTo("#add2cartform");
                },
                success:function(data){
                    console.debug(data);
                    if(data.success){
                        var d=data.product;
                        /*
                        $("[name='title']").val(decodeURIComponent((typeof d.title!="undefined")?d.title:""));
                        $("[name='sku']").val((typeof d.sku!="undefined")?d.sku:"");
                        $("[name='amount']").val((typeof d.price!="undefined")?d.price:"");
                        */
                        $(".url-field .external-link").remove();
                        $(".url-field").append('<a class="external-link" href="'+$v+'" target="__blank">Перейти по ссылке</a>');
                        $("[name='img']").val((typeof d.img!="undefined")?d.img:"");
                        $("[name='currency']").val(data.currency);
                        $(".after-url").slideDown();
                        $("[data-value='"+data.currency+"']").click();

                        var itm = d,g="<div class=\"row\" id=\"cartItem-"+itm.product_id+"\" data-ref=\""+$v+"\">";
                        var vars = "";
                        for(var v in itm.variations){
                            vars+=v+" "+itm.variations[v];
                        }
                        g+='<div class="image col-xs-6 col-sm-6 col-md-4 col-lg-4" >';
                        g+='<img height="100px" src="'+itm.img+'" alt="'+itm.title+'">';
                        g+='</div>';
                        g+='<div class="name col-xs-6 col-sm-6 col-md-8 col-lg-8">';
                        if(d.title!=null&&d.title!="undefined")g+='<div class="row"><strong>Наименование:</strong><br /><a class="fill-data" title="Копировать значение" href="javascript:fillData(\'title\',\''+d.title+'\');" data-rel="title"><i class="fa fa-copy"></i></a> '+itm.title+'</div>';
                        if(d.price!=null&&d.price!="undefined")g+='<div class="row"><strong>Цена:</strong><br /><a class="fill-data" title="Копировать значение" href="javascript:fillData(\'amount\','+d.price+');" data-rel="amount"><i class="fa fa-copy"></i></a> '+garan.number.format(itm.price,2,3,' ','.')+' '+data.currency+'</div>';
                        //if(d.sku!=null&&d.sku!="undefined")g+='<div class="row"><strong>Артикул:</strong><br /><a class="fill-data" title="Копировать значение" href="javascript:fillData(\'sku\',\''+d.sku+'\');" data-rel="sku"><i class="fa fa-copy"></i></a> '+d.sku+"</div>";
                        g+='</div></div>';
                        if(d.title!=null&&d.title!="undefined"){
                            /*$("#sugestion").html(
                                '<h2>Мы нашли по Вашей ссылке этот товар:</h2>'
                                +g
                                +'<div class="row"><a class="btn btn-default pull-right" href="javascript:fillAllData();">Копировать все данные в форму</a></div>'
                                +'<div class="message"><p>Наша система старается автоматически заполнить все необходимые поля и выбрать минимальную цену за товары. Но дополнительная проверка не помешает.</p></div>'
                            );*/
                        }

                    }
                    else{
                        $('<div class="helper-box-auto">'
                            +'<a href="#" class="helper-box-item-close"><i class="fa fa-close fa-2x"></i></a>'
                            +'<div class="helper-box-item">'
                            +data.error.message
                        +'</div></div>').appendTo("body").delay(1000).hide().click(function(){
                            $(this).hide();
                        });
                    }
                },
                complete:function(){
                    $("#add2cartform .fa-spinner").remove();
                    $("#add2cartform").css({
                        "-webkit-filter": "blur(0)",
                        "-moz-filter": "blur(0)",
                        "-o-filter":"blur(0)",
                        "-ms-filter": "blur(0)",
                        "filter": "blur(0)"
                    });
                }
            });
        });
        $("#add2cart").on("click",function(){
            var i = $("#add2cartform");
            if(!garan.form.required({form:i}))return false;
            var p = collectData(),
                c = $("[name='currency']").val();
            i.clone()
                .css({'position' : 'fixed', 'z-index' : '999'})
                .appendTo(i)
                .animate(
                {
                    opacity: 0.5,
                    top: $(".cart").offset().top,
                    left:$(".cart").offset().left,
                    width: 50,
                    height: 50
                },
                800,function() {
                    $(this).remove();
                    garan.cart.add2cart(p,c);
                    $("#add2cartform input,#add2cartform textarea").val("");
                    $("[name='quantity']").val("1");
                });
        });
        $("#forward").on("click",function(){
            garan.cart.checkout();
        });
    });
    function fillData(){
        var n =arguments[0],t=arguments[1];
        console.debug("[name='"+n+"'] = "+t);
        $("[name='"+n+"']").val(t);
    }
    function fillAllData(){
        $(".fill-data").click();
    }
</script>
@endsection
