jQuery.noConflict();
(function($){
    String.prototype.firstLetterUpper = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    }
    var urlParams;
    (window.onpopstate = function () {
        var match,
            pl     = /\+/g,  // Regex for replacing addition symbol with a space
            search = /([^&=]+)=?([^&]*)/g,
            decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
            query  = window.location.search.substring(1);
            urlParams = {};
            while (match = search.exec(query))
                urlParams[decode(match[1])] = decode(match[2]);
    })();
    function Product(p){
        this.images = p.images.split(/,/g);
        this.categories = p.categories.split(/\//g);
        this.currency
        this.h='<div id="product_'+p.id+'" data-ref="'+p.g_sku+'" class="product col-xs-12 col-sm-6 col-md-4 col-lg-4">';
        this.h+='<div class="product-container">';
        this.h+='<a href="'+p.g_url+'">';
        this.h+='<img src="'+this.images[0]+'" alt="'+p.title+'"/>';
        this.h+='</a>';
        this.h+='<span class="brand">'+p.brand+'</span>';
        this.h+='<span class="title">'+p.g_title.firstLetterUpper()+'</span>';
        this.h+='<span class="price '+p.currency+'">'+p.sale_price+'</span>';
        this.h+='<strike class="price '+p.currency+'">'+p.original_price+'</strike>';
        this.h+='</div>';
        this.h+='</div>';
        this.html=function(){return this.h;};
    }
    var g={

    };
    $(document).ready(function(){
        $.ajax({
            url:"/gcat/products",
            data:{
                rows:90,
                page:0
            },
            success:function(r,x,c){
                for(var i in r){
                    var p = new Product(r[i]);
                    console.debug(r[i]);
                    $("#content").append(p.html());
                }
            }
        });
    });
})(jQuery);


//<div id="form" class="form col-xs-12 col-sm-12 col-md-12 col-lg-12">
