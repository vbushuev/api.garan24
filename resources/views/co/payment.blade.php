@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
<input type="hidden" id="TotalAmountHidden" name="TotalAmountHidden"/>
<input type="hidden" id="ShippingAmountHidden" name="shipping_cost" value="{{$deal->shipping_cost or ''}}"/>
    <h2><i class="first">Спасибо</i> за заказ!</h2>
    <p>Ваш заказ оформлен и его уже начали собирать. В некоторых случаях с Вами свяжется наш менеджер для уточнения деталей.</p>
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
            <strong>Ваш email:</strong> {{$deal->getCustomer()->email}}<br />
        </p>
        <p>
            <strong>Ваш номер:</strong> {{$deal->getCustomer()->billing_address["phone"]}}<br />
        </p>
        <p>
            <strong>Выбранный способ доставки:</strong> {{$deal->delivery['name'] or ''}}<br />
        </p>
        <p>
            <strong>Адрес доставки:</strong> {{$deal->getCustomer()->toAddressString()}}
        </p>
    </div>
    <div class="row" style="margin:1em 0;">
        <button id="back" class="btn btn-info btn-lg pull-left">Оплатить сейчас</button>
        <button id="forward" class="btn btn-success btn-lg pull-right">Оплатить после доставки</button>
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
