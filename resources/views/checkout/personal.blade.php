@extends('checkout.layout')

@section('content')
<!--<script>
var ymaps = {init:function(){}},Order={getCartItems:function(){return [];}};

</script>-->
<h2><span class="red">Оформление</span> заказа</h2>

<div id="cart-container">
@include('checkout.goods',['goods'=>$goods])

<div id="order-form-container">
    <div>
        <div class="page-header">
            <h3>Обязательно укажите:</h3>
        </div>
        <div class="form-group" id="PersonLastName">
            <label for="fio['last']" class="control-label">Фамилия:</label>
            @include('elements.inputs.text',["name"=>"fio[last]","text"=>"Фамилия",'required'=>"required","value"=>$customer["billing_address"]["last_name"]])
        </div>
        <div class="form-group" id="PersonFirstName">
            <label for="fio['first']" class="control-label">Ваше имя:</label>
            @include('elements.inputs.text',["name"=>"fio[first]","text"=>"Имя",'required'=>"required","value"=>$customer["billing_address"]["first_name"]])
        </div>
        <div class="form-group" id="PersonMiddleName">
            <label for="fio['middle']" class="control-label">Отчество:</label>
            @include('elements.inputs.text',["name"=>"fio[middle]","text"=>"Отчество","value"=>""])
        </div>
        <div id="DeliveryAddressContainer" class="form-group">
            <label class="control-label">Ваш адрес:</label>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        @include('elements.inputs.combo',[
                            "required" => "required",
                            "name"=>"billing[country]",
                            "text"=>"Страна",
                            "values"=>[
                                ["key"=>"RU","value"=>"Россия"],
                                ["key"=>"BY","value"=>"Белоруссия"],
                                ["key"=>"KZ","value"=>"Казахстан"],
                                "divider",
                                ["key"=>"GB","value"=>"United Kingdom"],
                                ["key"=>"US","value"=>"United States"],
                                ["key"=>"LX","value"=>"Luxemburg"]
                            ]
                        ])
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        @include('elements.inputs.text',["name"=>"billing[state]","text"=>"Район","value"=>$customer["billing_address"]["state"]])
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        @include('elements.inputs.text',["name"=>"billing[city]","text"=>"Город","value"=>$customer["billing_address"]["city"]])
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        @include('elements.inputs.text',["name"=>"billing[postcode]","text"=>"Почтовый индекс","value"=>$customer["billing_address"]["postcode"]])
                    </div>
                </div>
            </div>
            <div class="form-group">
                @include('elements.inputs.text',["name"=>"billing[address_1]","text"=>"Адрес","value"=>$customer["billing_address"]["address_1"]])
            </div>
            <!--
            <textarea id="billing_address" name="billing_address" cols="20" rows="5" class="form-control"></textarea>
        -->
        </div>
        <div class="form-group">
            <textarea id="txtComment" name="txtComment" class="form-control" placeholder="Дополнительная информация (вопросы) к заказу" rows="5"></textarea>
        </div>

    </div>

    @include("checkout._buttons")
</div>

@endsection
