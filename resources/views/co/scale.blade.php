<div class="scale-2">
    <div class="scale-2-item helped @if(isset($section)) @if(in_array($section,["delivery","passport","payment","thanks"]))active-last @elseif(isset($section)&&$section=="contact")active @endif @endif" data-helper="helper-contact">
        <a href="/checkout?id={{$deal->order->id or #}}">Контакты</a>
    </div><!--
    --><div class="scale-2-item helped @if(isset($section)) @if(in_array($section,["passport","payment","thanks"]))active-last @elseif(isset($section)&&$section=="delivery")active @endif @endif" data-helper="helper-shipping">
        <a href="/checkout/deliverypaymethod" class="post-link">Доставка</a>
    </div><!--
    --><div class="scale-2-item helped @if(isset($section)) @if(in_array($section,["payment","thanks"]))active-last @elseif(isset($section)&&$section=="passport")active @endif @endif" data-helper="helper-passport">
        <a href="/checkout/passport" class="post-link">Получатель</a>
    </div><!--
    --><div class="scale-2-item helped @if(isset($section)) @if(in_array($section,["thanks"]))active-last @elseif(isset($section)&&$section=="payment")active @endif @endif" data-helper="helper-payment">

        <a href="/checkout/payment" class="post-link">Оплата</a>
    </div>
</div>
