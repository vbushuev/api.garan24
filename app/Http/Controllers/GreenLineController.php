<?php

namespace App\Http\Controllers;

use Log;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use WC_API_Client;
use WC_API_Client_Exception;
use WC_API_Client_Resource_Orders;
use WC_API_Client_Resource_Customers;
use WC_API_Client_Resource_Products;


class GreenLineController extends Controller{
    public function __construct(){
        $this->middleware('cors');
    }
    public function getIndex(Request $rq){

        $r=[
            'yandexCounterId' => '40823799',
            'site' => $rq->input('site','brandalley'),
            'shipping' => '<h3>Доставка</h3>
                <p>Все заказанные Вами товары поступают на наш европейский склад, где мы проверим их соответствие заказу, тщательно упакуем и отправим посылку по указанному Вами адресу в Россию. Доставка заказов по России осуществляется компанией Боксберри.</p>
                <p>Вы можете выбрать один из двух вариантов доставки:</p>
                <ul>
                    <li><strong>Курьерская доставка по указанному Вами адрес</strong> <em>(При выборе курьерской доставки Ваш заказ будет доставлен курьером, который предварительно свяжется с Вами для уточнения времени доставки)</em></li>
                    <li><strong>Доставка до выбранного Вами Пункта выдачи заказов (ПВЗ)</strong> <em>При выборе получения заказа в ПВЗ Вы получите СМС сообщение, когда заказ будет доставлен в Пункт выдачи заказов. Забрать заказ Вы сможете в течение 7 дней, включая день его поступления в ПВЗ.</em></li>
                </ul>
                <script type="text/javascript" src="//points.boxberry.de/js/boxberry.js"> </script/>
                <script>
                    function boxberry_open(){
                        xG.hide({class:"bs-overlay"});
                        boxberry.open(boxberry_callback,garan.delivery.boxberry.token,"Москва",0);
                    }
                    function boxberry_callback(){}
                </script>
                <p><a href="javascript:boxberry_open()"><i class="fa fa-external-link" style="color:#aaa;"></i> Проверьте есть ли в Вашем городе Боксберри</a></p>
                <p>Получить информацию о текущем статусе доставки заказа Вы в любой момент можете в личном кабинете на сайте сервиса <a href="http://www.gauzymall.com/" target="_blank">www.gauzymall.com</a>. Как правило, срок доставки заказа не превышает 20 дней. Стоимость доставки рассчитывается автоматически и включается в его общую стоимость заказа.</p>',
            'payment' => '
                <h3>Оплата</h3>
                <p>Оплата заказа производится банковской картой. Для оплаты подойдет карта любого российского банка, поддерживающая технологию 3D-Secure для безопасных платежей в интернете.</p>
                <p>Все клиенты нашего сервиса могут оплатить заказ после его доставки, но у Вас также будет возможность оплатить заказ сразу же при его оформлении.</p>
                <p>Если Вы выберете <strong>«Оплату после доставки»</strong>, то стоимость заказа и его доставки будет списана с Вашей банковской карты на следующий день после того, как Вы получите свой заказ. При выборе данного варианта оплаты Вам нужно будет при оформлении заказа указать данные Вашей карты. Мы проверим карту, проведя операцию на небольшую сумму (1 рубль). В дальнейшем Вам нужно будет просто обеспечить наличие на карте средств, достаточных для оплаты заказа.</p>
                <p>Если Вы выберете <strong>«Оплатить сейчас»</strong>, то мы сразу же спишем с Вашей карты стоимость заказа и предварительно рассчитанную стоимость доставки. Учитывая, что стоимость доставки будет пересчитана после поступления товаров на наш склад с учетом их точного веса, мы спишем с Вашей карты дополнительно разницу между предварительной и точной стоимостью доставки после получения Вами заказа, или вернем ее на Вашу карту, если уточненная стоимость доставки будет меньше рассчитанной предварительно.</p>
                <p>Оплата картой производится с соблюдением всех требований безопасности международных платежных систем при содействии нашего партнера в России – ООО «Гаран 24», обеспечивающего безопасное проведение операций с использованием карт.</p>',
            'howtobuy' => '<h3>Как купить</h3>
                <p>Заказ оформляется непосредственно на сайте <strong>BrandAlley</strong> с помощью сервиса Gauzymall, с сохранением всех скидок на продукцию, предлагаемых в оригинальном интернет-магазине.</p>
                <p>Просматривайте и выбирайте товары так же, как и на сайте любого интернет-магазина. Найдя понравившийся Вам товар, нажмите кнопку <strong style="color: #0C7DCB;">«AJOUTER AU PANIER»</strong> (добавить в корзину).</p>
                <p>Для оформления доставки перейдите в корзину (нажмите на логотип корзины в правом верхнем углу экрана) и нажмите кнопку <strong style="color: #0C7DCB;">«Оформить заказ»</strong>. Дальше следуйте инструкциям, которые пошагово будут показываться на экране и помогут Вам оформить заказ - введите адрес электронной почты и номер мобильного телефона, выберите способ доставки, укажите адрес, по которому желаете получить заказ. Для того, чтобы ваш заказ мог пересечь границу, укажите свои паспортные данные. Вы можете оплатить заказ сразу или при получении. Требуется банковская карта.</p>
                <p>После того, как заказ будет оформлен, наш сотрудник проверит все параметры заказа и свяжется с Вами по телефону для его подтверждения и уточнения деталей.</p>
                <p>В следующий раз оформить заказ будет проще – мы сохраним данные о получателе заказа и адресе доставки, и Вам не придется вводить их повторно.</p>
                <p style="text-align:center;"><strong>Успешных покупок!</strong></p>',
            "sale" => '<h3 style="color: rgb(214, 69, 65);">Акция</h3>
                <p class="text-center"><strong>Уникальное предложение от сервиса Gauzymall при покупке товаров от BrandAlley:</strong></p>
                <p class="text-center" style="margin-top: 8px;"><strong> - Оформление заказа без комиссии!</strong></p>
                <p class="text-center" style="margin-top: 8px;"><strong> - Оплата после доставки заказа!</strong></p>
                <p>Заказ оформляется непосредственно на сайте <strong>BrandAlley</strong> с помощью сервиса Gauzymall, с сохранением всех скидок на продукцию, предлагаемых в оригинальном интернет-магазине.</p>
                <p class="text-center"><strong>Сделайте заказ прямо сейчас. Предложение ограничено.</strong></p>
                <p class="text-center">Модные бренды со скидкой до 80%!</p>
                <p>Интернет-магазин <strong>BrandAlley</strong> полностью оправдывает свое название – это настоящая аллея брендов с доступными ценами, отменным качеством и широким ассортиментом. Всего представлено более 300 известных брендов. В магазине постоянно проводятся распродажи со скидкой до 80 - 90%, которым посвящен отдельный раздел. Товары, продающиеся со значительными скидками, есть и в каждой группе товаров магазина.</p>
                <p>По ассортименту <strong>BrandAlley</strong> - это семейный магазин, где Вы сможете купить стильные вещи и подарки для всех взрослых членов семьи и для детей. В магазине продается одежда, обувь, нижнее белье, сумки и аксессуары, игрушки, предметы интерьера и многое другое. </p>
                <p>Интернет магазин <strong>BrandAlley</strong> каждый месяц посещает более 7 миллионов покупателей.</p>
                <p>Присоединяйтесь!</p>',
            'installments' => '<h3>Уважаемый клиент!</h3>
                <div class="row">
                    Gauzymall планирует предложить покупателям возможность приобретения товаров в рассрочку. Рассрочка будет предоставляться на сумму до 100% от стоимости заказа и на срок до 6 месяцев с ежемесячным погашением. Нам очень важно узнать Ваше мнение, чтобы предложить Вам эту услугу.
                </div>
                <div class="row bs-message list-group">
                    Просим ответить на несколько вопросов:
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 list-group-item">
                        <h4>При какой сумме покупки Вам будет интересно получить рассрочку оплаты заказа?</h4>
                        <div class="bs-input-field bs-rub"><input name="credit_amount" id="credit_amount" type="number" placeholder="0.00"></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 list-group-item">
                        <h4>На сколько месяцев Вы желаете получить рассрочку оплаты заказа?</h4>
                        <div class="bs-input-field bs-calendar"><input name="credit_month" id="credit_month" type="number" placeholder="6"></div>
                    </div>
                </div>
                <div class="row bs-message">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        Если Вы желаете поучаствовать в тестировании услуги и получить рассрочку на льготных условиях, оставьте свой адрес электронной почты:
                        <div class="bs-input-field bs-email"><input name="credit_email" id="credit_email" type="text" placeholder="Ваш email"></div>
                    </div>
                </div>
                <div class="row bs-message">
                    <a class="bs-btn pull-right" href="javascript:socialCreditQuestion("credit-form");" id="credit-button">Спасибо!</a>
                </div>',
        ];
        //$cart = DB::table('garan24_cart')->where("id",$id)->first();
        return view("greenline.index",$r);
        //return response()->json($r,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
}
?>
