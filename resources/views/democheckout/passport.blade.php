@extends('magnitolkin.cart.magnitolkin')

@section('content')
<!--<script>
var ymaps = {init:function(){}},Order={getCartItems:function(){return [];}};

</script>-->
<h2><span class="red">Оформление</span> заказа</h2>

<div id="cart-container">
    @include('magnitolkin.cart.goods')
<div id="order-form-container">
    <div>
        <div class="page-header">
            <h3>Ваши паспортные данные:</h3>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group" id="Passport">
                    <label for="passport[series]" class="control-label">Серия и номер</label>
                    @include('elements.inputs.passport')
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group" id="PassportDate">
                    <label for="passport['date']" class="control-label">Дата выдачи:</label>
                    @include('elements.inputs.date',['name'=>'passport["date"]'])
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group" id="PassportLocale">
                    <label for="passport['where']" class="control-label">Кем выдан:</label>
                    <textarea id="passport['where']" name="passport['where']" class="form-control" placeholder="" rows="3">
                    </textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group" id="PassportCode">
                    <label for="passport['code']" class="control-label">Код подразделения:</label>
                    @include('elements.inputs.passportcode',['name'=>'passport["code"]'])
                </div>
            </div>

        </div>

        <div class="form-group" id="PassportAgree">
            @include('elements.inputs.checkbox',["name"=>"agree1","text"=>"Я согласен с условиями."])
            <p class="text-muted small">Указав согласие, Вы принимаете <a href="https://garan24.ru/terms" target="__blank">соглашение</a> Гаран24 на обрботку Ваших данных.</p>
        </div>
    </div>

    @include("magnitolkin.cart._buttons")
</div>

@endsection
