<div class="input-field {{$class or ''}} {{$required or ''}}">

    <input name="{{$name or 'txtField'}}"
        id="{{$name or 'txtField'}}"
        class="{{$class or ''}} {{$required or ''}}"
        type="text"
        placeholder="{{$text or 'Текст'}}"
        value="{{$value or ''}}"
        {{$readonly or ''}}>
</div>
