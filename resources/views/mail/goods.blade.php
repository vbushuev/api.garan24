@if($deal->order->getProducts()!==null)
    <table style="border-collapse: collapse;width: 100%;font-size: 14pt;border-style:solid;border-width: 1px;border-color: rgba(85,125,161,1);margin-bottom: 1em;">

        <thead>
            <tr>
                <th style="border-style:solid;border-width:1px;border-color:rgba(85,125,161,1);height: 3em;line-height: 3em;text-align: center;font-weight: 700;font-size: 16pt; width:20%;">&nbsp;</th>
                <th style="border-style:solid;border-width:1px;border-color:rgba(85,125,161,1);height: 3em;line-height: 3em;text-align: center;font-weight: 700;font-size: 16pt; width:40%;">Наименование</th>
                <th style="border-style:solid;border-width:1px;border-color:rgba(85,125,161,1);height: 3em;line-height: 3em;text-align: center;font-weight: 700;font-size: 16pt; width:15%;">Кол-во</th>
                <th style="border-style:solid;border-width:1px;border-color:rgba(85,125,161,1);height: 3em;line-height: 3em;text-align: center;font-weight: 700;font-size: 16pt; width:25%;">Стоимость<div style="display:none;">{{$total_amount=0}}</div></th>
            </tr>
        </thead>
        <tbody>
            @foreach($deal->order->getProducts() as $good)
            <tr>
                <td style="border-style:solid;border-width:1px;border-color:rgba(85,125,161,1);padding:.4em 1em;width:20%;text-align: center;"><img height="100px"; src="{{$good["product_img"] or $good["featured_src"]}}" alt="{{$good["title"] or $good['name']}}"></td>
                <td style="border-style:solid;border-width:1px;border-color:rgba(85,125,161,1);padding:.4em 1em;width:40%;">{{$good["title"] or $good["name"]}}</td>
                <td style="border-style:solid;border-width:1px;border-color:rgba(85,125,161,1);padding:.4em 1em;width:15%;text-align: center;">{{$good["quantity"]}} шт.</td>
                <td style="border-style:solid;border-width:1px;border-color:rgba(85,125,161,1);padding:.4em 1em;width:25%;text-align: right;font-weight: 700;">@amount($good["regular_price"])<div style="display:none;">{{$total_amount+=$good["regular_price"]*$good["quantity"]}}</div></td>
            </tr>

            @endforeach
            @if(isset($deal->shipping_cost)&&strlen($deal->shipping_cost)>0)
            <tr>
                <td>&nbsp;</td>
                <td style="text-align: right;">
                    Доставка <b>{{$deal->delivery["name"]}}</b><br />
                    <small>{{$deal->getCustomer()->toAddressString()}}</small>
                </td>
                <td>&nbsp;</td>
                <td style="text-align: right;font-weight: 700;">@amount($deal->shipping_cost)<div style="display:none;">{{$total_amount+=$deal->shipping_cost}}</div></td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th style="padding:.4em 1em;font-size: 16pt;">Итоговая сумма</th>
                <th></th>
                <th style="padding:.4em 1em;font-size: 16pt; text-align: right;font-weight: 700;">@amount($total_amount)</th>
            </tr>
        </tfoot>
    </table>
@endif
