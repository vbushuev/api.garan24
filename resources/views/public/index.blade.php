@extends('layouts.master')

@section('title', 'Garan24')

@section('sidebar')
<nav>
    <a class="nav-item active" href="/"><i class="fa fa-home"></i></a>
    <a class="nav-item" href="http://demoshop.garan24.ru" target="_blank">demo</a>
    <!--<a href="#" id="nav-menu"><i class="fa fa-bars"></i></a>-->
</nav>
@endsection

@section('content')
    <div class="title-logo">
        <span class="g">G</span>
        <span>aran</span>
        <span class="a">24</span>
    </div>

    <a class="button highlighted" href="/checkout">Part After</a>

@endsection
