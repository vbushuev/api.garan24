@extends($viewFolder.'.layout')
@section('content')
    <h1><i class="first">Уважаемый</i> {{$deal->getCustomer()->toNameString()}}, спасибо за Ваш заказ!</h1>
    <h2 class="mail"><i class="first">Заказ</i>№ {{$deal->order->id}}</h2>
    @include($viewFolder.'.goods')
    <p class="text">
        <i class="first">В ближайшее</i> время заказ будет упакован и передан в Службу доставки.
    </p>
    <p class="text">

        <i class="first">Отследить</i> статус доставки Вашего заказа вы можете через <a href="https://garan24.ru/myaccount/">Личный кабинет <span class="brand">Гаран24</span></a>
    </p>
    <h2 class="mail"><i class="first">Оплата</i> заказа проведена успешно. Чек:</h2>
    <!--<h3><i class="first">Чек</i> оплаты заказа:</h3>-->
    @include($viewFolder.'.cheque')
    <p class="bye">
        Приятного шопинга!
    </p>
@endsection
