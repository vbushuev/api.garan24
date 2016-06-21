<div style="margin-top: 15px;">
    @if($route["back"]!=false)
        <button id="btnReturnToCart" class="btn btn-default btn-lg pull-left">← Вернуться</button>
    @endif
    <button id="btnMakeOrder" class="btn btn-success btn-lg pull-right">{{$route["next"]["text"]}}</button>
    <div class="clearfix"></div>
</div>
<script>
    window.garan_submit_args= {
        form:$("#order-form-container"),
        url:"{{$route["next"]["href"]}}"
    };
    $(document).ready(function(){

        $("#order-form-container").show();
        $("#btnMakeOrder").click(function(){
            garan.form.submit(garan_submit_args);
            //document.location.href = "{{$route["next"]["href"]}}";
        })
        $("#btnReturnToCart").click(function(){
            //document.location.href = "../magnitolkin";
            document.location.href = "{{$route["back"]["href"]}}";
        })
    });
</script>
