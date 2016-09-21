<div class="input-field {{$class or ''}} {{$required or ''}} {{$icon or 'default'}}">

    <input name="{{$name or 'txtField'}}"
        id="{{$name or 'txtField'}}"
        class="{{$class or ''}} {{$required or ''}}"
        type="{{$type or 'text'}}"
        placeholder="{{$text or 'Текст'}}"
        value="{{$value or ''}}"
        {{$readonly or ''}}>
</div>
