
<input type="hidden" id="TotalAmountHidden" name="TotalAmountHidden"/>
<input type="hidden" id="ServiceFeeHidden" name="service-fee"/>
<input type="hidden" id="ShippingAmountHidden" name="shipping_cost" value="{{$deal->shipping_cost or ''}}"/>
<div class="row">
    @if($route["back"]!=false)
        <button id="back" class="btn btn-default btn-lg pull-left">← Вернуться</button>
    @endif
        <button id="forward" class="btn btn-success btn-lg pull-right">{{$route["next"]["text"]}}</button>
</div>

<script>
    window.garan_submit_args= {
        form:$("#form"),
        url:"{{$route["dir"].$route["next"]["href"]}}",
        type:"post"
    };
    $(document).ready(function(){

        $("#forward").click(function(){
            garan.form.submit(garan_submit_args);
        });
        $("#back").click(function(){
            history.go(-1);
            //garan_submit_args.url="{{$gobackurl or $route["dir"].$route["back"]["href"]}}";
            //garan_submit_args.type="{{$gobacktype or 'post'}}";
            //garan.form.goback(garan_submit_args);
        })
    });
</script>
