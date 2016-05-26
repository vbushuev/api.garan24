
<div class="input-group">
    <span class="input-group-addon">
        <input type="checkbox" {{$checked or ''}}name="{{$name or 'checkbox'}}">
    </span>
    <input type="text" readonly="true" class="form-control" placeholder="{{$text or 'Я согласен с Условиями использования сервиса Гаран24.'}}" aria-describedby="sizing-addon1">
</div>
