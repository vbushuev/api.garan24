<div class="scale-2">
    <div class="scale-2-item helped @if(isset($section)) @if(in_array($section,["delivery","passport","payment","thanks"]))active-last @elseif(isset($section)&&$section=="contact")active @endif @endif" data-helper="helper-contact">
        Контакты
    </div><!--
    --><div class="scale-2-item helped @if(isset($section)) @if(in_array($section,["passport","payment","thanks"]))active-last @elseif(isset($section)&&$section=="delivery")active @endif @endif" data-helper="helper-shipping">
        Доставка
    </div><!--
    --><div class="scale-2-item helped @if(isset($section)) @if(in_array($section,["payment","thanks"]))active-last @elseif(isset($section)&&$section=="passport")active @endif @endif" data-helper="helper-passport">
        Паспорт
    </div><!--
    --><div class="scale-2-item helped @if(isset($section)) @if(in_array($section,["thanks"]))active-last @elseif(isset($section)&&$section=="payment")active @endif @endif" data-helper="helper-payment">
        Оплата
    </div>
</div>
