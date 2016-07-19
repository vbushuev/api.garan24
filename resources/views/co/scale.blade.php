<ul class="scale">
    <li class="scale-item helped @if(isset($section)&&in_array($section,["contact","delivery","passport","payment"]))active @endif" data-helper="helper-contact">
        <!--@if(isset($section)&&$section=="contact")
            <i class="fa fa-circle" aria-hidden="true"></i>

        @else
            <i class="fa fa-circle-o" aria-hidden="true"></i>
        @endif-->
        Контакты
        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
    </li>
    <li class="scale-item helped @if(isset($section)&&in_array($section,["delivery","passport","payment"]))active @endif" data-helper="helper-shipping">Доставка<i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
    <li class="scale-item helped @if(isset($section)&&in_array($section,["passport","payment"]))active @endif" data-helper="helper-passport">Паспорт<i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
    <li class="scale-item helped @if(isset($section)&&$section=="payment")active @endif" data-helper="helper-payment">Оплата</li>
</ul>
