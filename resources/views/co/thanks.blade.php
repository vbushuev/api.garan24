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
        <p>
            <strong>Выбранный способ оплаты:</strong> {{$payment['name'] or 'Наличными при получении'}}<br />
        </p>
    </div>
    <h3><i class="first">Что</i> дальше?</h3>
    <p>
        Проверьте почту, Вам прийдет письмо с подтверждением Вашего заказа и ссылкой на Ваш Личный Кабинет.
    </p>
    <p>
        Вы можете отслеживать Ваш заказ в <a target="__blank" href="https://garan24.ru/my-account/">в личном кабинете Гаран24</a>
    </p>
    <p>
        Вы можете позвонить нам и уточнить любые оставшиеся вопросы: <a href="tel:+7 499 110 2263">+7 499 110 2263</a>
    </p>
@endsection
