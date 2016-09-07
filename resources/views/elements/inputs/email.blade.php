
<div class="input-field email {{$required or ''}}">

    <input name="{{$name or 'txtField'}}"
        id="{{$name or 'txtField'}}"
        class="email"
        type="text"
        placeholder="{{$text or 'Текст'}}"
        value="{{$value or ''}}"
        {{$readonly or ''}}>
</div>
