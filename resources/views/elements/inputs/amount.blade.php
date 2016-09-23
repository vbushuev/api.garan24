<div class="input-group amount-currency input-field" {{$required or ''}}>
    <style>
        .input-field .input-group-btn{
            background-color: #f2f3f5;
            border-right: solid 1px #fff;
        }
        .input-field .input-group-btn .btn{
            background-color: #f2f3f5;
            border:none;
        }
    </style>
    <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-angle-down"></i><i class="fa fa-euro fa-fw"></i>
        </button>
        <ul class="dropdown-menu">
            <li><a data-value="EUR"><i class="fa fa-euro fa-fw"></i><span class="combo-item-value"> Евро</span></a></li>
            <li><a data-value="GBP"><i class="fa fa-gbp fa-fw"></i><span class="combo-item-value"> Фунт</span></a></li>
            <li><a data-value="USD"><i class="fa fa-usd fa-fw"></i><span class="combo-item-value"> Доллар</span></a></li>
        </ul>
    </div>
    <input name="amount" id="amount" class="form-control amount" type="number" placeholder="{{$text or 'Текст'}}" value="" {{$readonly or ''}}>
    <input type="hidden" name="currency" value="EUR" />
    <script>
        $(document).ready(function(){
            $(".amount-currency .dropdown-menu li").css("cursor","pointer").on("click",function(){
                var $t = $(this),
                    $c = $(this).parent().parent().find(".dropdown-toggle")
                    $h = $(this).parent().parent().parent().find("[name='currency']")
                    k  = $(this).find("a").attr("data-value")
                    $v = $(this).find("a .fa").get()[0].outerHTML;
                console.debug("currency changing...");
                console.debug("visible["+$c.lenth+"] = "+$v+" {"+k+" to $h"+$h.length+"}");
                $c.html('<i class="fa fa-angle-down"></i>'+$v);
                $h.val(k);
            });
        });
    </script>
</div>
