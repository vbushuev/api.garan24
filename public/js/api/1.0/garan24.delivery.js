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
                duration:(typeof o.duration!="undefined")?o.duration:"#delivery"
            };
            garan.delivery.list[d.id]=d;
        },
        list:[]
    }
});
