@extends('magnitolkin.cart.magnitolkin')
@section('content')
<h2><span class="red">Оформление</span> заказа</h2>

<div id="cart-container">

<table id="cart-content" class="table">
<tbody><tr class="cart-content-header">
    <th style="width: 15%;">&nbsp;</th>
    <th style="width: 50%;">Товар</th>
    <th style="width: 15%;">Количество</th>
    <th style="width: 20%; text-align: right;">Стоимость</th>
</tr>

<tr class="cart-item" id="cartItemPos14832">
    <td class="image"><img src="https://magnitolkin.ru/Handlers/CartShopItemImage/?id=14832" alt="Tempo Coax 5"></td>
    <td><a class="name" href="/catalogue/Akustika/coaxial/5_25_inch/11075/" target="_blank">Morel Tempo Coax 5</a></td>
    <td>
        <img id="btn_delete_14832" class="button" src="https://magnitolkin.ru/Files/Images/DeleteCartItem.png" alt="Удалить" title="Удалить" onclick="javascript:removeCartItem(14832)">
        <img id="btn_decrement_14832" class="button" src="https://magnitolkin.ru/Files/Images/DecrementCartItemQuantity.png" onclick="javascript:shopItemDecrementQuantity(this, 14832)" alt="Уменьшить количество" title="Уменьшить количество" style="display: none;">
		<span id="quantity_14832" class="quantity">1</span> <span class="quantity">шт.</span>
        <img id="btn_increment_14832" class="button" src="https://magnitolkin.ru/Files/Images/IncerementCartItemQuantity.png" onclick="javascript:shopItemIncrementQuantity(this, 14832)" alt="Увеличить количество" title="Увеличить количество">
        <!--<script type="text/javascript">Order.addItemToCart(14832, 4581, 1);</script>-->
    </td>
    <td><div class="cost"><span id="totalPrice14832">4&nbsp;581</span> руб.</div></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr></tbody></table>

