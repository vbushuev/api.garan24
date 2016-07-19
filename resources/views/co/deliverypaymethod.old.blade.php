@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
<style>
    .description, .description_shot {
        display: none;
        border: solid 1px rgba(0,0,0,.2);
        color: rgba(0,0,0,.6);
        font-size: 100%;
        padding: .4em;
        margin: 0 0 0 1.4em;
    }
</style>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h3><i class="first">Способ</i> получения <i class="fa fa-bus" aria-hidden="true"></i></h3>
            <div id="delivery_types" class="list-group">

                @foreach($delivery as $dt)
                    <a href="#" class="list-group-item">{{$dt["name"]}}</a>
                    <!--<div class="radio">
                        <label class="selected">
                            <input type="radio" id="delivery_type_{{$dt["id"]}}" checked="checked" name="delivery_types" onclick="javascript:optionClickDeliveryType({{$dt["id"]}}, this)" data-delivery-id="{{$dt["id"]}}">
                            {{$dt["name"]}}<br />
                            @if($dt["id"]==4)
                                @include($viewFolder.'._boxberry')
                            @elseif($dt["id"]==6)
                                @include($viewFolder.'.address')
                            @endif
                        </label>
                        <div class="description" style="display:none;">
                            {{{$dt["desc"]}}}<br/>
                            <strong>Срок</strong> - до {{$dt["timelaps"]}} часов<br />
                            <strong>Стоимость</strong> - {{$dt["price"]}}руб.
                        </div>-->

                @endforeach
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h3><i class="first">Способ</i> оплаты <i class="fa fa-credit-card" aria-hidden="true"></i></h3>

            <div id="payment_types" class="list-group">
                @foreach($payments as $pt)
                    <a href="#" class="list-group-item">{{$dt["name"]}}</a>
                    <!--<div class="radio">
                        <label class="selected">
                            <input type="radio" id="payment_type_{{$pt["id"]}}" checked="checked" name="payment_types" onclick="javascript:optionClickPaymentType({{$pt["id"]}}, this)" data-payment-id="{{$pt["id"]}}">
                            {{$pt["name"]}}
                        </label>
                        <div class="description description_shot" style="display:none;">
                            {{$pt["desc"]}}
                        </div>
                    </div>-->
                @endforeach
            </div>
        </div>
        <input type="hidden" id="TotalAmountHidden" name="TotalAmountHidden"/>
        <input type="hidden" id="ShippingAmountHidden" name="shipping_cost"/>
        <input type="hidden" id="delivery_type_id" name="delivery_type_id" />
        <input type="hidden" id="delivery_type_name" name="delivery_type_name" />
        <input type="hidden" id="delivery_type_desc" name="delivery_type_desc" />
        <input type="hidden" id="payment_type_id" name="payment_type_id" />
        <input type="hidden" id="payment_type_name" name="payment_type_name" />
        <input type="hidden" id="payment_type_desc" name="payment_type_desc" />

    </div>
    @include("$viewFolder._buttons")
    <script>
        var currentPay  = 2;
        var currentDelivery = 1;
        var currentDescription = '.description';
        //$("#forward").disable();

        $("#forward").prop('disabled', true);

        function _calculateTotal(i){
            //var totalDelivery = isNaN(garan.delivery.list[i].cost)?garan.delivery.list[i].cost:parseInt(garan.delivery.list[i].cost);
            var totalDelivery = parseInt($("#totalDeliveryPrice").text());
            console.debug("calculateTotal delivery cost = "+totalDelivery);
            var total = 0;
            $(".amount").each(function(){
                total+=parseInt($(this).text().replace(/\s+/ig,''));
            });
            total += (isNaN(totalDelivery))?0:totalDelivery;
            //$("#totalDeliveryPrice").html(isNaN(totalDelivery)?totalDelivery:totalDelivery.format(0,3,' ','.')+" руб.");
            $("#lblTotalPrice").html(total.format(0,3,' ','.'));
            $("#TotalAmountHidden").val(total);
        }
        function optionClickPaymentType(i,t){
            currentPay = i;
            currentDescription = (currentDelivery==0 || currentDelivery==1 || currentDelivery==2 || currentDelivery==5 )?".description_shot":'.description';
            $("#payment_types input:checked").parent().parent().parent().find(".description,.description_shot").hide();
            $("#payment_types input:checked").parent().parent().parent().find("label").removeClass("selected");
            $("#payment_types input:checked").parent().addClass("selected").parent().find(currentDescription).show();

            //window.garan_submit_args.url = (i==0)?"../$viewFolder.passport":"../$viewFolder.card";
            setHiddenValues();
        }
        function optionClickDeliveryType(i,t){
            currentDelivery = i;
            currentDescription = (currentDelivery==0 || currentDelivery==1 || currentDelivery==2 || currentDelivery==5 )?".description_shot":'.description';
            $("#payment_types .description:visible,#payment_types .description_shot:visible").hide().parent().find(currentDescription).show();
            $("#delivery_types input:checked").parent().parent().parent().find(".description").hide();
            $("#delivery_types input:checked").parent().parent().parent().find("label").removeClass("selected");
            $("#delivery_types input:checked").parent().addClass("selected").parent().find(".description").show();
            if(i==2){$("[data-payment-id=0]").parent().parent().hide();optionClickPaymentType(2,"[data-payment-id=2]");}
            else {$("[data-payment-id=0]").parent().parent().show();}
            if(i==3){$("[data-payment-id=1]").parent().parent().hide();optionClickPaymentType(2,"[data-payment-id=2]");}
            else $("[data-payment-id=1]").parent().parent().show();
            calculateTotal(i);
            $(".delivery-row").show();
            //window.garan_submit_args.url = (i==0 || i==1 || i==5)?"../$viewFolder.thanks":"../$viewFolder.card";
            setHiddenValues();

        }
        function setHiddenValues(){
            var selected_payment = $("#payment_types input:checked");
            var selected_delivery = $("#delivery_types input:checked");
            $("#delivery_type_id").val(selected_delivery.attr("data-delivery-id"));
            $("#delivery_type_name").val(selected_delivery.parent().text().replace(/(.+?)\</,"$1"));
            $("#delivery_type_desc").val(selected_delivery.parent().parent().find(".description").html());
            console.debug(selected_delivery.parent().text().replace(/(.+?)\</,"$1"));

            $("#payment_type_id").val(selected_payment.attr("data-payment-id"));
            $("#payment_type_name").val(selected_payment.parent().text());
            $("#payment_type_desc").val(selected_payment.parent().parent().find(currentDescription).html());
        }
        $(document).ready(function(){
            optionClickPaymentType({{$payments[0]["id"] or '2'}});
            optionClickDeliveryType({{$delivery[0]["id"] or '4'}});
            //calculateTotal(1);
        });
    </script>
@endsection
