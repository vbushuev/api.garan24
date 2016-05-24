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
            <label for="txtLastName" class="control-label">Фамилия:</label>
            <input id="txtLastName" name="txtLastName" class="form-control">
        </div>
        <div class="form-group" id="PersonFirstName">
            <label for="txtFirstName" class="control-label">Ваше имя:</label>
            <input id="txtFirstName" name="txtFirstName" class="form-control">
        </div>
        <div class="form-group" id="PersonMiddleName">
            <label for="txtMiddleName" class="control-label">Отчество:</label>
            <input id="txtMiddleName" name="txtMiddleName" class="form-control">
        </div>
        <div id="DeliveryAddressContainer" class="form-group">
            <label class="control-label">Адрес доставки:</label>
            <button id="btn-boxberry-map" data-toggle="modal" data-target="#boxberry-map-modal" class="btn btn-info" style="display: none;">Выбрать пункт доставки </button>
            <textarea id="txtDeliveryAddress" name="txtDeliveryAddress" cols="20" rows="5" class="form-control"></textarea>
            <input type="hidden" id="boxberryIndex" name="boxberryIndex" value="">
        </div>
        <div class="form-group">
            <textarea id="txtComment" name="txtComment" class="form-control" placeholder="Дополнительная информация (вопросы) к заказу" rows="5"></textarea>
        </div>

    </div>

    @include("magnitolkin.cart._buttons")
</div>

@endsection
