@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')

    <h3><i class="first">Для</i> оформления доставки укажите Ваши паспортные данные: </h3>
    <div class="form-group" id="PersonLastName">
        <label for="fio['last']" class="control-label">Фамилия:</label>
        @include('elements.inputs.text',["name"=>"fio[last]","text"=>"Фамилия",'required'=>"required","value"=>$customer["billing_address"]["last_name"]])
    </div>
    <div class="form-group" id="PersonFirstName">
        <label for="fio['first']" class="control-label">Имя:</label>
        @include('elements.inputs.text',["name"=>"fio[first]","text"=>"Имя",'required'=>"required","value"=>$customer["billing_address"]["first_name"]])
    </div>
    <div class="form-group" id="PersonMiddleName">
        <label for="fio['middle']" class="control-label">Отчество:</label>
        @include('elements.inputs.text',["name"=>"fio[middle]","text"=>"Отчество","value"=>isset($deal->getCustomer()->fio_middle)?$deal->getCustomer()->fio_middle:""])
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group" id="Passport">
                <label for="passport[series]" class="control-label">Серия и номер</label>
                @include('elements.inputs.passport',["series"=>isset($customer["passport"]["series"])?$customer["passport"]["series"]:"","number"=>isset($customer["passport"]["number"])?$customer["passport"]["number"]:""])
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group" id="PassportDate">
                <label for="passport['date']" class="control-label">Дата выдачи:</label>
                @include('elements.inputs.date',['name'=>'passport["date"]',"value"=>isset($customer["passport"]["date"])?$customer["passport"]["date"]:""])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group" id="PassportLocale">
                <label for="passport['where']" class="control-label">Кем выдан:</label>
                <textarea id="passport['where']" name="passport['where']" class="form-control" placeholder="" rows="3">
                    {{isset($customer["passport"]["where"])?$customer["passport"]["where"]:""}}
                </textarea>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group" id="PassportCode">
                <label for="passport['code']" class="control-label">Код подразделения:</label>
                @include('elements.inputs.text',['name'=>'passport["code"]',"value"=>isset($customer["passport"]["code"])?$customer["passport"]["code"]:""])
            </div>
        </div>

    </div>
    <p class="text-muted small">
        Нажимая кнопку "Продолжить", Вы присоединяетесь к <a href="https://garan24.ru/terms" target="__blank">Договору</a> на обслуживание клиентов сервиса Гаран24.</p>
    </p>
    @include("$viewFolder._buttons")

@endsection
