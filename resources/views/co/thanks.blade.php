@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
<input type="hidden" id="TotalAmountHidden" name="TotalAmountHidden"/>
<input type="hidden" id="ShippingAmountHidden" name="shipping_cost" value="{{$deal->shipping_cost or ''}}"/>
    <h3><i class="first">Что</i> дальше?</h3>
    <p>
        <i class="first">Проверьте</i> почту, Вам придет письмо от <span class="brand">Гаран24</span> с подтверждением Вашего заказа и ссылкой на Ваш Личный Кабинет.
    </p>
    <p>
        <i class="first">Отслеживайте</i> Ваш заказ в <a href="https://garan24.ru/my-account/">в личном кабинете <span class="brand">Гаран24</span></a>
    </p>
    <p>
        <i class="first">Остались</i> вопросы? Звоните по тел. <a href="tel:+7 499 110 2263">+7 499 110 2263</a>
    </p>
    <div class="row" style="margin:1em 0;">
        <button id="forward" class="btn btn-success btn-lg pull-right">Вернуться в магазин</button>
        <input id="payment_id" name="payment_id" type="hidden"/>
        <script>
            $("#back").on("click",function(){$("#payment_id").val(1);});
            $("#forward").on("click",function(){$("#payment_id").val(6);});
            window.garan_submit_args= {
                form:$("#form"),
                url:"{{$route["dir"].$route["next"]["href"]}}"
            };
            $(document).ready(function(){
                $("#forward").click(function(){
                    document.location.href='{{$shop_url}}'
                })
            });
        </script>
    </div>
@endsection
