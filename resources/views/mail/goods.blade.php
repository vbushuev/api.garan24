@if($deal->order->getProducts()!==null)
    <style>
        table{
            width: 100%;
            font-size: 14pt;
            border: solid 1px rgba(85,125,161,1);
            margin-bottom: 1em;
        }
        table thead tr th {
            border: solid 1px rgba(85,125,161,1);
            height: 3em;
            line-height: 3em;
            text-align: center;
            font-weight: 700;
            font-size: 16pt;
        }
        table thead tr th.image{width:20%;}
        table thead tr th.name{width:40%;}
        table thead tr th.quantity{width:15%;}
        table thead tr th.amount{width:25%;}
        table tbody tr td{
            border: solid 1px rgba(85,125,161,1);
            padding:.4em 1em;
        }
        table tbody tr td.image{
            text-align: center;
        }
        table tbody tr td.image img{
            height:100px;

        }
        table tbody .name{}
        table tbody .quantity{text-align: center;}
        table tbody .amount,table tfoot .amount{
            text-align: right;
            font-weight: 700;
        }
        table tfoot tr th{
            padding:.4em 1em;
            font-size: 16pt;
        }
    </style>
    <table>
        <div class="hide">{{$total_amount=0}}</div>
        <thead>
            <tr>
                <th class="image">&nbsp;</th>
                <th class="name">Наименование</th>
                <th class="quantity">Кол-во</th>
                <th class="amount">Стоимость</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deal->order->getProducts() as $good)
            <tr>
                <td class="image"><img src="{{$good["product_img"] or $good["featured_src"]}}" alt="{{$good["title"] or $good['name']}}"></td>
                <td class="name">{{$good["title"] or $good["name"]}}</td>
                <td class="quantity">{{$good["quantity"]}} шт.</td>
                <td class="amount">@amount($good["regular_price"])</td>
            </tr>
            <div class="hide">{{$total_amount+=$good["regular_price"]*$good["quantity"]}}</div>
            @endforeach
            @if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
            <tr>
                <td>&nbsp;</td>
                <td class="total-name">
                    Доставка <b>{{$deal->delivery["name"]}}</b><br />
                    <small>{{$deal->getCustomer()->toAddressString()}}</small>
                </td>
                <td>&nbsp;</td>
                <td class="amount">@amount($deal->shipping_cost)</td>
            </tr>
            <div class="hide">{{$total_amount+=$deal->shipping_cost}}</div>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Итоговая сумма</th>
                <th></th>
                <th class="amount">@amount($total_amount)</th>
            </tr>
        </tfoot>
    </table>
@endif
