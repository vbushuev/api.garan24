@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
@include($viewFolder.'.goods',['goods'=>$goods])
<div id="form" class="form col-xs-12 col-sm-12 col-md-8 col-lg-8">
    @if(isset($order_id))
    <h2><i class="first">Заказ</i> №<span class="red" id="OrderId">{{$order_id}}</span> сформирован</h2>
    @endif
    <style>
        .jumbotron .small {font-size:12pt;}
    </style>
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
                <strong>Общая сумма заказа:</strong> @amount($amount)
            </p>
            @if(isset($shipping_cost))
            <p>
                <strong>Включая стоимость доставки:</strong> @amount($shipping_cost)<br />
            </p>
            @endif
            <p>
                <strong>Выбранный способ доставки:</strong> {{$delivery['name'] or 'Почтой России'}}<br />
            </p>
            <p>
                <strong>Адрес доставки:</strong> {{$address}}
            </p>
            <p>
                <strong>Выбранный способ оплаты:</strong> {{$payment['name'] or 'Наличными при получении'}}<br />
            </p>
            <!--<p class="text-muted small">{{$payment['desc'] or 'Чтобы использовать выбранный способ оплаты, введите реквизиты своей банковской карты. Для проверки карты на ней будет заблокирован 1 рубль, который сразу же будет возвращен. Если Вы впоследствии откажетесь от получения заказа не по вине магазина, с Вашей карты будет списана стоимость доставки заказа.'}}</p>-->
            <p class="text-muted small">
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
        </div>
    </div>
    @endif
    @include("$viewFolder._buttons")
</div>

@endsection
