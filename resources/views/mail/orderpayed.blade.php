@extends($viewFolder.'.layout')
@section('content')
    <h1><i class="first">Уважаемый</i> {{$deal->getCustomer()->toNameString()}}!</h1>
    <p class="text">
        <i class="first">C Вашей</i> карты списана оплата за заказ, сделанный Вами в магазине <a href="{{$deal->getShopUrl()}}">{{$deal->getShopUrl()}}</a>
    </p>
    <h2 class="mail"><i class="first">Заказ</i>№ {{$deal->order->id}}</h2>
    @include($viewFolder.'.goods')

    <h2 class="mail"><i class="first">Оплата</i> заказа проведена успешно. Чек:</h2>
    <!--<h3><i class="first">Чек</i> оплаты заказа:</h3>-->
    @include($viewFolder.'.cheque')
    <p class="bye">
        Приятного шопинга!
    </p>
@endsection
