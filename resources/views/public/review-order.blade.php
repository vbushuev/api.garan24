@if(isset($order) )
    <section>
        <div class="title">Your order</div>
        <table class="review-order">
            <tr>
                <th>&nbsp;</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            @foreach ($order as $item)
                <tr>
                    <td>@if(isset($item['img']))
                            <img src="{{$item['img']}}" alt="{{$item['name']}}" width="48px"/>
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td>{{$item['name']}}</td>
                    <td>
                        @if($item['currency']=='eur') <i class="fa fa-euro"></i>
                        @elseif($item['currency']=='usd') <i class="fa fa-usd"></i>
                        @elseif($item['currency']=='rub') <i class="fa fa-rub"></i>
                        @endif
                        {{$item['price']}}
                    </td>
                    <td>{{$item['quantity']}}</td>
                    <td>
                        @if($item['currency']=='eur') <i class="fa fa-euro"></i>
                        @elseif($item['currency']=='usd') <i class="fa fa-usd"></i>
                        @elseif($item['currency']=='rub') <i class="fa fa-rub"></i>
                        @endif
                        {{$item['price']*$item['quantity']}}
                    </td>
                </tr>
            @endforeach
            <tr>
                <th colspan="5">&nbsp;</th>
            </tr>
        </table>
    </section>
    @else
        No items in order
    @endif
