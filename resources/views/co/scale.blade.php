<div class="scale">
    <div class="scale-item helped @if(isset($section)&&in_array($section,["contact","delivery","passport","payment","thanks"]))active @endif" data-helper="helper-contact">
        @if(isset($section))
            @if(in_array($section,["delivery","passport","payment","thanks"]))
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            @elseif($section=="contact")
            <i class="fa fa-circle-o" aria-hidden="true"></i>
            @endif
        @endif
        Контакты
        <i class="fa fa-angle-right fa-2x" aria-hidden="true"></i>
    </div><!--
    --><div class="scale-item helped @if(isset($section)&&in_array($section,["delivery","passport","payment","thanks"]))active @endif" data-helper="helper-shipping">
        @if(isset($section))
            @if(in_array($section,["passport","payment","thanks"]))
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            @elseif($section=="delivery")
            <i class="fa fa-circle-o" aria-hidden="true"></i>
            @endif
        @endif
        Доставка
        <i class="fa  fa-angle-right fa-2x" aria-hidden="true"></i>
    </div><!--
    --><div class="scale-item helped @if(isset($section)&&in_array($section,["passport","payment","thanks"]))active @endif" data-helper="helper-passport">
        @if(isset($section))
            @if(in_array($section,["payment","thanks"]))
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            @elseif($section=="passport")
            <i class="fa fa-circle-o" aria-hidden="true"></i>
            @endif
        @endif
        Паспорт
        <i class="fa  fa-angle-right fa-2x" aria-hidden="true"></i>
    </div><!--
    --><div class="scale-item helped @if(isset($section)&&in_array($section,["payment","thanks"]))active @endif" data-helper="helper-payment">
        @if(isset($section))
            @if(in_array($section,["thanks"]))
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            @elseif($section=="payment")
            <i class="fa fa-circle-o" aria-hidden="true"></i>
            @endif
        @endif
        Оплата
    </div>
</div>
