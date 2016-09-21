@extends($viewFolder.'.layout')
@section('content')
    <h1 style="font-size: 20pt;text-align: center;line-height: 2em;border-bottom: dotted 1px #557da1;font-weight: 500;margin-bottom: 1em;"><i style="font-weight: 700;font-style: normal;font-size: inherit;">Уважаемый</i> {{$deal->getCustomer()->toNameString()}}!</h1>
    <div style="text-indent: 2em;">
        <i style="font-weight: 700;font-style: normal;font-size: inherit;">C Вашей</i> карты списана оплата за заказ, сделанный Вами в магазине <a href="{{$deal->getShopUrl()}}">{{$deal->getShopUrl()}}</a>
    </div>
    <h2 style="font-size: 18pt;font-weight: 500;margin-bottom: 1em;background-color: #557da1;color: #fff;text-align: center;height: 3em;line-height: 3em;"><i style="font-weight: 700;font-style: normal;font-size: inherit;">Заказ</i>№ {{$deal->order->id}}</h2>
    @include($viewFolder.'.goods')

    <h2 style="font-size: 18pt;font-weight: 500;margin-bottom: 1em;background-color: #557da1;color: #fff;text-align: center;height: 3em;line-height: 3em;"><i style="font-weight: 700;font-style: normal;font-size: inherit;">Оплата</i> заказа проведена успешно. Чек:</h2>
    <!--<h3 style="font-size: 16pt;padding-right: 2em;font-weight: 500;margin-bottom: 1em;"><i style="font-weight: 700;font-style: normal;font-size: inherit;">Чек</i> оплаты заказа:</h3>-->
    @include($viewFolder.'.cheque')
    <div style="margin: 1em auto;text-align: center;font-size: 110%;">
        Приятного шопинга!
    </div>
@endsection
