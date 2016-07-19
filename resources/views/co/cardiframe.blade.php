@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
@include($viewFolder.'.goods',['goods'=>$goods])
<div id="form" class="form col-xs-12 col-sm-12 col-md-8 col-lg-8">
    <p>
        <strong>Выбранный способ оплаты:</strong> {{$deal->payment['name'] or 'Наличными при получении'}}<br />
    </p>
    <p class="message">
        @if($payment['id'] == 1 )
            Вы оплатите заказ картой в момент получения курьеру или сотруднику пункта выдачи заказов. Чтобы использовать этот способ оплаты, введите реквизиты своей банковской карты. Для проверки карты на ней будет заблокирован 1 рубль, который сразу же будет возвращен. Если Вы впоследствии откажетесь от получения заказа не по вине магазина, с Вашей карты будет списана стоимость доставки заказа.
        @else
            Вам нужно указать реквизиты своей банковской карты для оплаты полной стоимости заказа.
        @endif
    </p>
    <p class="text-muted" style="color:rgba(197,17,98 ,1);">
        @if (session('status'))
            {{ session('status') }}
        @endif
    </p>
    <iframe src="{{$payneteasy_url}}" id="payneteasy_iframe" width="100%" height="360" style="border:none;"></iframe>
    <script>
        $("#payneteasy_iframe").on("load",function(){
            var t = this,$t = $(this);
            console.debug("iframe loaded");
            console.debug($t.html())
        });
    </script>
    @include("$viewFolder._buttons")
</div>
@endsection
