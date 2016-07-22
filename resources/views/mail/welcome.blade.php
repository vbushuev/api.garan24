@extends($viewFolder.'.layout')
@section('content')
    <h1><i class="first">Уважаемый</i> покупатель!</h1>
    <p class="text">
        <i class="first">Вы</i> сделали заказ в магазине нашего партнера <a href="{{$deal->getShopUrl()}}">{{$deal->getShopUrl()}}</a>, и стали участником сервиса комфортных покупок <span class="brand">Гаран24</span>.
    </p>
    <p class="text">
        <i class="first">Используя</i> <a href="https://garan24.ru/myaccount/">Личный кабинет <span class="brand">Гаран24</span></a>, Вы можете отслеживать статус доставки заказа. При покупках у наших партнеров Вам не придется повторно вводить данные для доставки и оплаты заказа.
    </p>
    <p class="text">
        <i class="first">Уже</i> сейчас, как участник сервиса <span class="brand">Гаран24</span>, Вы можете оплачивать заказ банковской картой при его получении. В дальнейшем мы предложим Вам другие способы оплаты, в том числе, с отсрочкой или рассрочкой платежа.
    </p>

    <h2 class="mail"><i class="first">Вход</i> в личный кабинет</h2>
    <p class="data">
        Страница: <a href="https://garan24.ru/my-account">https://garan24.ru/my-account</a><br />
        Ваш логин: <strong>{{$deal->getCustomer()->email}}</strong><br />
        Ваш пароль: <strong>номер Вашего мобильного телефона</strong> (<span class="small">Например:+79991112255</span>)
    </p>
    <p class="bye">
        Успешных покупок!
    </p>
@endsection
