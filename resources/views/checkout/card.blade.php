@extends('checkout.layout')

@section('content')
<!--<script>
var ymaps = {init:function(){}},Order={getCartItems:function(){return [];}};

</script>-->
@if(isset($order_id))
<h2>Заказ №<span class="red" id="OrderId">{{$order_id}}</span> сформирован</h2>
@endif
<style>
    .jumbotron .small {font-size:12pt;}
</style>
<div id="cart-container">
    @if(isset($delivery))
    <div class="jumbotron" style="font-size:12pt;">
        <div class="container">
            <p>
                <strong>Вы заказали:</strong>
                <table style="width:100%;border:solid 1px rgba(0,0,0,.2);font-size:12pt;">
                    @if(isset($goods))
                        @foreach($goods as $good)
                            <tr>
                                <td style="padding:.4em;">
                                    {{$good["title"]}}
                                </td>
                                <td style="padding:.4em;">
                                    {{$good["quantity"]}} шт.
                                </td>
                            </tr>
                        @endforeach

                    @endif
                </table>
            </p>

            <p>
                <strong>Адрес доставки:</strong> {{$address}}
            </p>
            <p>
                <strong>Выбранный способ доставки:</strong> {{$delivery['name'] or 'Почтой России'}}<br />
            </p>
            <p>
                <strong>Выбранный способ оплаты:</strong> {{$payment['name'] or 'Наличными при получении'}}<br />
            </p>
            <p class="text-muted small">{{$payment['desc'] or 'Чтобы использовать выбранный способ оплаты, введите реквизиты своей банковской карты. Для проверки карты на ней будет заблокирован 1 рубль, который сразу же будет возвращен. Если Вы впоследствии откажетесь от получения заказа не по вине магазина, с Вашей карты будет списана стоимость доставки заказа.'}}</p>
        </div>
    </div>
    @endif
<div id="order-form-container">
    <div>
        <div class="page-header">
            <h3>Введите реквизиты Вашей карты:</h3>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group" id="Pan">
                    <label for="pan" class="control-label">Номер карты</label>
                    @include('elements.inputs.pan')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group" id="ExpireDate">
                    <label for="expiredate" class="control-label">Срок действия:</label>
                    @include('elements.inputs.expiredate')
                    <p class="text-muted small">В формате MM/ГГ. Как написано на карте.</p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group" id="CVV">
                    <label for="cvv" class="control-label">CVV2/CVC2:</label>
                    @include('elements.inputs.cvv',['name'=>'passport["code"]'])
                    <p class="text-muted small">3 цифры на обороте карты.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group" id="Cardholder">
                    <label for="cardholder" class="control-label">Имя Владелца карты:</label>
                    @include('elements.inputs.text',['name'=>'cardholder','class'=>'cardholder','icon'=>'user','text'=>'CARD HOLDER'])
                    <p class="text-muted small">Латинскими буквами</p>
                </div>
            </div>
        </div>
        <div class="form-group" id="PassportAgree">
            @include('elements.inputs.checkbox',["name"=>"agree1","checked"=>"checked","text"=>"Сохранить мою карту в сервисе Гаран24."])
            <p class="text-muted small">
                <a href="https://garan24.ru/terms" target="__blank">
                    <i class="fa fa-lock fa-fw"></i>Безопасность хранения карты в системе Гаран24</a>.</p>
        </div>
    </div>

    @include("checkout._buttons")
</div>

@endsection
