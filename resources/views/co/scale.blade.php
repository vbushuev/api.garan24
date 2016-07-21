<div class="scale">
    <div class="scale-item helped @if(isset($section)&&in_array($section,["contact","delivery","passport","payment"]))active @endif" data-helper="helper-contact">
        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
        Контакты
        <i class="fa fa-angle-right fa-2x" aria-hidden="true"></i>
    </div><!--
    --><div class="scale-item helped @if(isset($section)&&in_array($section,["delivery","passport","payment"]))active @endif" data-helper="helper-shipping">
        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
        Доставка
        <i class="fa  fa-angle-right fa-2x" aria-hidden="true"></i>
    </div><!--
    --><div class="scale-item helped @if(isset($section)&&in_array($section,["passport","payment"]))active @endif" data-helper="helper-passport">
        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
        Паспорт
        <i class="fa  fa-angle-right fa-2x" aria-hidden="true"></i>
    </div><!--
    --><div class="scale-item helped @if(isset($section)&&$section=="payment")active @endif" data-helper="helper-payment">
        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
        Оплата
    </div>
</div>
