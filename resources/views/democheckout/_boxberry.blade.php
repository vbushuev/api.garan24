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
