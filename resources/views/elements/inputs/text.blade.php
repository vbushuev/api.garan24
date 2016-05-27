<div class="input-group {{$required or ''}}">
    <span class="input-group-addon">
        <i class="fa fa-{{$icon or 'envelope-o'}} fa-fw"></i>
    </span>
    <input name="{{$name or 'txtField'}}"
        class="form-control {{$class or ''}}"
        type="{{$type or 'text'}}" 
        placeholder="{{$text or 'Текст'}}">
</div>
