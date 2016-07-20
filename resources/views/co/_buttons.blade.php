

<div class="row">
    @if($route["back"]!=false)
        <button id="back" class="btn btn-default btn-lg pull-left">← Вернуться</button>
    @endif
    <button id="forward" class="btn btn-success btn-lg pull-right">{{$route["next"]["text"]}}</button>
</div>


<input type="hidden" id="TotalAmountHidden" name="TotalAmountHidden"/>
<input type="hidden" id="ShippingAmountHidden" name="shipping_cost" value="@if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
    @amount($deal->shipping_cost)
@endif"/>
<script>
    window.garan_submit_args= {
        form:$("#form"),
        url:"{{$route["dir"].$route["next"]["href"]}}"
    };
    $(document).ready(function(){

        $("#forward").click(function(){
            garan.form.submit(garan_submit_args);
        })
        $("#back").click(function(){
            //history.go(-1);
            document.location.href = "{{$route["dir"].$route["back"]["href"]}}";
        })
    });
</script>
