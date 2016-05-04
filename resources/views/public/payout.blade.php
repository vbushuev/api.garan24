@extends('layouts.master')

@section('title', 'Garan24-redirect')

@section('sidebar')
<nav>
    <!--<a class="nav-item active" href="/"><i class="fa fa-home"></i></a>
    <a class="nav-item" href="http://demoshop.garan24.ru" target="_blank">demo</a>
    <a href="#" id="nav-menu"><i class="fa fa-bars"></i></a>-->
</nav>
@endsection

@section('content')
    <div class="title">
        Garan<sup>24</sup>
    </div>
<br /><br />
    <div class="form-group">
        {{$content["text"]}}
    </div>
    <br />
    <div class="form-group">
        <a class="button" href="/my-account">Назад</a>
        <a class="button highlighted" href="{{$content["url"]}}">Продолжить</a>
    </div>

@endsection
