<div class="scale">
    <div class="scale-item arrow_box helped @if(isset($section)&&in_array($section,["contact","delivery","passport","payment"]))active @endif" data-helper="helper-contact">
        Контакты
        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
    </div><!--
    --><div class="scale-item arrow_box helped @if(isset($section)&&in_array($section,["delivery","passport","payment"]))active @endif" data-helper="helper-shipping">Доставка <i class="fa fa-angle-double-right" aria-hidden="true"></i></div><!--
    --><div class="scale-item arrow_box helped @if(isset($section)&&in_array($section,["passport","payment"]))active @endif" data-helper="helper-passport">Паспорт <i class="fa fa-angle-double-right" aria-hidden="true"></i></div><!--
    --><div class="scale-item arrow_box helped @if(isset($section)&&$section=="payment")active @endif" data-helper="helper-payment">Оплата</div>
</div>
