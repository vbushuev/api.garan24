@extends('checkout.layout',["shop_url"=>$shop_url])

@section('content')

<h2><span class="red">Оформление</span> заказа</h2>

<!--<div id="cart-container">-->



    <div id="order-form-container">
        <div class="page-header">
            <h3>Пожалуйста введите информацию о себе: </h3>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="email" class="control-label">Электронная почта:</label>
                    @include('elements.inputs.email',['text'=>'Электронная почта','required'=>"required",'name'=>'email'])
                    <p class="text-muted small">Сообщив электронную почту, Вы сможете отслеживать состояние заказа.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="phone" class="control-label">Телефон:</label>
                    @include('elements.inputs.mobile',["text"=>"Номер мобильного телефона",'required'=>"required"])
                    <p class="text-muted small">Сообщив номер мобильного телефона, Вы сможете получать уведомления об изменении состояния заказа.</p>
                </div>
            </div>
        </div>

        <div class="form-group">
            <p class="text-muted small">
                Нажимая кнопку "Продолжить", Вы присоединяетесь к <a href="https://garan24.ru/terms" target="__blank">Договору</a> на обслуживание клиентов сервиса Гаран24.</p>
        </div>
        @include("checkout._buttons")
    </div>

<!--</div>-->
@include('checkout.goods',['goods'=>$goods])
@endsection
