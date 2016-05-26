@extends('magnitolkin.cart.magnitolkin')

@section('content')

<h2><span class="red">Оформление</span> заказа</h2>

<div id="cart-container">

@include('magnitolkin.cart.goods')

<div id="order-form-container">
    <div>
        <div class="page-header">
            <h3>Пожалуйста введите информацию о себе:</h3>
        </div>

        <div class="form-group">
            <label for="email" class="control-label">Электронная почта:</label>
            @include('elements.inputs.email',['text'=>'Электронная почта'])
            <!--<input id="email" name="email" class="form-control">-->
            <p class="text-muted small">Сообщив электронную почту, Вы сможете отслеживать состояние заказа.</p>
        </div>
        <div class="form-group">
            <label for="phone" class="control-label">Телефон:</label>
            @include('elements.inputs.mobile')
            <p class="text-muted small">Сообщив номер мобильного телефона, Вы сможете получать уведомления об изменении состояния заказа.</p>
        </div>
        <div class="form-group">
            @include('elements.inputs.checkbox',["name"=>"agree1","text"=>"Я согласен с Условиями использования сервиса Гаран24."])
            <p class="text-muted small">Приняв Условия, Вы присоединяетесь к <a href="https://garan24.ru/terms" target="__blank">Договору</a> на обслуживание клиентов сервиса Гаран24.</p>
        </div>
    </div>
    @include("magnitolkin.cart._buttons")
</div>

@endsection
