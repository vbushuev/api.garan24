<div class="input-group {{$required or ''}}">
    <span class="input-group-addon">
        <i class="fa fa-{{$icon or 'square-o'}} fa-fw"></i>
    </span>
    <input name="{{$name or 'txtField'}}"
        id="{{$id or 'txtField'}}"
        class="form-control {{$class or ''}}"
        type="{{$type or 'text'}}"
        placeholder="{{$text or 'Текст'}}"
        value="{{$value or ''}}"
        {{$readonly or ''}}>
</div>
