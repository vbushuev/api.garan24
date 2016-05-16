@extends('layouts.master')

@section('title', 'Garan24 Checkout')

@section('sidebar')

@endsection

@section('content')
    <section>
        <div class="title">
            Garan<sup>24</sup> Checkout
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
            <input name="email" class="form-control email" type="text" placeholder="Email address">
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
            <input name="phone" class="form-control phone" type="text" placeholder="Mobile phone">
        </div>
        <div class="btn-group">
            <a class="btn btn-primary" href="#"><i class="fa fa-globe fa-fw"></i> Country</a>
            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-map-marker fa-fw"></i> Россия</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="fa fa-map-marker fa-fw"></i> UK</a></li>
                <li><a href="#"><i class="fa fa-map-marker fa-fw"></i> German</a></li>
                <li><a href="#"><i class="fa fa-map-marker fa-fw"></i> USA</a></li>
            </ul>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-mobile fa-fw"></i></span>
            <input name="phone" class="form-control phone" type="text" placeholder="Mobile phone">
        </div>
        <div class="input-field disabled postcode">
            <select class="country requered" id="country" placeholder="Country">
                <option value="ru">Russia</option>
                <option value="de">German</option>
                <option value="uk">UK</option>
                <option value="us">USA</option>
            </select>
            <input type="text" class="postcode required" id="postcode" placeholder="Postcode">
        </div>
        <div class="input-field disabled fullname">
            <select class="titles" id="titles">
                <option value="mr">Mr.</option>
                <option value="mrs">Mrs.</option>
                <option value="miss">Miss</option>
            </select>
            <input type="text" class="name required" id="name" placeholder="Name">
            <input type="text" class="surname required" id="surname" placeholder="Surname">
        </div>
        <div class="input-field disabled address">
            <input type="text" class="address required-line" id="address-line1" placeholder="Address line 1">
            <input type="text" class="address-line" id="address-line2" placeholder="Address line 2">
            <input type="text" class="city required" id="city" placeholder="City/Town">
            <input type="text" class="state required" id="state" placeholder="State">

        </div>
        <div class="input-field">
            <a class="button highlighted" id="foward">Foward</a>
        </div>
        <div class="form-submit disabled checkout">
            <button class="highlighted" id="checkout">Checkout</button>
            <!--<button class="highlighted">Part Now</button>
            <button>Pay Now</button>-->
        </div>

    </section>
    <section>
        <div class="title">Your order</div>
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
    </section>
@endsection
@section('scripts')
<script src="js/garan24.js"></script>
@endsection
