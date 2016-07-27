<script type="text/javascript" src="//points.boxberry.de/js/boxberry.js"> </script/>
<script>
    var bbRexEx = /(\d+)\,(.+?)\,(.+)/i;
    function boxberry_callback(bb){
        //bb.name = encodeURIComponent(bb.name) // Что бы избежать проблемы с кириллическими символами, на страницах отличными от UTF8, вы можете использовать функцию encodeURIComponent()
        $("#boxberry_name").val(bb.name);
        $("#boxberry_address").val(bb.address);
        $("#boxberry_workschedule").val(bb.workschedule);
        $("#boxberry_phone").val(bb.phone);
        $("#boxberry_period").val(bb.period);
        $("#boxberry_id").val(bb.id);

        var delivery_address = 'Доставка <b>Boxberry</b> ПВЗ <strong>'+bb.name+'</strong>';
        delivery_address+= "<br /><small>"+bb.address+"</small>";
        var delivery_address_2 = "<br /><small>"+bb.workschedule+"</small>";
        delivery_address_2+= "<br /><small>тел. "+bb.phone+"</small>";
        delivery_address_2+= "<br /><small>Срок: "+bb.period+" дн.</small>";
        delivery_address+= delivery_address_2;
        var price = parseInt(bb.price);
        $("#ShippingAmountHidden").val(bb.price);

        $("#cart-shipping .total").html(delivery_address);
        $("#cart-shipping .amount").html(price.format(0,3,' ','.')+" руб.");
        calculateTotal();
        var shipping = bb.address.split(",");
        if(shipping.length){
            $("#boxberry_postcode").val(shipping[0]);
            $("#boxberry_city").val(shipping[1]);
            var addr = [];
            for(var i=2;i<shipping.length;++i)addr[i-2]=shipping[i];
            $("#boxberry_address_1").val(addr.join());
            $("#boxberry_address_2").val(delivery_address_2);
            //$("#boxberry_address_1").val(delivery_address);
        }
        /*document.getElementById('city').innerHTML = bb.name;
        document.getElementById('js-pricedelivery').innerHTML = bb.price;
        document.getElementById('code_pvz').innerHTML = bb.id;



        document.getElementById('name').innerHTML =	bb.name;
        document.getElementById('address').innerHTML =	bb.address;
        document.getElementById('workschedule').innerHTML =	bb.workschedule;
        document.getElementById('phone').innerHTML = bb.phone;
        document.getElementById('period').innerHTML = bb.period;
        if (bb.prepaid=='Yes') {
            alert('Отделение работает только по предоплате!');
        }*/
    }
    $(document).ready(function(){
        $("#delivery-type-4").on("click",function(){
            boxberry.open(boxberry_callback,garan.delivery.boxberry.token,'Москва',77961);
        });
    });
</script>
