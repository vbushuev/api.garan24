@extends('orders.layout')
@section('content')
    @if(isset($orders))
        <table class="orders">
            <tr class="order-header">
                <th class="header-field">#</th>
                <th class="header-field">Дата</th>
                <th class="header-field">Статус</th>
                <th class="header-field">Покупатель</th>
                <th class="header-field">Доставка</th>
                <th class="header-field">Сумма доставки</th>
                <th class="header-field">Оплата</th>
                <th class="header-field">Сумма заказа</th>
            </tr>
            @foreach($orders as $order)
                <tr class="order status-{{$order->status}}" id="order-{{$order->id}}" data-ref="{{$order->id}}">
                    <td class="order-field">{{$order->order_id}}</td>
                    <td class="order-field">{{$order->date}}</td>
                    <td class="order-field">{{$order->status}}</td>
                    <td class="order-field">{{$order->user_id}}</td>
                    <td class="order-field">{{$order->delivery}}</td>
                    <td class="order-field">@amount($order->shipping_cost)</td>
                    <td class="order-field">{{$order->payment}}</td>
                    <td class="order-field order-amount">@amount($order->amount)</td>
                </tr>
                <tr class="order-details" id="order-details-{{$order->id}}">
                    <td colspan="8">
                        <div>
                            <a class="btn btn-default">D</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        <script>
            $(document).ready(function(){
                $(".order").on("click",function(){
                    var $t = $(this);
                    console.debug("show details for #"+$t.attr("data-ref"));
                    $("#order-details-"+$t.attr("data-ref")).slideDown();
                });
            });
        </script>
    @endif
@endsection
