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
        <div id="social-form" class="currency-box col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h3><i class="first">Результат</i> опроса:</h3>
        </div>
    </div>
    <div class="row">
        <div class="currency-box col-xs-12 col-sm-12 col-md-6 col-lg-6">

        </div>
        <div id="analytics-form" class="currency-box col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h3><i class="first">Добавление</i> в корзину:</h3>
        </div>
    </div>

        <script>
            $=jQuery.noConflict();
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
                        url:"/currencyupdate",
                        type:"post"
                    });
                });
                $.ajax({
                    url:'/socialresult',
                    dataType:'json',
                    success:function(d){
                        var t ={
                            m:0,
                            a:0,
                            c:0
                        }
                        for(i in d){
                            var r = d[i];
                            var j = JSON.parse(r.data);
                            if(!isNaN(parseInt(j.month)) && !isNaN(parseInt(j.amount)) ){
                                t.c=t.c+1;
                                t.m+=parseInt(j.month);
                                t.a+=parseInt(j.amount);
                            }

                        }
                        t.m = t.m/t.c;
                        t.a = t.a/t.c;
                        $("#social-form").append('<strong>Месяцы среднее</strong>: '+t.m+'<br /><strong>Сумма средняя</strong>: '+t.a.format(2,3,' ','.')+' руб.<br />Кол-во опрошенных: '+t.c);
                    }
                });
                $.ajax({
                    url:'/analyticsresult',
                    dataType:'json',
                    success:function(d){
                        var t ={
                            m:0,
                            a:0,
                            c:0
                        }
                        console.log(d);
                        $("#analytics-form").append("<table><tr><th width='20%'>Время</th><th width='20%'>IP</th><th>Товар</th></tr>");
                        for(i in d){
                            var r = d[i];
                            $("#analytics-form").append("<tr><td width='20%'>"+r.timestamp+"</td><td width='20%'>"+r.ip+"</td>><td><a target='__blank' href='"+r.value+"'>"+r.value+"</a></td></tr>");

                        }
                        $("#analytics-form").append("</table>");
                    }
                });
            });
        </script>
@endsection
