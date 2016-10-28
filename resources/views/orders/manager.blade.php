@extends('orders.layout')
@section('content')
    <div class="row">
        <div id="currency-form" class="currency-box col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h3><i class="first">Курсы</i> валют: </h3>
            {{ csrf_field() }}
            <div class="form-group">@include('elements.inputs.input',['name'=>'eur','icon'=>'euro','id'=>'currency-euro'])</div>
            <div class="form-group">@include('elements.inputs.input',['name'=>'gbp','icon'=>'gbp','id'=>'currency-gbp'])</div>
            <div class="form-group">@include('elements.inputs.input',['name'=>'usd','icon'=>'usd','id'=>'currency-usd'])</div>
            <div class="form-group">@include('elements.inputs.input',['name'=>'rub','icon'=>'rub','id'=>'currency-rub'])</div>
            <div class="row">
                <button id="currency-save" class="btn btn-success btn-lg pull-right">Сохранить</button>
            </div>
        </div>

    </div>
        <script>
            $(document).ready(function(){
                garan.currency.get(function(d){
                    console.debug(d);
                    $("#currency-euro").val(garan.currency.EUR);
                    $("#currency-gbp").val(garan.currency.GBP);
                    $("#currency-usd").val(garan.currency.USD);
                    $("#currency-rub").val(garan.currency.RUB);
                });
                $("#currency-save").on("click",function(){
                    garan.form.submit({
                        form:$("#currency-form"),
                        url:"/currency/update",
                        type:"post"
                    });
                });
            });
        </script>
@endsection
