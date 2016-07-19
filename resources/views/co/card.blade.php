@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')

    <p>
        <strong>Выбранный способ оплаты:</strong> {{$deal->payment['name'] or 'Наличными при получении'}}<br />
    </p>
    <div class="message @if (session('status')) message-alert @endif">
        @if (session('status'))
            {{ session('status') }}
        @elseif($payment['id'] == 1 )
            Для подтверждения заказа система Гаран24 заблокирует на Вашей карте 1 руб. и сразу отменит операцию.
        @else
            Вам нужно указать реквизиты своей банковской карты для оплаты полной стоимости заказа.
        @endif
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="card_amount" class="control-label">Сумма операции по карте:</label>
                <strong class="attention" style="display:block">
                @if($payment['id'] == 1 )
                    @amount(1)
                @else
                    @amount($amount)
                @endif
                </strong>
            </div>
        </div>
    </div>
    <h3><i class="first">Введите</i> реквизиты Вашей карты:</h3>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group" id="Pan">
                <label for="pan" class="control-label">Номер карты</label>
                @include('elements.inputs.pan')
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <img src="../magnitolkin_ru/SecureCodeByMasterCard.png" alt="SecureCode by MasterCard" title="Безопасные покупки с MasterCard"/>
            &nbsp;
            <img src="../magnitolkin_ru/VerifiedByVISA.png" alt="Verified by VISA" title="Безопасные покупки с VISA">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group" id="ExpireDate">
                <label for="expiredate" class="control-label">Срок действия:</label>
                @include('elements.inputs.expiredate')
                <p class="text-muted small">В формате MM/ГГ. Как написано на карте.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group" id="CVV">
                <label for="cvv" class="control-label">CVV2/CVC2:</label>
                @include('elements.inputs.cvv',['name'=>'passport["code"]'])
                <p class="text-muted small">3 цифры на обороте карты.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group" id="Cardholder">
                <label for="cardholder" class="control-label">Имя Владелца карты:</label>
                @include('elements.inputs.text',['name'=>'cardholder','class'=>'cardholder','icon'=>'user','text'=>'CARD HOLDER'])
                <p class="text-muted small">Латинскими буквами</p>
            </div>
        </div>
    </div>
    <div class="form-group" id="PassportAgree">
        @include('elements.inputs.checkbox',["name"=>"agree1","checked"=>"checked","text"=>"Сохранить мою карту в сервисе Гаран24."])
        <p class="text-muted small">
            <a href="https://garan24.ru/terms" target="__blank">
                <i class="fa fa-lock fa-fw"></i>Безопасность хранения карты в системе Гаран24</a>.
        </p>
    </div>

    @include("$viewFolder._buttons")

@endsection