<div id="order-options" style="margin-left: 10px;">

    <div id="delivery">
        <div class="notice">
            <div class="icon"><img src="https://magnitolkin.ru/Files/Images/SectionDelivery.png" alt="!"></div>
            <div class="comment">
                <div class="section_type_header">Способ получения</div>
                <div class="section_type_comment">Чтобы узнать полную стоимость заказа укажите способ получения товара</div>
            </div>
        </div>
        <style>
            .description {
                display: none;
                border: solid 1px rgba(0,0,0,.2);
                color: rgba(0,0,0,.6);
                font-size: 90%;
                padding: .4em;
                margin: 0 0 0 1.4em;
            }
        </style>
        <script>
            function optionClickDeliveryType(i,t){
                $(".description").hide();
                $(t).parent().parent().parent().find("label").removeClass("selected");
                $(t).parent().addClass("selected").parent().find(".description").show();
            }
        </script>
        <div id="delivery_types">
            <div class="radio">
                <label class="selected">
                    <input type="radio" id="delivery_type_2" name="delivery_types" checked="checked" onclick="javascript:optionClickDeliveryType(2, this)" data-delivery-id="2">
                    Самовывоз
                </label>
                <div class="description" style="display:block;">
                    Вы самостоятельно получаете заказ в офисе интернет магазина.<br/><strong>Срок</strong> - на следующий рабочий день<br /><strong>Стоимость</strong> - бесплатно
                </div>
            </div>
            <!--<script type="text/javascript">Order.addDeliveryType(2, 0, 0, "False", "False");</script>-->

            <div class="radio">
                <label>
                    <input type="radio" id="delivery_type_1" name="delivery_types" onclick="javascript:optionClickDeliveryType(1, this)" data-delivery-id="1">
                    Доставка курьером по Москве
                </label>
                <div class="description">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - на следующий рабочий день<br /><strong>Стоимость</strong> - 300руб.</div>
            </div>
            <!--<script type="text/javascript">Order.addDeliveryType(1, 0, 0, "True", "False");</script>-->

            <div class="radio">
                <label>
                    <input type="radio" id="delivery_type_7" name="delivery_types" onclick="javascript:optionClickDeliveryType(7, this)" data-delivery-id="7">
                    Доставка курьером по Москве (экспресс)
                </label>
                <div class="description">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - 3 часа с момента заказа<br /><strong>Стоимость</strong> - 600руб.</div>
            </div>
            <!--<script type="text/javascript">Order.addDeliveryType(7, 0, 0, "True", "False");</script>-->

            <div class="radio">
                <label>
                    <input type="radio" id="delivery_type_6" name="delivery_types" onclick="javascript:optionClickDeliveryType(6, this)" data-delivery-id="6">
                    Доставка по России
                </label>
                <div class="description">Доставка по России осуществляется Почтой России.<br/><strong>Срок</strong> - до 20 дней<br /><strong>Стоимость</strong> - 300руб.</div>
            </div>
            <!--<script type="text/javascript">Order.addDeliveryType(6, 300, 0, "True", "True");</script>-->

            <div class="radio">
                <label>
                    <input type="radio" id="delivery_type_9" name="delivery_types" onclick="javascript:optionClickDeliveryType(9, this)" data-delivery-id="9">
                    Доставка службой BoxBerry
                </label>
                <div class="description">Доставка производится до ближайшего к Вам пункта выдачи заказов Boxberry.<br/><strong>Срок</strong> - до 10 дней<br /><strong>Стоимость</strong> - 200руб.</div>
            </div>
            <!--<script type="text/javascript">Order.addDeliveryType(9, 0, 0, "True", "True");</script>-->

            <div class="radio">
                <label>
                    <input type="radio" id="delivery_type_3" name="delivery_types" onclick="javascript:optionClickDeliveryType(3, this)" data-delivery-id="3">
                    Доставка курьером за пределы МКАД
                </label>
                <div class="description">Доставка осуществляется курьерской службой интернет магазина.<br/><strong>Срок</strong> - на следующий рабочий день<br /><strong>Стоимость</strong> - 300руб. + 30руб. за каждый километр от МКАД</div>
            </div>
            <!--<script type="text/javascript">Order.addDeliveryType(3, 0, 30, "True", "False");</script>-->
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div>
        <div id="delivery-calculator" style="display: none;">
            <div class="heading">Стоимость доставки</div>
            <div style="background-color: #efefef; border:1px solid; border-color: #ffffff #cecece #cecece #ffffff;">
                <div style="text-align: left; margin-left: 15px; margin-top: 10px;" class="comment">Расстояние от Москвы:</div>
                <div class="pad">
                    <div>
                        <input type="text" id="txtDistanceToCustomer" autocomplete="off" onkeypress="javascript:return numbersOnly(this,event);" onkeyup="javascript:inputDeliveryCalculatorDistanceChanged(this);" value="" maxlength="3"> км
                        <span class="multisign">×</span>
                        <span class="rate"><span>0</span> руб./км</span>
                    </div>
                    <div class="result">
                        <div class="result_delivery_price"><span>0</span> руб.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

</div>
</div>

<div id="order-form-container">

    <div style="margin-top: 15px;">
        <button id="btnReturnToCart" class="btn btn-default btn-lg pull-left">← Вернуться</button>
        <button id="btnMakeOrder" class="btn btn-success btn-lg pull-right">Продолжить</button>
        <div class="clearfix"></div>
    </div>
</div>
<script>
$(document).ready(function(){
    $("#order-form-container").show();
    $("#btnMakeOrder").click(function(){
        document.location.href = "../magnitolkin/paymethod"
    })
    $("#btnReturnToCart").click(function(){
        document.location.href = "../magnitolkin/personal"
    })
});
</script>

