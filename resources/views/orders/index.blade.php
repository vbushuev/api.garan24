@extends('orders.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 statistics"></div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 links">
            <!-- Single button -->
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Статус <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="/">Рабочие</a></li>
                    <li role="separator" class="divider"></li>
                    @foreach($statuses as $status=>$desc)
                    <li style="display:block;"><a href="?status={{$status}}">{{$desc}}</a></li>
                    @endforeach
                    <!--<li role="separator" class="divider"></li>
                    <li><a href="/manager?status=credit">Выкупленные</a></li>
                    <li><a href="/manager?status=delivered">Доставлены агенту</a></li>
                    <li><a href="/manager?status=boxbery">Отправлены в boxberry</a></li>
                    <li><a href="/manager?status=boxberyhub">Доставлены в boxberry</a></li>
                    <li><a href="/manager?status=shipped">Доставлено клиенту</a></li>
                    <li><a href="/manager?status=payed">Оплачено</a></li>-->
                </ul>
            </div>


        </div>
    </div>
    @if(isset($orders))
        <table class="orders">
            <tr class="order-header">
                <th class="header-field"><i style="display:none">{{$i=count($orders)}}</i></th>
                <th class="header-field">#</th>
                <th class="header-field">Дата</th>
                <th class="header-field">Статус</th>
                <th class="header-field">Покупатель</th>
                <th class="header-field">Доставка</th>
                <th class="header-field">Оплата</th>
                <th class="header-field">Комиссия</th>
                <th class="header-field">Полная Сумма</th>
            </tr>

            @foreach($orders as $order)

                <tr class="order status-{{$order->status}}" id="order-{{$order->order_id}}" data-ref="{{$order->order_id}}">
                    <td class="order-field">{{$i--}}</td>
                    <td class="order-field">{{$order->order_id}}</td>
                    <td class="order-field">{{$order->date}}</td>
                    <td class="order-field">{{$statuses[$order->status]}}</td>
                    <td class="order-field">{{$order->first_name}} {{$order->fio_middle}} {{$order->last_name}}<br/><a href="tel:{{$order->shipping_phone}}">{{$order->shipping_phone}}</a></td>
                    <td class="order-field order-amount">{{$order->delivery}}<br />@amount($order->shipping_cost)</td>
                    <td class="order-field order-amount">{{$order->payment}}<br />@amount($order->amount)</td>
                    <td class="order-field order-amount">Курсовая: @amount($order->amount-($order->amount/1.05))<br />%: @amount($order->service_fee)</td>
                    <td class="order-field order-amount">@amount($order->amount+$order->service_fee+$order->shipping_cost)</td>
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
                                        <p class="small">Паспорт: {{$passport->series or ''}}№{{$passport->number or ''}} Выдан: {{$passport->date or ''}}, {{$passport->where or ''}}</p>
                                        <p><a href="tel:{{$order->shipping_phone}}">{{$order->shipping_phone}}</a></p>
                                        <p><a href="mailto:{{$order->email}}">{{$order->email}}</a></p>
                                        <p>
                                            <h4>{{$order->delivery}} @if($order->shipping_state!='0')#{{$order->shipping_state or ''}}@endif</h4>
                                            {{$order->shipping_city}}, {{$order->shipping_postcode}}
                                            {{$order->shipping_address_1}}<br />
                                            {{$order->shipping_address_2}}<br />
                                            @amount($order->shipping_cost)
                                        </p>
                                        <p>
                                            @if($order->tracker)
                                                <br /><strong>Tracker:</strong>
                                                <a target="_blank" href='http://api.boxberry.de/?act=build&track={{$order->tracker}}&token=18455.rvpqeafa'>{{$order->tracker}}</a>
                                            @endif
                                        </p>
                                        <strong>Заказ в магазине:</strong>
                                        @include('elements.inputs.editable',['name'=>'external_order_id',"value"=>$order->external_order_id,"func"=>"update?id=".$order->order_id])
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                        <?php $items = json_decode("[]"); ?>
                                        <h3>Состав</h3>
                                        <div class="order-items empty"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row order-action-section"  data-ref="{{$order->order_id}}">
                                @if($order->status == 'new')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="canceled">{{$statuses["canceled"]}}</a>
                                @elseif($order->status == 'checkout')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="canceled">{{$statuses["canceled"]}}</a>
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="confirmed">{{$statuses["confirmed"]}}</a>
                                @elseif($order->status == 'confirmed')
                                    <div class="col-xs-6"></div>
                                    <div class="col-xs-3">
                                        @include('elements.inputs.input',['name'=>'external_order_id','icon'=>'bag','id'=>'external_order_id','text'=>'Номер заказа в магазине'])
                                    </div>
                                    <div class="col-xs-3">
                                        <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="canceled">{{$statuses["canceled"]}}</a>
                                        <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="credit">{{$statuses["credit"]}}</a>
                                    </div>

                                @elseif($order->status == 'credit')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="dispatched">{{$statuses["dispatched"]}}</a>
                                @elseif($order->status == 'dispatched')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="delivered">{{$statuses["delivered"]}}</a>
                                @elseif($order->status == 'delivered')
                                    <div class="col-xs-6 bb-sticker">
                                    </div>
                                    <div class="col-xs-3">
                                        @include('elements.inputs.input',['name'=>'weight','icon'=>'bag','id'=>'weight','text'=>'Общий вес посылки (г)'])
                                    </div>
                                    <div class="col-xs-3">
                                        <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="boxbery">{{$statuses["boxbery"]}}</a>
                                    </div>
                                @elseif($order->status == 'boxbery')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="boxberyhub">{{$statuses["boxberyhub"]}}</a>
                                @elseif($order->status == 'boxberyhub')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="warehouse">{{$statuses["warehouse"]}}</a>
                                @elseif($order->status == 'warehouse')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="destination">{{$statuses["destination"]}}</a>
                                @elseif($order->status == 'destination')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="shipped">{{$statuses["shipped"]}}</a>
                                @elseif($order->status == 'shipped')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="payed">{{$statuses["payed"]}}</a>
                                @elseif($order->status == 'payed')
                                    <a class="btn btn-default order-action" data-ref="order-set-status" data-rel="closed">{{$statuses["closed"]}}</a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        <script>
            $=jQuery.noConflict();
            /*var rp = {
                value:50000,
                timer:0,
                start:function(){
                    rp.value = (arguments.length&&!isNaN(arguments[0])&&arguments[0]>1000)?arguments[0]:rp.value;
                    rp.timer = setTimeout(function(){
                        console.debug("timer occurs "+rp.value);
                        document.location.reload();
                    },rp.value);
                },
                restart:function(){
                    console.debug("Restart timer "+ rp.timer);
                    clearTimeout(rp.timer);
                    rp.start();
                }
            };*/
            $(document).ready(function(){
                $.ajax({
                    url:'/statistics',
                    type:"get",
                    dataType:"json",
                    beforeSend:function(){
                        $(".statistics").html('<i class="fa fa-spin fa-spinner fa-2x fa-fw"></i>');
                    },
                    success:function(d){
                        var o={
                            today:{count:0,amount:0},
                            month:{count:0,amount:0},
                            all:{count:0,amount:0}
                        };
                        for(var i in d){
                            var q = d[i];
                            if(q.status != 'new' && q.status != 'canceled'){
                                o.all.count+=parseInt(q.count);
                                o.all.amount+=parseFloat(q.amount);
                                if(q.day=="today"){
                                    o.today.count+=parseInt(q.count);
                                    o.today.amount+=parseFloat(q.amount);
                                    o.month.count+=parseInt(q.count);
                                    o.month.amount+=parseFloat(q.amount);
                                }
                                else if(q.day=="thismonth"){
                                    o.month.count+=parseInt(q.count);
                                    o.month.amount+=parseFloat(q.amount);
                                }

                            }

                        }
                        var str = '<div class="row">';
                        str+='<div class="col-xs-4">'+"Сегодня&nbsp;(<i class='number'>"+o.today.count+"</i>): <i class='number'>&#8381;"+garan.number.format(o.today.amount,2,3,',','.')+"</i></div>";
                        str+='<div class="col-xs-4">'+"В этом месяце&nbsp;(<i class='number'>"+o.month.count+"</i>): "+"<i class='number'>&#8381;"+garan.number.format(o.month.amount,2,3,',','.')+"</i></div>";
                        str+='<div class="col-xs-4">'+"Всего заказов&nbsp;(<i class='number'>"+o.all.count+"</i>): "+"<i class='number'>&#8381;"+garan.number.format(o.all.amount,2,3,',','.')+"</i></div>";
                        str+='</div>';
                        $(".statistics").html(str);
                    }
                });
                $("#search").keyup(function(e){
                    var v = $(this).val();
                    if(e.keyCode == 13){
                        e.preventDefault();
                        document.location="/manager?search="+v;
                    }
                });
                $(".logo").css("cursor","pointer").on("click",function(){
                    document.location = "/manager";
                });
                $(".order").on("click",function(){
                    var $t = $(this),
                        itemsContainer = $t.next().find(".order-items"),
                        order_id=$t.attr("data-ref");
                    $(".order-details-row").slideUp();
                    if(typeof itemsContainer!= "undefined" && itemsContainer.hasClass("empty")){
                        $.ajax({
                            url:'orderitems',
                            type:"get",
                            dataType:"json",
                            data:{id:order_id},
                            beforeSend:function(){
                                itemsContainer.html('<i class="fa fa-spin fa-spinner fa-2x fa-fw"></i>');
                            },
                            success:function(d){
                                console.debug(d);
                                var ii = '',getinfo = function(it){
                                    $.ajax({
                                        url:'product?id='+it.product_id,
                                        type:"get",
                                        dataType:"json",
                                        success:function(itm){
                                            console.debug(itm);
                                            ii='<div class="row">';
                                            ii+='<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 content-image" >';
                                            ii+='<a href="'+itm.product_url+'" target="__blank"><img src="'+itm.images[0].src+'" alt="'+itm.title+'" /></a>';
                                            ii+='</div>';
                                            ii+='<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 content-name" >';
                                            ii+='<a href="'+itm.product_url+'" target="__blank">'+itm.title+'</a>';
                                            ii+=itm.description;
                                            ii+='</div>';
                                            ii+='<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 content-quntity">';
                                            ii+='x'+it.quantity;
                                            ii+='</div>';
                                            ii+='<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" content-amount>';
                                            ii+=parseFloat(itm.price).format(2,3,' ','.')+' руб.';
                                            ii+='</div>';
                                            ii+='</div><br/>';
                                            itemsContainer.append(ii);
                                        }
                                    });
                                };
                                itemsContainer.html('');
                                for(var i in d.line_items) getinfo(d.line_items[i]);
                                itemsContainer.html(ii);
                            }
                        });
                        itemsContainer.removeClass("empty");
                    }
                    $("#order-details-"+$t.attr("data-ref")).slideToggle();
                    //rp.restart();
                });
                $(".order-action").on("click",function(){
                    var $t = $(this),ac = $t.attr("data-rel"),id = $t.parents(".order-action-section:first").attr("data-ref");
                    if(ac=="boxbery"){
                        var w=$t.parents(".order-action-section:first").find("#weight").val().trim();
                        w=(w.length)?w:1000;
                        $.ajax({
                            url:"updatestatus?id="+id+"&status="+ac,
                            type:"get",
                            dataType:"json",
                            beforeSend:function(){
                                $t.html('<i class="fa fa-spin fa-spinner fa-2x fa-fw"></i>');
                            },
                            success:function(d){
                                $.ajax({
                                    url:"bbparsel?deal="+id+"&weight="+w,
                                    type:"get",
                                    dataType:"json",
                                    success:function(d){
                                        console.log(d);
                                        if(typeof d.err !="undefined"){
                                            console.error(d.err);
                                            //alert window
                                        }
                                        //else $(".order-action-section[data-ref='"+id+"'] .bb-sticker").load(d.result.label);//.html('<a target="__blank" href="'+d.result.label+'">Стикер</a>');
                                        else $(".order-action-section[data-ref='"+id+"'] .bb-sticker").html('<a target="__blank" href="'+d.result.label+'">'+d.result.track+'</a>');
                                        $t.attr("data-rel",'boxberyhub').text("Доставлен в BoxBerry");
                                        document.location.reload();
                                    }
                                });
                            }
                        });
                    }
                    else if(ac=="credit"){
                        var ext_order = $("#external_order_id:visible").val();
                        $.ajax({
                            url:"updatestatus?id="+id+"&status="+ac+"&external_order_id="+ext_order,
                            type:"get",
                            dataType:"json",
                            beforeSend:function(){
                                $t.html('<i class="fa fa-spin fa-spinner fa-2x fa-fw"></i>');
                            },
                            success:function(d){
                                document.location.reload();
                            }
                        });
                    }
                    else {
                        $.ajax({
                            url:"updatestatus?id="+id+"&status="+ac,
                            type:"get",
                            dataType:"json",
                            beforeSend:function(){
                                $t.html('<i class="fa fa-spin fa-spinner fa-2x fa-fw"></i>');
                            },
                            success:function(d){
                                document.location.reload();
                            }
                        });
                    }
                });

            });
        </script>
    @endif
@endsection
