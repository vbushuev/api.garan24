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
                    <span class="item-quantity">{{$item['quantity']}}</span>
                    ............................
                    <span class="item-price">{{$item['price']}}</span>
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
        <div class="form-group">
            <input type="email" class="email" id="email" placeholder="Email address">
        </div>
        <div class="form-group">
            <input type="phone" class="phone" id="phone" placeholder="Mobile phone number">
            <button type="button" class="highlighted" id="foward">Foward</button>
        </div>
        <br />
        <div class="form-group disabled postcode">
            <select class="country" id="country" placeholder="Country">
                <option value="ru">Russia</option>
                <option value="ru">German</option>
                <option value="ru">UK</option>
                <option value="ru">USA</option>
            </select>
            <input type="text" class="postcode" id="postcode" placeholder="Postcode">
        </div>
        <br/>
        <div class="form-group disabled fullname">
            <select class="titles" id="titles">
                <option value="mr">Mr.</option>
                <option value="mrs">Mrs.</option>
                <option value="miss">Miss</option>
            </select>
            <input type="text" class="name" id="name" placeholder="Name">
            <input type="text" class="surname" id="surname" placeholder="Surname">
        </div>
        <br/>
        <div class="form-group disabled address">
            <input type="text" class="address-line" id="address-line1" placeholder="Address line 1">
            <input type="text" class="address-line" id="address-line2" placeholder="Address line 2">
            <input type="text" class="city" id="city" placeholder="City/Town">
            <input type="text" class="state" id="state" placeholder="State">

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