<div id="boxberry-map-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Выбор пункта выдачи заказа</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <p class="text-muted">Впишите или выберите город и нажмите кнопку "Найти".</p>
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="city-search">Город:</label>
                                <span class="k-widget k-combobox k-header form-control" style="width: 20em;"><span tabindex="-1" unselectable="on" class="k-dropdown-wrap k-state-default"><input class="k-input form-control" type="text" autocomplete="off" role="combobox" aria-expanded="false" placeholder="Выберите город из списка" tabindex="0" aria-disabled="false" aria-readonly="false" aria-autocomplete="list" aria-owns="search-query_listbox" aria-busy="false" aria-activedescendant="2fed7309-f416-4eda-8c6c-583efa1803c4" style="width: 100%;"><span tabindex="-1" unselectable="on" class="k-select"><span unselectable="on" class="k-icon k-i-arrow-s" role="button" tabindex="-1" aria-controls="search-query_listbox">select</span></span></span><input type="text" id="search-query" class="form-control" style="width: 20em; display: none;" data-role="combobox" aria-disabled="false" aria-readonly="false"></span>
                            </div>
                            <button class="btn btn-primary" id="btn-search">Найти</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12" style="margin-top: 1.5em;">
                        <p class="text-muted">Отметьте на карте желаемый пункт выдачи заказов и нажмите кнопку "Выбрать пункт".</p>
                        <div id="boxberry-modal-yandex-map" style="width: 100%; height: 30em; margin-top: 15px;"><ymaps class="ymaps-2-1-39-map ymaps-2-1-39-i-ua_js_yes ymaps-2-1-39-map-bg-ru ymaps-2-1-39-islets_map-lang-ru" style="width: 0px; height: 0px;"><ymaps class="ymaps-2-1-39-inner-panes"><ymaps class="ymaps-2-1-39-events-pane ymaps-2-1-39-user-selection-none" unselectable="on" style="height: 100%; width: 100%; top: 0px; left: 0px; position: absolute; transform: translate3d(0px, 0px, 0px) scale(1, 1); z-index: 2500; cursor: url(&quot;https://api-maps.yandex.ru/2.1.39/./build/release//images/util_cursor_storage_grab.cur&quot;) 16 16, url(&quot;https://api-maps.yandex.ru/2.1.39/./build/release//images/util_cursor_storage_grab.cur&quot;), move;"></ymaps><ymaps class="ymaps-2-1-39-ground-pane" style="top: 0px; left: 0px; position: absolute; transform: translate3d(0px, 0px, 0px) scale(1, 1); transition-duration: 0ms; z-index: 501;"><ymaps style="position: absolute; z-index: 150;"><canvas height="256" width="256" style="position: absolute; width: 256px; height: 256px; left: -128px; top: -128px;"></canvas></ymaps></ymaps><ymaps class="ymaps-2-1-39-copyrights-pane" style="height: 0px; bottom: 5px; right: 3px; top: auto; left: 10px; position: absolute; transform: translate3d(0px, 0px, 0px) scale(1, 1); z-index: 5002;"><ymaps><ymaps class="ymaps-2-1-39-copyright ymaps-2-1-39-copyright_fog_yes ymaps-2-1-39-copyright_logo_no" style="width: 0px;"><ymaps class="ymaps-2-1-39-copyright__fog">…</ymaps><ymaps class="ymaps-2-1-39-copyright__wrap"><ymaps class="ymaps-2-1-39-copyright__layout"><ymaps class="ymaps-2-1-39-copyright__content-cell"><ymaps class="ymaps-2-1-39-copyright__content"><ymaps class="ymaps-2-1-39-copyright__text">© Яндекс</ymaps><ymaps class="ymaps-2-1-39-copyright__agreement">&nbsp;<a class="ymaps-2-1-39-copyright__link" target="_blank" href="http://legal.yandex.ru/maps_termsofuse/">Условия</a></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-copyright__logo-cell"><a class="ymaps-2-1-39-copyright__logo" href="" target="_blank"></a></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-map-copyrights-promo" style="bottom: -4px; position: absolute;"><iframe src="https://api-maps.yandex.ru/services/inception/?lang=ru_RU&amp;iframe_id=6471&amp;api_version=2.1.39&amp;url=%2Fmap" width="0" height="20" scrolling="no" frameborder="0" style="overflow: hidden;"></iframe></ymaps></ymaps><ymaps class="ymaps-2-1-39-controls-pane" style="width: 100%; top: 0px; left: 0px; position: absolute; transform: translate3d(0px, 0px, 0px) scale(1, 1); z-index: 4503;"><ymaps class="ymaps-2-1-39-controls__toolbar" style="margin-top: 10px;"><ymaps class="ymaps-2-1-39-controls__toolbar_left"><ymaps class="ymaps-2-1-39-controls__control_toolbar ymaps-2-1-39-user-selection-none" unselectable="on" style="margin-right: 0px; margin-left: 10px;"><ymaps><ymaps class="ymaps-2-1-39-button ymaps-2-1-39-button_size_s ymaps-2-1-39-button_theme_normal ymaps-2-1-39-button_icon_only" role="button" type="button" style="max-width: 90px" title="Определить Ваше местоположение"><ymaps class="ymaps-2-1-39-button__text"><ymaps class="ymaps-2-1-39-button__icon ymaps-2-1-39-button__icon_icon_geolocation"></ymaps><ymaps class="ymaps-2-1-39-button__title" style="display: none;"></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-controls__control_toolbar" style="margin-right: 0px; margin-left: 10px;"><ymaps><ymaps class="ymaps-2-1-39-search ymaps-2-1-39-search_layout_common"><ymaps id="id_146356268282668136538" unselectable="on" class="ymaps-2-1-39-user-selection-none"><ymaps><ymaps class="ymaps-2-1-39-button ymaps-2-1-39-button_size_s ymaps-2-1-39-button_theme_normal ymaps-2-1-39-button_icon_only" role="button" type="button" style="max-width: 30px" title="Найти"><ymaps class="ymaps-2-1-39-button__text"><ymaps class="ymaps-2-1-39-button__icon ymaps-2-1-39-button__icon_icon_magnifier" style="display: inline-block;"></ymaps><ymaps class="ymaps-2-1-39-button__title">Найти</ymaps></ymaps></ymaps></ymaps></ymaps><ymaps id="id_146356268282668136539"></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-controls__toolbar_right"><ymaps class="ymaps-2-1-39-controls__control_toolbar" style="margin-right: 10px; margin-left: 0px;"><ymaps><ymaps class="ymaps-2-1-39-traffic"><ymaps id="id_146356268282668136563" unselectable="on" class="ymaps-2-1-39-user-selection-none"><ymaps><ymaps class="ymaps-2-1-39-button ymaps-2-1-39-button_size_s ymaps-2-1-39-button_traffic_left ymaps-2-1-39-button_theme_normal ymaps-2-1-39-button_icon_only" role="button" type="button"><ymaps class="ymaps-2-1-39-button__text"><ymaps class="ymaps-2-1-39-traffic__icon ymaps-2-1-39-traffic__icon_icon_off ymaps-2-1-39-button__icon"></ymaps><ymaps class="ymaps-2-1-39-button__title"><ymaps>Пробки</ymaps></ymaps></ymaps></ymaps></ymaps><ymaps></ymaps></ymaps><ymaps id="id_146356268282668136564"><ymaps><ymaps class="ymaps-2-1-39-traffic__panel ymaps-2-1-39-popup ymaps-2-1-39-popup_direction_down ymaps-2-1-39-popup_to_bottom ymaps-2-1-39-popup_theme_ffffff ymaps-2-1-39-user-selection-none" unselectable="on" style="width: 270px;"><ymaps class="ymaps-2-1-39-traffic__tail ymaps-2-1-39-popup__tail"></ymaps><ymaps class="ymaps-2-1-39-traffic__panel-content"><ymaps id="id_146356268282668136565"><ymaps><ymaps class="ymaps-2-1-39-traffic__switcher"><ymaps class="ymaps-2-1-39-traffic__switcher-item ymaps-2-1-39-traffic__switcher-item_data_actual ymaps-2-1-39-traffic__switcher-item_selected_yes">Сегодня</ymaps><ymaps class="ymaps-2-1-39-traffic__switcher-item ymaps-2-1-39-traffic__switcher-item_data_archive">Статистика</ymaps></ymaps></ymaps></ymaps><ymaps></ymaps><ymaps></ymaps><ymaps></ymaps><ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-controls__control_toolbar" style="margin-right: 10px; margin-left: 0px;"><ymaps><ymaps class="ymaps-2-1-39-listbox ymaps-2-1-39-listbox_opened_no ymaps-2-1-39-listbox_align_right" style="width: 0px;"><ymaps class="ymaps-2-1-39-button ymaps-2-1-39-button_size_s ymaps-2-1-39-button_theme_normal ymaps-2-1-39-button_icon_only ymaps-2-1-39-user-selection-none" role="button" type="button" title="" unselectable="on"><ymaps class="ymaps-2-1-39-button__text"><ymaps class="ymaps-2-1-39-button__icon ymaps-2-1-39-button__icon_icon_layers"></ymaps><ymaps class="ymaps-2-1-39-button__title" style="display: none;">Слои</ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-listbox__panel ymaps-2-1-39-i-custom-scroll" style="transform: translate3d(0px, 0px, 0px) scale(1, 1);"><ymaps class="ymaps-2-1-39-listbox__list ymaps-2-1-39-listbox__list_scrollable_yes" style="max-height: 0px;"><ymaps><ymaps><ymaps id="id_146356268282668136582"><ymaps unselectable="on" class="ymaps-2-1-39-user-selection-none"><ymaps class="ymaps-2-1-39-listbox__list-item ymaps-2-1-39-listbox__list-item_selected_yes"><ymaps class="ymaps-2-1-39-listbox__list-item-text">Схема</ymaps></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps><ymaps><ymaps id="id_146356268282668136585"><ymaps unselectable="on" class="ymaps-2-1-39-user-selection-none"><ymaps class="ymaps-2-1-39-listbox__list-item ymaps-2-1-39-listbox__list-item_selected_no"><ymaps class="ymaps-2-1-39-listbox__list-item-text">Спутник</ymaps></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps><ymaps><ymaps id="id_146356268282668136588"><ymaps unselectable="on" class="ymaps-2-1-39-user-selection-none"><ymaps class="ymaps-2-1-39-listbox__list-item ymaps-2-1-39-listbox__list-item_selected_no"><ymaps class="ymaps-2-1-39-listbox__list-item-text">Гибрид</ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-controls__control_toolbar ymaps-2-1-39-user-selection-none" unselectable="on" style="margin-right: 10px; margin-left: 0px;"><ymaps><ymaps class="ymaps-2-1-39-button ymaps-2-1-39-button_size_s ymaps-2-1-39-button_theme_normal ymaps-2-1-39-button_icon_only" role="button" type="button" style="max-width: 28px" title=""><ymaps class="ymaps-2-1-39-button__text"><ymaps class="ymaps-2-1-39-button__icon ymaps-2-1-39-button__icon_icon_expand" style="display: inline-block;"></ymaps><ymaps class="ymaps-2-1-39-button__title" style="display: none;"></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-controls__bottom" style="top: 0px;"><ymaps class="ymaps-2-1-39-controls__control" style="margin-right: 0px; margin-left: 0px; bottom: 30px; top: auto; right: 10px; left: auto;"><ymaps><ymaps style="display: block;"><ymaps style="display: inline-block; height: 100%; vertical-align: top;"><ymaps id="id_146356268282668136525"><ymaps><ymaps class="ymaps-2-1-39-scaleline" style="width: 87px; min-width: 59px"><ymaps class="ymaps-2-1-39-scaleline__left"><ymaps class="ymaps-2-1-39-scaleline__left-border"></ymaps><ymaps class="ymaps-2-1-39-scaleline__left-line"></ymaps></ymaps><ymaps class="ymaps-2-1-39-scaleline__center"><ymaps class="ymaps-2-1-39-scaleline__label">30&nbsp;км</ymaps></ymaps><ymaps class="ymaps-2-1-39-scaleline__right"><ymaps class="ymaps-2-1-39-scaleline__right-border"></ymaps><ymaps class="ymaps-2-1-39-scaleline__right-line"></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps style="display: inline-block; width: 10px; height: 0"></ymaps><ymaps style="display: inline-block;"><ymaps id="id_146356268282668136526" unselectable="on" class="ymaps-2-1-39-user-selection-none"><ymaps><ymaps class="ymaps-2-1-39-button ymaps-2-1-39-button_size_s ymaps-2-1-39-button_theme_normal ymaps-2-1-39-button_icon_only" role="button" type="button" style="max-width: 28px" title="Измерение расстояний на карте"><ymaps class="ymaps-2-1-39-button__text"><ymaps class="ymaps-2-1-39-button__icon ymaps-2-1-39-button__icon_icon_ruler"></ymaps><ymaps class="ymaps-2-1-39-button__title" style="display: none;"></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-controls__control" style="margin-right: 0px; margin-left: 0px; bottom: auto; top: 108px; right: auto; left: 10px;"><ymaps><ymaps class="ymaps-2-1-39-zoom" style="height: 5px"><ymaps class="ymaps-2-1-39-zoom__plus ymaps-2-1-39-zoom__button ymaps-2-1-39-button ymaps-2-1-39-button_size_s ymaps-2-1-39-button_theme_normal ymaps-2-1-39-user-selection-none" unselectable="on"><ymaps class="ymaps-2-1-39-zoom__icon ymaps-2-1-39-button__icon"></ymaps></ymaps><ymaps class="ymaps-2-1-39-zoom__minus ymaps-2-1-39-zoom__button ymaps-2-1-39-button ymaps-2-1-39-button_size_s ymaps-2-1-39-button_theme_normal ymaps-2-1-39-user-selection-none" unselectable="on"><ymaps class="ymaps-2-1-39-zoom__icon ymaps-2-1-39-button__icon"></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-searchpanel-pane" style="width: 100%; top: 0px; left: 0px; position: absolute; transform: translate3d(0px, 0px, 0px) scale(1, 1); z-index: 6509;"><ymaps><ymaps class="ymaps-2-1-39-search ymaps-2-1-39-search_layout_panel"><ymaps class="ymaps-2-1-39-search__layout"><ymaps id="id_146356268282668136540"><ymaps><ymaps class="ymaps-2-1-39-search__input"><ymaps class="ymaps-2-1-39-search__input-wrap"><ymaps class="ymaps-2-1-39-input ymaps-2-1-39-input_size_s ymaps-2-1-39-input_theme_normal"><ymaps class="ymaps-2-1-39-input__box"><input class="ymaps-2-1-39-input__control" name="" placeholder="Адрес или объект"><ymaps class="ymaps-2-1-39-input__clear"></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-search__serp-button"></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-search__button"><ymaps class="ymaps-2-1-39-button ymaps-2-1-39-button_size_s ymaps-2-1-39-button_theme_action ymaps-2-1-39-user-selection-none" role="button" type="button" unselectable="on"><ymaps class="ymaps-2-1-39-button__text">Найти</ymaps></ymaps></ymaps></ymaps></ymaps><ymaps class="ymaps-2-1-39-search__button ymaps-2-1-39-search__button_type_fold"><ymaps class="ymaps-2-1-39-button ymaps-2-1-39-button_size_s ymaps-2-1-39-button_icon_only ymaps-2-1-39-button_pseudo_yes ymaps-2-1-39-button_theme_pseudo" role="button" type="button"><ymaps class="ymaps-2-1-39-button__text"><ymaps class="ymaps-2-1-39-button__icon ymaps-2-1-39-button__icon_icon_fold"></ymaps></ymaps></ymaps></ymaps></ymaps><ymaps id="id_146356268282668136541"><ymaps><ymaps class="ymaps-2-1-39-islets_serp-popup ymaps-2-1-39-islets__hidden"><ymaps class="ymaps-2-1-39-islets_serp-popup__tail"></ymaps><ymaps class="ymaps-2-1-39-islets_serp" style="max-height: 0px;"><ymaps id="id_146356268282668136542"><ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></ymaps></div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button id="commit-point-btn" class="btn btn-primary">Выбрать пункт</button>
                <button class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript" src="https://magnitolkin.ru/Files/Scripts/boxberry.js"></script>
