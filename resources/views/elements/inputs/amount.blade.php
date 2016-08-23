<div class="input-group amount-currency" {{$required or ''}}>
    <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-euro fa-fw"></i>
        </button>
        <ul class="dropdown-menu">
            <li><a data-value="EUR"><i class="fa fa-euro fa-fw"></i><span class="combo-item-value"> Евро</span></a></li>
            <li><a data-value="GBP"><i class="fa fa-gbp fa-fw"></i><span class="combo-item-value"> Фунт</span></a></li>
            <li><a data-value="USD"><i class="fa fa-usd fa-fw"></i><span class="combo-item-value"> Доллар</span></a></li>
        </ul>

    </div>
    <input name="amount" id="amount" class="form-control amount" type="text" placeholder="{{$text or 'Текст'}}" value="" {{$readonly or ''}}>
    <input type="hidden" name="currency" value="EUR" />
</div>
