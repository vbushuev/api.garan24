@extends($viewFolder.'.layout')
@section('content')
    <h1><i class="first">Уважаемый</i> {{$deal->getCustomer()->toNameString()}}, спасибо за Ваш заказ!</h1>
    <h2 class="mail"><i class="first">Заказ</i>№ {{$deal->order->id}}</h2>
    @include($viewFolder.'.goods')
    <p class="text">
        <i class="first">В ближайшее</i> время с Вами свяжется наш менеджер для подтверждения заказа. Отследить статус доставки Вашего заказа вы можете через <a href="https://garan24.ru/myaccount/">Личный кабинет <span class="brand">Гаран24</span></a>
    </p>
    <p class="text">
        <i class="first">Оплата</i> стоимости заказа будет списана с Вашей банковской карты при поступлении заказа в ближайший к Вам пункт выдачи. Пожалуйста проверьте наличие на карте средств в сумме, достаточной для оплаты заказа.
    </p>
    <p class="bye">
        Приятного шопинга!
    </p>
@endsection
