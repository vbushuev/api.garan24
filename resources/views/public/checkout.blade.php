@extends('layouts.master')

@section('title', 'Garan24 Checkout')

@section('sidebar')

@endsection

@section('content')
    <section>
        <div class="title">
            Garan<sup><i class="garan24-blue">2</i><i class="garan24-red">4</i></sup> <i class="smaller">checkout</i>
        </div>
        <div id="alert-field" class="alert alert-success nodisplay" role="alert">The field email is required!!!</div>
        <div class="input-group required">
            <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
            <input name="email" class="form-control email" type="text" placeholder="Email address">
        </div>
        <div class="input-group required">
            <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
            <input name="phone" class="form-control phone" type="text" placeholder="Mobile phone">
        </div>
        <div class="input-form nodisplay register">
            <h3>Your personal info</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group required">
                        <span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>
                        <input name="first-name" class="form-control first-name" type="text" placeholder="Your name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>
                        <input name="middle-name" class="form-control middle-name" type="text" placeholder="Middle name">
                    </div>
                </div>
            </div>
            <div class="input-group required">
                <span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>
                <input name="last-name" class="form-control phone" type="text" placeholder="Last name">
            </div>
        </div>
        <div class="input-form nodisplay register">
            <h3>Shipping address</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group required">
                        <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                        <input name="postcode" class="form-control postcode" type="text" placeholder="Postcode">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-map-o fa-fw"></i></span>
                        <input name="state" class="form-control state" type="text" placeholder="State">
                    </div>
                </div>
            </div>
            <div class="input-group required">
                <span class="input-group-addon"><i class="fa fa-home fa-fw"></i></span>
                <input name="city" class="form-control city" type="text" placeholder="City">
            </div>
            <div class="input-group required">
                <span class="input-group-addon"><i class="fa fa-home fa-fw"></i></span>
                <input name="address" class="form-control address" type="text" placeholder="Address">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <div class="input-group">
                    <a class="button highlighted" id="foward">Foward</a>
                </div>
            </div>
        </div>
    </section>
    @if(isset($order) )
    <section>
        <div class="title">Your order</div>
        <table class="review-order">
            <tr>
                <th>&nbsp;</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            @foreach ($order as $item)
                <tr>
                    <td>@if(isset($item['img']))
                            <img src="{{$item['img']}}" alt="{{$item['name']}}" width="48px"/>
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td>{{$item['name']}}</td>
                    <td>
                        @if($item['currency']=='eur') <i class="fa fa-euro"></i>
                        @elseif($item['currency']=='usd') <i class="fa fa-usd"></i>
                        @elseif($item['currency']=='rub') <i class="fa fa-rub"></i>
                        @endif
                        {{$item['price']}}
                    </td>
                    <td>{{$item['quantity']}}</td>
                    <td>
                        @if($item['currency']=='eur') <i class="fa fa-euro"></i>
                        @elseif($item['currency']=='usd') <i class="fa fa-usd"></i>
                        @elseif($item['currency']=='rub') <i class="fa fa-rub"></i>
                        @endif
                        {{$item['price']*$item['quantity']}}
                    </td>
                </tr>
            @endforeach
            <tr>
                <th colspan="5">&nbsp;</th>
            </tr>
        </table>
    </section>
    @else
        No items in order
    @endif
@endsection
@section('scripts')
<script src="js/api/1.0/garan24.core.js"></script>
<script>
    function checkout_register(){
        if(!web.required())return;
        $t = $(this);
        var r ={
            email:$(".email").val(),
            phone:$(".phone").val(),
            first_name:$(".first-name").val(),
            middle_name:$(".middle-name").val(),
            last_name:$(".last-name").val(),
            postcode:$(".postcode").val(),
            state:$(".state").val(),
            city:$(".city").val(),
            address:$(".address").val(),
            success:function(){
                $.redirect("../processpay",garan.preorder);
            },
            failed:function(){}
        };
    }
    function checkout_forwad(){
        if(!web.required())return;
        $t = $(this);
        var r ={
            email:$(".email").val(),
            phone:$(".phone").val(),
            success:function(){$.redirect("../processpay",garan.preorder);},
            failed:function(){
                $t.text("register");
                $(".nodisplay.register").show();
                $t.unbind("click").on("click",checkout_register);
            }
        };
        garan.customer.check(r);
    }
    (function(){
        $("#foward").on("click",checkout_forwad);
    })();
</script>
@endsection
