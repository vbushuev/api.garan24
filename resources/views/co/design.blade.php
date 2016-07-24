@extends($viewFolder.'.layout')
@section('content')




<div id="form" class="form col-xs-12 col-sm-12 col-md-8 col-lg-8">
    <h3><i class="first">Ваши</i> контактные данные: </h3>
    <div class="form-group">
        <label for="email" class="control-label">Электронная почта:</label>
        @include('elements.inputs.email',['text'=>'Электронная почта','required'=>"required"])
    </div>
    <div class="form-group">
        <label for="phone" class="control-label">Телефон:</label>
        @include('elements.inputs.mobile',["text"=>"Номер мобильного телефона",'required'=>"required"])
    </div>
    <p class="text-muted small">
        Нажимая кнопку "Продолжить", Вы присоединяетесь к <a href="https://garan24.ru/terms" target="__blank">Договору</a> на обслуживание клиентов сервиса Гаран24.
    </p>
</div>
@endsection
