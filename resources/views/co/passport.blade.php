@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')

    <h3><i class="first">Для</i> оформления Международной доставки укажите Ваши паспортные данные: </h3>
    <div class="form-group" id="PersonLastName">
        <label for="fio['last']" class="control-label">Фамилия:</label>
        @include('elements.inputs.text',["name"=>"fio[last]","text"=>"Фамилия","icon"=>"user",'required'=>"required","value"=>$customer["billing_address"]["last_name"]])
    </div>
    <div class="form-group" id="PersonFirstName">
        <label for="fio['first']" class="control-label">Имя:</label>
        @include('elements.inputs.text',["name"=>"fio[first]","text"=>"Имя","icon"=>"user",'required'=>"required","value"=>$customer["billing_address"]["first_name"]])
    </div>
    <div class="form-group" id="PersonMiddleName">
        <label for="fio['middle']" class="control-label">Отчество:</label>
        @include('elements.inputs.text',["name"=>"fio[middle]","text"=>"Отчество","icon"=>"user","value"=>isset($deal->getCustomer()->fio_middle)?$deal->getCustomer()->fio_middle:""])
    </div>
    <h3><i class="first">Паспорт</i>:</h3>
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
                @include('elements.inputs.date',['name'=>'passport["date"]',"text"=>"Дата выдачи","value"=>isset($customer["passport"]["date"])?$customer["passport"]["date"]:""])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group" id="PassportLocale">
                <label for="passport['where']" class="control-label-left">Кем выдан:</label>
                <textarea id="passport['where']" name="passport['where']" class="form-control" placeholder="Кем выдан" rows="3">
                    {{isset($customer["passport"]["where"])?$customer["passport"]["where"]:""}}
                </textarea>
            </div>
        </div>
    </div>
    @include("$viewFolder._buttons")

@endsection
