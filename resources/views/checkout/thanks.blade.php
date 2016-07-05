@extends('democheckout.layout')

@section('content')
<div id="OrderingSuccessContainer">
    <div class="jumbotron">
        <div class="container">
            @if(isset($order_id))
            <h2>Заказ № <span class="red" id="OrderId">{{$order_id}}</span> оформлен!</h2>
            @endif
            <p>В ближайшее время с Вами свяжется наш менеджер для подтверждения заказа.</p>
            <p>Отследить состояние заказа, а также выполнить другие действия можно <a id="OrderPath" target="__blank" href="https://garan24.ru/my-account/">в личном кабинете Гаран24</a></a>.</p>
        </div>
    </div>
</div>
<div id="OrderingSuccessContainer2" style="display:none;">
    <div class="jumbotron">
        <div class="container">
            <h2>Уважаемый покупатель!</h2>
            <p>Вы оформили заказ.</p>
            <p>Для подтверждения заказапросим Вас указать реквизиты Вашей действующей банковской карты.</p>
            <p>
                Мы проверим Вашу карту, заблокировав на ней сумму в размере 1руб. и сразу же разблокируем ее.
            </p>
            <p>
                В случае
            </p>
        </div>
    </div>
    <div style="margin-top: 15px;">
        <button id="btnReturnToCart" class="btn btn-default btn-lg pull-left">← Вернуться в магазин</button>
        <button id="btnMakeOrder" class="btn btn-success btn-lg pull-right">Продолжить</button>
        <div class="clearfix"></div>
    </div>
</div><script>
$(document).ready(function(){
    $("#OrderingSuccessContainer").show();
});
</script>
@endsection
