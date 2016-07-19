@extends($viewFolder.'.layout',["shop_url"=>$shop_url])
@section('content')
<style>
    .description, .description_shot {
        display: none;
        border: solid 1px rgba(0,0,0,.2);
        color: rgba(0,0,0,.6);
        font-size: 100%;
        padding: .4em;
        margin: 0 0 0 1.4em;
    }
</style>
    <div class="row">
        <h3><i class="first">Способ</i> получения <i class="fa fa-bus" aria-hidden="true"></i></h3>
        <div id="delivery_types" class="list-group required">
            @foreach($delivery as $it)
                <a href="#" class="list-group-item" id="delivery-type-{{$it["id"]}}" data-id="{{$it["id"]}}" data-desc="{{$it["desc"]}}">
                    <h4 class="list-group-item-heading"><i class="fa fa-square-o"></i> {{$it["name"]}}</h4>
                    <p class="list-group-item-text small">{{$it["desc"]}}</p>
                </a>
            @endforeach
        </div>
        @include($viewFolder.'.address')
        @include($viewFolder.'._boxberry')
    </div>
    <div class="row payment">
        <h3><i class="first">Способ</i> оплаты <i class="fa fa-credit-card" aria-hidden="true"></i></h3>
        <div id="payment_types" class="list-group required">
            @foreach($payments as $it)
                <a href="#" class="list-group-item" data-id="{{$it["id"]}}" data-desc="{{$it["desc"]}}">
                    <h4 class="list-group-item-heading">
                        <i class="fa fa-square-o"></i>
                        {{$it["name"]}}
                    </h4>
                    <p class="list-group-item-text small">{{$it["desc"]}}</p>
                </a>
            @endforeach
        </div>
    </div>

    <input type="hidden" id="delivery_type_id" name="delivery_type_id" />
    <input type="hidden" id="delivery_type_name" name="delivery_type_name" />
    <input type="hidden" id="delivery_type_desc" name="delivery_type_desc" />
    <input type="hidden" id="payment_type_id" name="payment_type_id" />
    <input type="hidden" id="payment_type_name" name="payment_type_name" />
    <input type="hidden" id="payment_type_desc" name="payment_type_desc" />
    @include("$viewFolder._buttons")
    <script>
        $(document).ready(function(){
            $(".row.payment").hide();
            //$("#forward").prop('disabled', true);
            $("#delivery_types .list-group-item").on("click",function(){
                $("#delivery_type_id").val($(this).attr("data-id"));
                console.debug($(".row.payment"));
                $(".row.payment").show();
                return false;
            });
            $("#payment_types .list-group-item").on("click",function(){
                $("#forward").prop('disabled', false);
                $("#payment_type_id").val($(this).attr("data-id"));
                return false;
            });
        });
    </script>
@endsection
