@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
    <h3><i class="first">Ваши</i> контактные данные: </h3>
    <div class="form-group">
        <label for="email" class="control-label">Электронная почта:</label>
        @include('elements.inputs.email',['text'=>'Электронная почта','required'=>"required"])
    </div>
    <div class="form-group">
        <label for="phone" class="control-label">Телефон:</label>
        @include('elements.inputs.mobile',["text"=>"Номер мобильного телефона",'required'=>"required"])
    </div>
    @include("$viewFolder._buttons",["gobackurl"=>$shop_url])
    <br />
    <p class="text-muted small">
        Нажимая кнопку "Продолжить", Вы присоединяетесь к <a href="https://www.gauzymall.com/terms-and-conditions/" target="__blank">Договору</a> на обслуживание клиентов сервиса.
    </p>
@endsection
