@extends('cart.layout')
@section('content')
    <h3><i class="first">Формирование</i> корзины</h3>
    <div class="form-group">
        <label for="email" class="control-label">URL ссылка на товар:</label>
        @include('elements.inputs.text',['name'=>'url','text'=>'URL ссылка на товар','required'=>"required", "icon"=>"external-link"])
    </div>
    <div class="form-group">
        @include('elements.inputs.text',['name'=>'sku','text'=>'Код товара','required'=>"required", "icon"=>"barcode"])
    </div>
    <div class="form-group">
        @include('elements.inputs.text',['name'=>'title','text'=>'Наименование товара','required'=>"required", "icon"=>"file-text"])
    </div>
    <div class="form-group">
        @include('elements.inputs.amount',['text'=>'Стоимость товара','required'=>"required", "values"=>[
            ["key"=>"EUR","icon"=>"euro","value"=>"Евро","selected"=>"true"],
            ["key"=>"GBP","icon"=>"gbp","value"=>"Фунт"],
            ["key"=>"USD","icon"=>"usd","value"=>"Доллар"]
        ] ])
    </div>

    <div class="form-group">
        @include('elements.inputs.text',['name'=>'quantity','text'=>'Кол-во','required'=>"required", "icon"=>"circle-o"])
    </div>
    <div class="form-group">
        @include('elements.inputs.text',['name'=>'color','text'=>'Цвет или иная вариация', "icon"=>"circle-o"])
    </div>
    <div class="form-group">
        @include('elements.inputs.text',['name'=>'weight','text'=>'Вес товара', "icon"=>"circle-o"])
    </div>
    <div class="form-group">
        @include('elements.inputs.text',['name'=>'dimensions','text'=>'Размеры товара', "icon"=>"circle-o"])
    </div>
    <div class="row">
        <button id="add2cart" class="btn btn-default btn-lg pull-left">Добавить и продолжить</button>
        <button id="forward" class="btn btn-success btn-lg pull-right">Добавить и перейти к оформлению</button>
    </div>
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection
