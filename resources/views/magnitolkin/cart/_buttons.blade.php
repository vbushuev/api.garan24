<div style="margin-top: 15px;">
    @if($route["back"]!=false)
        <button id="btnReturnToCart" class="btn btn-default btn-lg pull-left">← Вернуться</button>
    @endif
    <button id="btnMakeOrder" class="btn btn-success btn-lg pull-right">{{$route["next"]["text"]}}</button>
    <div class="clearfix"></div>
</div>
<script>
    $(document).ready(function(){
        var a= {
            form:$("#order-form-container"),
            url:"{{$route["next"]["href"]}}"
        };
        $("#order-form-container").show();
        $("#btnMakeOrder").click(function(){
            garan.form.submit(a);
            //document.location.href = "{{$route["next"]["href"]}}";
        })
        $("#btnReturnToCart").click(function(){
            //document.location.href = "../magnitolkin";
            document.location.href = "{{$route["back"]["href"]}}";
        })
    });
</script>