<script src="http://points.boxberry.ru/js/postmessage.js"></script>
<script type="text/javascript">
    var selectedPoint;

    function performSearch() {

		var selectedCityId = jQuery('#search-query').val();

        // подгрузить пункты выдачи выбранного города
         jQuery.ajax({
                type: 'POST',
                url: '/Handlers/Ordering/Boxberry/',
                data: {'method':'ListPoints','CityCode': "'"+selectedCityId+"'" },
                async: false,
                dataType: 'json'
            })

        .done(function (data) {
            var currentGeoObjects = new ymaps.GeoObjectCollection();

            for(index = 0; index < data.length; index++) {
                var currentPoint = data[index];
                var gpsTemp = currentPoint.GPS.split(',');
                var currentPointGPS = [gpsTemp[0].trim(), gpsTemp[1].trim()];

                var placemark = new ymaps.GeoObject(
                {
                    geometry: {
                        type: "Point"
                        , coordinates: currentPointGPS
                    }
                    , properties: {
                        balloonContent: currentPoint.Address
                        , point: currentPoint
                    }
                }
                );
                placemark.events.add("balloonopen", function(args) { saveSelectedPoint(args); });
                currentGeoObjects.add(placemark);
            }

            bbMap.geoObjects.removeAll();
            bbMap.geoObjects.add(currentGeoObjects);

            var currentBounds = currentGeoObjects.getBounds();
            bbMap.setBounds(currentBounds);
        })
        .fail(function (xhr, status, err) { console.error('Ошибка запроса ПВЗ в городе: ' + status); console.error(err); });
    }

    function saveSelectedPoint(args) {
        selectedPoint = args.get('target').properties.get("point");
    }

    function commitSelectedPoint() {
        var deliveryInfo = 'Адрес: ' + selectedPoint.Address
	    + '\nТелефон: ' + selectedPoint.Phone
	    + (selectedPoint.TripDescription ? ('\n\nКак проехать: ' + selectedPoint.TripDescription) : '');

        jQuery('#txtDeliveryAddress').val(deliveryInfo);
		jQuery('#boxberryIndex').val(selectedPoint.Code);

        console.log('Выбран ПВЗ: ' + selectedPoint.Address);
        console.log(selectedPoint);
    }

    function applyKendoControls() {
        var cities;

        jQuery.ajax({
                type: 'POST',
                url: '/Handlers/Ordering/Boxberry/',
                data: {'method':'ListCities' },
                success: function (msg) { cities=msg;},
                failure: function (msg) { console.error(msg); },
                async: false,
                dataType: 'json'
            });

        jQuery('#search-query')
            .kendoComboBox({
                width: 300
                , minLength: 3
                , filter: "contains"
                , placeholder: "Выберите город из списка"
                , change: function (e) {
                    var widget = e.sender;

                    if (widget.value() && widget.select() === -1) {
                        widget.value("");
                    }
                }
                , dataTextField: "Name"
                , dataValueField: "Code"
                , dataSource: cities
            });
    }

    function boxBerryMapDialog(){
        jQuery('#boxberry-map-modal').modal('hide');
    }

    jQuery(document).ready(
		function () {
			jQuery('#btn-search').bind('click', function () { performSearch(); });
			jQuery('#commit-point-btn').bind('click', function () { commitSelectedPoint(); boxBerryMapDialog(); });
			applyKendoControls();
		}
    );

    ymaps.ready(init);
    var bbMap;

    function init() {
        bbMap = new ymaps.Map("boxberry-modal-yandex-map", {
            center: [55.76, 37.64],
            zoom: 8
        });
    }
</script>


@endsection
