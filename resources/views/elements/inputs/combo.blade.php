<div class="btn-group combo {{$required or ''}}">
  <a class="btn btn-default"><i class="fa fa-map fa-fw"></i> <span class="combo-value">{{$text or 'Select'}}</span></a>
  <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
    <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
  </a>
  <ul class="dropdown-menu">
      @foreach ($values as $value)
        @if($value==='divider')
            <li class="divider"></li>
        @else
            <li><a data-value="{{$value['key'] or $value['value']}}"><i class="fa fa-{{$value['icon'] or 'square-o'}} fa-fw"></i> <span class="combo-item-value">{{$value['value'] or 'Value'}}</span></a></li>
        @endif
      @endforeach
  </ul>
  <input type="hidden" name="{{$name or 'combo'}}" />
</div>
