@extends($viewFolder.'.layout')
@section('content')
    <h1 style="font-size: 20pt;text-align: center;line-height: 2em;border-bottom: dotted 1px #557da1;font-weight: 500;text-transform: uppercase;margin-bottom: 1em;"><i style="font-weight: 700;font-style: normal;font-size: inherit;">Уважаемый</i> покупатель!</h1>
    <div style="text-indent: 2em;">
        <i style="font-weight: 700;font-style: normal;font-size: inherit;">Вы</i> сделали заказ в магазине нашего партнера <a href="{{$deal->getShopUrl()}}">{{$deal->getShopUrl()}}</a>, и стали участником сервиса комфортных покупок <span style="color: #557da1;font-weight: 700;">GauzyMALL</span>.
    </div>
    <div style="text-indent: 2em;">
        <i style="font-weight: 700;font-style: normal;font-size: inherit;">Используя</i> <a href="http://gauzymall.com/myaccount/">Личный кабинет <span style="color: #557da1;font-weight: 700;text-transform: uppercase;">GauzyMALL</span></a>, Вы можете отслеживать статус доставки заказа. При покупках у наших партнеров Вам не придется повторно вводить данные для доставки и оплаты заказа.
    </div>
    <div style="text-indent: 2em;">
        <i style="font-weight: 700;font-style: normal;font-size: inherit;">Уже</i> сейчас, как участник сервиса <span style="color: #557da1;font-weight: 700;text-transform: uppercase;">GauzyMALL</span>, Вы можете оплачивать заказ банковской картой при его получении. В дальнейшем мы предложим Вам другие способы оплаты, в том числе, с отсрочкой или рассрочкой платежа.
    </div>

    <h2 style="font-size: 18pt;font-weight: 500;text-transform: uppercase;margin-bottom: 1em;background-color: #557da1;color: #fff;text-align: center;height: 3em;line-height: 3em;"><i style="font-weight: 700;font-style: normal;font-size: inherit;">Вход</i> в личный кабинет</h2>
    <div style="padding: 1em;line-height: 2em;font-size: 110%;">
        Страница: <a href="http://gauzymall.com/my-account">http://gauzymall.com/my-account</a><br />
        Ваш логин: <strong>{{$deal->getCustomer()->email}}</strong><br />
        Ваш пароль: <strong>номер Вашего мобильного телефона</strong> (<span class="small">Например:+79991112255</span>)
    </div>
    <div style="margin: 1em auto;text-align: center;font-size: 110%;">
        Успешных покупок!
    </div>
@endsection
