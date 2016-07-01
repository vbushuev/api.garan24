<script type="text/javascript" src="//points.boxberry.ru/js/boxberry.js"> </script/>
<script>

    function boxberry_callback(result){
        Number.prototype.format = function(n, x, s, c) {
            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                num = this.toFixed(Math.max(0, ~~n));
            return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
        };
        $("#city").val(result.name);
        $("#address_1").val(result.address);
        $("#totalDeliveryPrice").html(result.price+" руб.");
        console.debug(result.price);
        var total = 0;
        $(".productPrice").each(function(){
            total+=parseInt($(this).text().replace(/\s+/ig,''));
        });
        total += parseInt(result.price);
        console.debug(total);
        $("#lblTotalPrice").html(total.format(0,3,' ','.'));
        //$("#lblTotalPrice").html(total);
        /*document.getElementById('city').innerHTML = result.name;
        document.getElementById('js-pricedelivery').innerHTML = result.price;
        document.getElementById('code_pvz').innerHTML = result.id;

        result.name = encodeURIComponent(result.name) // Что бы избежать проблемы с кириллическими символами, на страницах отличными от UTF8, вы можете использовать функцию encodeURIComponent()

        document.getElementById('name').innerHTML =	result.name;
        document.getElementById('address').innerHTML =	result.address;
        document.getElementById('workschedule').innerHTML =	result.workschedule;
        document.getElementById('phone').innerHTML = result.phone;
        document.getElementById('period').innerHTML = result.period;
        if (result.prepaid=='Yes') {
            alert('Отделение работает только по предоплате!');
        }*/
    }
</script>
<a href="#" onclick="boxberry.open(boxberry_callback,garan.delivery.boxberry.token,'Москва',77961); return false;">Выбрать пункт выдачи на карте</a>
<input type="hidden" name="billing[country]" value="RU" />
<input type="hidden" id="city" name="billing[city]" value="Москва" />
<input type="hidden" id="address_1" name="billing[address_1]" value="" />
<input type="hidden" id="postcode" name="billing[postcode]" value="" />
