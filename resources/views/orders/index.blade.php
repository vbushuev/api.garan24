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
                <tr class="order status-{{$order->status}}" id="order-{{$order->order_id}}" data-ref="{{$order->order_id}}">
                    <td class="order-field">{{$order->order_id}}</td>
                    <td class="order-field">{{$order->date}}</td>
                    <td class="order-field">{{$order->status}}</td>
                    <td class="order-field">{{$order->first_name}} {{$order->fio_middle}} {{$order->last_name}}<br/><a href="tel:{{$order->shipping_phone}}">{{$order->shipping_phone}}</a></td>
                    <td class="order-field">{{$order->delivery}}</td>
                    <td class="order-field">@amount($order->shipping_cost)</td>
                    <td class="order-field">{{$order->payment}}</td>
                    <td class="order-field order-amount">@amount($order->amount)</td>
                </tr>
                <tr class="order-details-row" id="order-details-{{$order->order_id}}">
                    <td colspan="8">
                        <!--
                        new	default status
                        checkout	Клиент прошел оформление заказа
                        confirmed	default status
                        credit	Товары заказаны и выкуплены
                        delivered	Доставлено агенту
                        boxbery	Отправлено в boxberry
                        boxberyhub	Доставлено в boxberry и направляется получателю
                        shipped	Доставлено получателю
                        payed	Оплачено клиентом
                        closed	Заказ выполнен и закрыт
                        canceled	Заказ отменен
                        -->
                        <div class="order-details">
                            <div class="order-info-section">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <?php $passport = json_decode($order->passport); ?>
                                        <h3>Покупатель</h3>
                                        <p>{{$order->first_name}} {{$order->fio_middle}} {{$order->last_name}}</p>
                                        <p class="small">Паспорт: {{$passport->series}}№{{$passport->number}} Выдан: {{$passport->date}}, {{$passport->where}}</p>
                                        <p><a href="tel:{{$order->shipping_phone}}">{{$order->shipping_phone}}</a></p>
                                        <p><a href="mailto:{{$order->email}}">{{$order->email}}</a></p>
                                        <p>
                                            <h4>{{$order->delivery}}</h4>
                                            {{$order->shipping_city}}, {{$order->shipping_postcode}}
                                            {{$order->shipping_address_1}}<br />
                                            {{$order->shipping_address_2}}<br />
                                            @amount($order->shipping_cost)
                                        </p>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                        <?php $items = json_decode("[]"); ?>
                                        <h3>Состав</h3>
                                        <div class="order-items empty"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row order-action-section">
                                @if($order->status == 'new')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="canceled">Отменить</a>
                                @elseif($order->status == 'checkout')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="canceled">Отменить</a>
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="confirmed">Подтвердить заказ</a>
                                @elseif($order->status == 'confirmed')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="canceled">Отменить</a>
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="credit">Заказ выкуплен</a>
                                @elseif($order->status == 'credit')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="delivered">Доставлен Агенту</a>
                                @elseif($order->status == 'delivered')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="boxbery">Отправлено в BoxBerry</a>
                                @elseif($order->status == 'boxbery')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="boxberyhub">Доставлен в BoxBerry</a>
                                @elseif($order->status == 'boxberyhub')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="shipped">Получено получателем</a>
                                @elseif($order->status == 'shipped')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="payed">Оплачено</a>
                                @elseif($order->status == 'payed')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="closed">Закрыть</a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        <script>
            $(document).ready(function(){
                $(".order").on("click",function(){
                    var $t = $(this),
                        itemsContainer = $t.next().find(".order-items"),
                        order_id=$t.attr("data-ref");
                    if(typeof itemsContainer!= "undefined" && itemsContainer.hasClass("empty")){
                        $.ajax({
                            url:'/manager/orderitems',
                            type:"get",
                            dataType:"json",
                            data:{id:order_id},
                            beforeSend:function(){
                                itemsContainer.html('<i class="fa fa-spin fa-spinner fa-2x fa-fw"></i>')
                            },
                            success:function(d){
                                console.debug(d);
                                for(var i in d.line_items){
                                    
                                }
                            }
                        });
                    }
                    //$(".order-details-row:not(#order-details-"+$t.attr("data-ref")+")").slideUp();
                    $("#order-details-"+$t.attr("data-ref")).slideToggle();
                });
            });
        </script>
    @endif
@endsection