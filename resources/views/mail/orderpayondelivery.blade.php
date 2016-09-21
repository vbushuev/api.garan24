@extends($viewFolder.'.layout')
@section('content')
    <h1 style="font-size: 20pt;text-align: center;line-height: 2em;border-bottom: dotted 1px #557da1;font-weight: 500;margin-bottom: 1em;"><i style="font-weight: 700;font-style: normal;font-size: inherit;">Уважаемый</i> {{$deal->getCustomer()->toNameString()}}, спасибо за Ваш заказ!</h1>
    <h2 style="font-size: 18pt;font-weight: 500;margin-bottom: 1em;background-color: #557da1;color: #fff;text-align: center;height: 3em;line-height: 3em;"><i style="font-weight: 700;font-style: normal;font-size: inherit;">Заказ</i>№ {{$deal->order->id}}</h2>
    @include($viewFolder.'.goods')
    <div style="text-indent: 2em;">
        <i style="font-weight: 700;font-style: normal;font-size: inherit;">В ближайшее</i> время с Вами свяжется наш менеджер для подтверждения заказа. Отследить статус доставки Вашего заказа вы можете через <a href="http://gauzymall.com/myaccount/">Личный кабинет <span style="color: #557da1;font-weight: 700;">GauzyMALL</span></a>
    </div>
    <div style="text-indent: 2em;">
        <i style="font-weight: 700;font-style: normal;font-size: inherit;">Оплата</i> стоимости заказа будет списана с Вашей банковской карты при поступлении заказа в ближайший к Вам пункт выдачи. Пожалуйста проверьте наличие на карте средств в сумме, достаточной для оплаты заказа.
    </div>
    <div style="margin: 1em auto;text-align: center;font-size: 110%;">
        Приятного шопинга!
    </div>
@endsection
