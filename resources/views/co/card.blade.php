@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
    <!--
    <p>
        <strong>Выбранный способ оплаты:</strong> {{$deal->payment['name'] or 'Наличными при получении'}}<br />
    </p>-->
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
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <label for="card_amount" class="control-label-">Сумма платежа:</label>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            @if($payment['id'] == 1 )
                @amount(1)
            @else
                @amount($amount)
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group" id="Pan">
                <label for="pan" class="control-label">Номер карты</label>
                @include('elements.inputs.pan')
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group" id="ExpireDate">
                <label for="expiredate" class="control-label">Срок действия:</label>
                @include('elements.inputs.expiredate')
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group" id="CVV">
                <label for="cvv" class="control-label">CVV2/CVC2:</label>
                @include('elements.inputs.cvv')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group" id="card-save-agree">
                @include('elements.inputs.checkbox',["name"=>"agree1","checked"=>"checked","text"=>"Сохранить мою карту в сервисе Гаран24."])
                <!--<p class="text-muted small">
                    <a href="https://garan24.ru/terms" target="__blank">
                        <i class="fa fa-lock fa-fw"></i>Безопасность хранения карты в системе Гаран24</a>.
                </p>-->
            </div>
        </div>
    </div>

    @include("$viewFolder._buttons")
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <img src="../magnitolkin_ru/SecureCodeByMasterCard.png" alt="SecureCode by MasterCard" title="Безопасные покупки с MasterCard"/>
            &nbsp;
            <img src="../magnitolkin_ru/VerifiedByVISA.png" alt="Verified by VISA" title="Безопасные покупки с VISA">
        </div>
    </div>
@endsection
