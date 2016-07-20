@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
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
            <strong>Выбранный способ доставки:</strong> {{$delivery['name'] or 'Почтой России'}}<br />
        </p>
        <p>
            <strong>Адрес доставки:</strong> {{$address}}
        </p>
    </div>
    <div class="row" style="margin:1em 0;">
        <button id="back" class="btn btn-info btn-lg pull-left">Оплатить сейчас</button>
        <button id="forward" class="btn btn-success btn-lg pull-right">Оплатить после доставки</button>
        <input id="payment_id" name="payment_id" type="hidden"/>
        <script>
            $("#back").on("click",function(){$("#payment_id").val(1);});
            $("#forward").on("click",function(){$("#payment_id").val(6);});
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
                    garan.form.submit(garan_submit_args);
                })
            });
        </script>
    </div>
    <h3><i class="first">Что</i> дальше?</h3>
    <p>
        Проверьте почту, Вам прийдет письмо от Гаран24 с подтверждением Вашего заказа и ссылкой на Ваш Личный Кабинет.
    </p>
    <p>
        Вы можете отслеживать Ваш заказ в <a target="__blank" href="https://garan24.ru/my-account/">в личном кабинете Гаран24</a>
    </p>
    <p>
        Вы можете позвонить нам и уточнить любые оставшиеся вопросы: <a href="tel:+7 499 110 2263">+7 499 110 2263</a>
    </p>
@endsection
