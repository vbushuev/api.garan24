@extends('layouts.master')

@section('title', 'Garan24 Checkout')

@section('sidebar')

@endsection

@section('content')
<div class="columns">
    <div class="col-left">
        <div class="title">
            Your order
        </div>
        @if(isset($order) )
            @foreach ($order as $item)
                <div class="order-item">
                    <span class="item-name">{{$item['name']}}</span>
                    <span class="item-quantity">x{{$item['quantity']}}</span>
                    <span class="item-dots">..........................</span>
                    <span class="item-price">
                        @if($item['currency']=='eur') <i class="fa fa-euro"></i>
                        @elseif($item['currency']=='usd') <i class="fa fa-usd"></i>
                        @elseif($item['currency']=='rub') <i class="fa fa-rub"></i>
                        @endif
                        {{$item['price']}}
                    </span>
                </div>
            @endforeach
        @else
            No items in order
        @endif
    </div>
    <div class="col-right">
        <div class="title">
            Garan<sup>24</sup> Checkout
        </div>
        <div class="form-group user">
            <input type="email" class="email required" id="email" placeholder="Email address">
        </div>
        <div class="form-group user">
            <input type="phone" class="phone required" id="phone" placeholder="Mobile phone number">
            <button type="button" class="highlighted" id="foward">Foward</button>
        </div>
        <div class="form-group disabled postcode">
            <select class="country requered" id="country" placeholder="Country">
                <option value="ru">Russia</option>
                <option value="ru">German</option>
                <option value="ru">UK</option>
                <option value="ru">USA</option>
            </select>
            <input type="text" class="postcode required" id="postcode" placeholder="Postcode">
        </div>
        <div class="form-group disabled fullname">
            <select class="titles" id="titles">
                <option value="mr">Mr.</option>
                <option value="mrs">Mrs.</option>
                <option value="miss">Miss</option>
            </select>
            <input type="text" class="name required" id="name" placeholder="Name">
            <input type="text" class="surname required" id="surname" placeholder="Surname">
        </div>
        <div class="form-group disabled address">
            <input type="text" class="address required-line" id="address-line1" placeholder="Address line 1">
            <input type="text" class="address-line" id="address-line2" placeholder="Address line 2">
            <input type="text" class="city required" id="city" placeholder="City/Town">
            <input type="text" class="state required" id="state" placeholder="State">

        </div>
        <div class="form-submit disabled checkout">
            <button class="highlighted" id="checkout">Checkout</button>
            <!--<button class="highlighted">Part Now</button>
            <button>Pay Now</button>-->
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="/js/garan24.js"></script>
@endsection
