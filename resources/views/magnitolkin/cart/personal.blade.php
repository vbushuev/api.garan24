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
            <h3>Обязательно укажите:</h3>
        </div>
        <div class="form-group" id="PersonLastName">
            <label for="fio['last']" class="control-label">Фамилия:</label>
            @include('elements.inputs.text',["name"=>"fio['last']","text"=>"Фамилия"])
        </div>
        <div class="form-group" id="PersonFirstName">
            <label for="fio['first']" class="control-label">Ваше имя:</label>
            @include('elements.inputs.text',["name"=>"fio['first']","text"=>"Имя"])
        </div>
        <div class="form-group" id="PersonMiddleName">
            <label for="fio['middle']" class="control-label">Отчество:</label>
            @include('elements.inputs.text',["name"=>"fio['middle']","text"=>"Отчество"])
        </div>
        <div id="DeliveryAddressContainer" class="form-group">
            <label class="control-label">Адрес доставки:</label>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        @include('elements.inputs.combo',[
                            "required" => "required",
                            "name"=>"billing['country']",
                            "text"=>"Страна",
                            "values"=>[
                                ["key"=>"ru","value"=>"Россия"],
                                ["key"=>"br","value"=>"Белоруссия"],
                                ["key"=>"kz","value"=>"Казахстан"],
                                "divider",
                                ["key"=>"uk","value"=>"United Kingdom"],
                                ["key"=>"us","value"=>"United States"],
                                ["key"=>"lx","value"=>"Luxemburg"]
                            ]
                        ])
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        @include('elements.inputs.text',["name"=>"billing['state']","text"=>"Район"])
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        @include('elements.inputs.text',["name"=>"billing['city']","text"=>"Город"])
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        @include('elements.inputs.text',["name"=>"billing['zip']","text"=>"Почтовый индекс"])
                    </div>
                </div>
            </div>
            <div class="form-group">
                @include('elements.inputs.text',["name"=>"billing['address1']","text"=>"Адрес"])
            </div>
            <!--
            <textarea id="billing_address" name="billing_address" cols="20" rows="5" class="form-control"></textarea>
        -->
        </div>
        <div class="form-group">
            <textarea id="txtComment" name="txtComment" class="form-control" placeholder="Дополнительная информация (вопросы) к заказу" rows="5"></textarea>
        </div>

    </div>

    @include("magnitolkin.cart._buttons")
</div>

@endsection
