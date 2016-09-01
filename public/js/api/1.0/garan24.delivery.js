$.extend(window.garan,{
    delivery:{
        new:function(){
            var t = this, o =arguments.length?arguments[0]:{};
            t.id=(typeof o.id!="undefined")?o.id:"delivery";
            t.name=(typeof o.name!="undefined")?o.name:"#delivery";
            t.description=(typeof o.description!="undefined")?o.description:"#delivery";
            t.cost=(typeof o.cost!="undefined")?o.cost:"#delivery";
            t.duration=(typeof o.duration!="undefined")?o.duration:"#delivery";
        },
        add:function(){
            var o =arguments.length?arguments[0]:{},
            d = {
                id:(typeof o.id!="undefined")?o.id:"delivery",
                name:(typeof o.name!="undefined")?o.name:"#delivery",
                description:(typeof o.description!="undefined")?o.description:"#delivery",
                cost:(typeof o.cost!="undefined")?o.cost:"#delivery",
                duration:(typeof o.duration!="undefined")?o.duration:"#delivery",
            };
            //garan.delivery.list[d.id]=d;
            garan.delivery.list.push(d);
        },
        list:[],
        boxberry:{
            //api.token = 18455.rvpqeafa
            token:'gTVJ0bB4bEy68vCaEqNO3Q==',
            callback:function(boxres){
                console.debug(boxres);
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
            },
            calculateCost:function(){

            }
        }
    }
});
