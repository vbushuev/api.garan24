<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Форма оплаты</title>
    <!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/paynet-ui-skin/${SKIN_VERSION}/d/css/processing-form.css"/>
    -->
    <style>
        @import url("//fonts.googleapis.com/css?family=Roboto+Mono:800,400,100&subset=latin,cyrillic");
        @import url("//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css");
        @import url("https://sandbox.ariuspay.ru/paynet-ui-skin/version/main/css/processing-form.css");
        .header-logo{background:url("https://sandbox.ariuspay.ru/paynet-ui-skin/version/main/images/payneteasy-logo.png") no-repeat left center;width:200px;height:120px;}

    </style>
</head>

<body>
<div class="container">
    <!-- HEADER -->
    <div class="header">
        <table cellspacing="0" cellpadding="10" style="width:100%; text-align:center; margin:4px 0 0">
            <tr>

                <td style="text-align:left;">
                    <a title="Платежный шлюз компании Ариус" href="https://magnitolkin.ru">
                        <img height="80" alt="Магнитолкин" src="../magnitolkin_ru/Logo.gif">
                    </a>
                </td>
                <td style="text-align:right;">
                    <a title="Платежный шлюз компании Ариус" href="https://garan.ru">
                        <img height="50" alt="Garan24" src="http://garan24.ru/wp-content/uploads/2016/04/Logo_GARAN24b.png">
                    </a>
                </td>
            </tr>
        </table>
    </div>

    <div class="main">
        <!-- Order Summary -->
        <div class="summary">
            <h2 class="summary-title as-title">Информация о платеже</h2>
            <div class="summary-description">$!ORDERDESCRIPTION</div>

            <div class="summary-total">
                <span class="summary-total-label">Сумма:</span>
                <span class="summary-total-value">$!AMOUNT $!CURRENCY</span>
            </div>
        </div>

        <!-- Order Description -->
        <div class="summary summary-descr" style="height:120px;">
            <h2 class="summary-title as-title">Зачем мне вводить карту?</h2>
            <div class="summary-description" style="width:620px;">
                Вы оплачиваете полную стоимость заказа банковской картой Visa\MC курьеру или сотруднику пункта выдачи заказов при получении заказа.<br />
                Сейчас необходимо сейчас сделать предоплату стоимости доставки банковской картой.
            </div>

        </div>

        <!-- Pay form -->
        <!--<form class="form" action="${ACTION}" method="post">-->
        <form class="form" action="{{$route["next"]["href"]}}" method="get">

            <h2 class="form-title as-title">Данные вашей карты</h2>

            <ul class="form-ul">
                <!-- Card printed name -->
                <li class="form-li">
                    <label class="form-label" for="${CARDHOLDER}">Имя держателя:</label>
                    <input class="form-number-field" id="${CARDHOLDER}" name="${CARDHOLDER}" type="text" maxlength="50" autocomplete="off" value="${CARDHOLDER_VALUE}" />
                </li>

                <!-- Card Number -->
                <li class="form-li">
                    <label class="form-label" for="${CARDNO}">Номер карты:</label>
                    <input class="form-number-field" id="${CARDNO}" name="${CARDNO}" type="text" maxlength="18" autocomplete="off"  />
                </li>

                <!-- CVV -->
                <li class="form-li">
                    <label class="form-label" for="${CVV2}">CVV2/CVC2-код:</label>
                    <input class="form-cvv-field" name="${CVV2}" id="${CVV2}" type="password" maxlength="4" autocomplete="off" />
                </li>

                <li class="form-li">
                    <label class="form-label" for="${EXPMONTH}">Срок действия:</label>

                    <select class="form-expire-month" id="${EXPMONTH}" name="${EXPMONTH}" size="1" >
                        <option value="01">01 / January</option>
                        <option value="02">02 / February</option>
                        <option value="03">03 / March</option>
                        <option value="04">04 / April</option>
                        <option value="05">05 / May</option>
                        <option value="06">06 / June</option>
                        <option value="07">07 / July</option>
                        <option value="08">08 / August</option>
                        <option value="09">09 / September</option>
                        <option value="10">10 / October</option>
                        <option value="11">11 / November</option>
                        <option value="12">12 / December</option>
                    </select>

                    <!--suppress HtmlFormInputWithoutLabel -->
                    <select class="form-expire-year" name="${EXPYEAR}" id="${EXPYEAR}" size="1">
                        ${EXPIRE_YEARS}
                    </select>
                </li>

                $!{INTERNAL_SECTION}

                #if($!card_error)
                <div class="form-error">
                    $!card_error
                </div>
                #end

                <li class="form-li">
                    @include('elements.inputs.checkbox',["name"=>"agree1","text"=>"Сохранить мою карту."])
                    <p class="text-muted small">Указав согласие, Вы принимаете <a href="https://garan24.ru/terms" target="__blank">соглашение</a> Гаран24 хранении Ваших персональных данных.</p>
                </li>
                <li class="form-li-buttons">

                    <span class="form-secure-connection">БЕЗОПАСНОЕ СОЕДИНЕНИЕ</span>

                    <!--suppress HtmlFormInputWithoutLabel -->
                    <input name="submit" type="submit" class="form-button form-button-ok"     value="Оплатить" />
                    <!--suppress HtmlFormInputWithoutLabel -->
                    <input name="cancel" type="submit" class="form-button form-button-cancel" value="Отмена" />
                </li>

            </ul>

            <div class="form-card-info"></div>

        </form>
    </div>
</div>
</body>

</html>
