@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
<input type="hidden" id="TotalAmountHidden" name="TotalAmountHidden"/>
<input type="hidden" id="ShippingAmountHidden" name="shipping_cost" value="{{$deal->shipping_cost or ''}}"/>
    <!--<h2><i class="first">Спасибо</i> за заказ!</h2>-->
    <!--<p>Ваш заказ оформлен и его уже начали собирать. В некоторых случаях с Вами свяжется наш менеджер для уточнения деталей.</p>-->
    <h3><i class="first">Еще</i> раз проверьте параметры заказа:</h3>
    <div class="message">
        <p>
            <strong>Общая сумма заказа:</strong> @amount($amount)
        </p>
        @if(isset($deal->shipping_cost))
        <p>
            <strong>Включая стоимость доставки:</strong> @amount($deal->shipping_cost)<br />
        </p>
        @endif
        <p>
            <strong>Выбранный способ доставки:</strong> {{$deal->delivery['name'] or ''}}<br />
        </p>
        <p>
            <strong>Адрес доставки:</strong> {{$deal->getCustomer()->toAddressString()}}
        </p>
        <p>
            <strong>Получатель:</strong> {{$deal->getCustomer()->billing_address["last_name"]." ".$deal->getCustomer()->billing_address["first_name"]." ".$deal->getCustomer()->fio_middle}}
            {{", паспорт: ".$deal->getCustomer()->passport["series"]." №".$deal->getCustomer()->passport["number"]." выдан:".$deal->getCustomer()->passport["date"].", ".$deal->getCustomer()->passport["where"]}}
        </p>
        <p>
            <strong>Email:</strong> {{$deal->getCustomer()->email}}<br />
        </p>
        <p>
            <strong>Телефон:</strong> @telephone($deal->getCustomer()->billing_address["phone"])<br />
        </p>
    </div>
    <div class="row" style="margin:1em 0;">
        <button id="back" class="btn btn-info btn-lg pull-left">Оплатить сейчас</button>
        <!--<button id="forward" class="btn btn-success btn-lg pull-right">Оплатить после доставки</button>-->
        <button id="forward" class="btn btn-success btn-lg pull-right">Оплатить потом</button>
        <input id="payment_id" name="payment_id" type="hidden"/>
        <script>
            window.garan_submit_args= {
                form:$("#form"),
                url:"{{$route["dir"].$route["next"]["href"]}}"
            };
            $(document).ready(function(){
                $("#forward").click(function(){
                    $("#payment_id").val(1);
                    garan.form.submit(garan_submit_args);
                })
                $("#back").click(function(){
                    $("#payment_id").val(2);
                    garan.form.submit(garan_submit_args);
                })
            });
        </script>
    </div>
@endsection
