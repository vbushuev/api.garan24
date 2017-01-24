@extends('dictionary.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 statistics"></div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 links">
            <!-- Single button -->
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Язык <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="javascript:{dictionary.lang('en');}">English</a></li>
                    <li><a href="javascript:{dictionary.lang('fr');}">Français</a></li>
                    <li role="separator" class="divider"></li>
                    <!--<li role="separator" class="divider"></li>
                    <li><a href="/manager?status=credit">Выкупленные</a></li>
                    <li><a href="/manager?status=delivered">Доставлены агенту</a></li>
                    <li><a href="/manager?status=boxbery">Отправлены в boxberry</a></li>
                    <li><a href="/manager?status=boxberyhub">Доставлены в boxberry</a></li>
                    <li><a href="/manager?status=shipped">Доставлено клиенту</a></li>
                    <li><a href="/manager?status=payed">Оплачено</a></li>-->
                </ul>
            </div>
        </div>
    </div>
    <script>
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
        $=jQuery.noConflict();
        var dictionary = {
            _language:(typeof urlParams.lang!="undefined")?urlParams.lang:'en',
            getDictionary:function(){
                $.ajax({
                    url:'/dictionary',
                    type:"post",
                    dataType:"json",
                    data:{lang:this._language},
                    beforeSend:function(){
                        $(".phrase").fadeOut().remove();
                        $(".dictionary").append('<tr class="spinner"><td colspan="8"><i class="fa fa-spin fa-spinner fa-2x fa-fw"></i></td></tr>');
                    },
                    success:function(d){
                        var str = '';
                        for(var i in d){
                            var q = d[i];
                            str+= '<tr class="order phrase status-'+q.status+'">';
                            str+= '<td class="order-field" style="width:4em;">'+i+'</td>';
                            str+= '<td class="order-field" style="width:18em;">'+q.created+'</td>';
                            str+= '<td class="order-field" style="width:2em;">'+q.lang+'</td>';
                            str+= '<td class="order-field" style="width:40em;">'+q.original+'</td>';
                            str+= '<td class="order-field" style="width:40em;"><div class="editable-field"><div class="editable-value" data-ref="translate" data-rel="update?id='+q.id+'">'+q.translate+'</div></div></td>';
                            str+= '<td class="order-field" style="width:4em;"><div class="editable-field"><div class="editable-value" data-ref="priority" data-rel="update?id='+q.id+'">'+q.priority+'</div></div></td>';
                            str+= '<td class="order-field" style="width:18em;">'+q.updated+'</td>';
                            str+= '<td class="order-field" style="width:6em;">'+q.status+'</td>';
                            str+= '<td class="order-field" style="width:6em;"><a href="javascript:dictionary.delete('+q.id+')" class="delete" data-rel="delete?id='+q.id+'">Удалить</a></td>';
                            str+='</tr>';
                        }
                        $(".dictionary").append(str);
                        console.debug(typeof initEditable);
                        if(typeof initEditable=="function")initEditable();
                    },
                    complete:function(){
                        $(".spinner").fadeOut().remove();
                    }
                });
            },
            delete:function(idx){
                var t = this;
                $.ajax({
                    url:'/delete',
                    type:"post",
                    dataType:"json",
                    data:{id:idx},
                    beforeSend:function(){
                        $(t).html('<i class="fa fa-spin fa-spinner fa-2x fa-fw"></i>');
                    },
                    success:function(d){
                        console.debug(d);
                        document.location.reload();
                    }
                });
            },
            add:function(idx){
                var args = arguments[0],t = this;;
                $.ajax({
                    url:'/add',
                    type:"post",
                    dataType:"json",
                    data:{
                        lang:this._language,
                        original:args.original,
                        translate:args.translate,
                        priority:args.priority
                    },
                    beforeSend:function(){
                        $(t).html('<i class="fa fa-spin fa-spinner fa-2x fa-fw"></i>');
                    },
                    success:function(d){
                        console.debug(d);
                        document.location.reload();
                    }
                });
            },
            lang:function(l){
                this._language = l;
                this.getDictionary();
            }
        };
        window.dictionary = dictionary;
        $(document).ready(function(){
            dictionary.getDictionary();
        });
    </script>
    <table class="dictionary orders">
        <tr class="order-header">
            <th class="header-field" style="width:4em;">#</th>
            <th class="header-field" style="width:18em;">Создан</th>
            <th class="header-field" style="width:2em;">Язык</th>
            <th class="header-field" style="width:40em;">Оригинал</th>
            <th class="header-field" style="width:40em;">Перевод</th>
            <th class="header-field" style="width:3em;">Приоритет</th>
            <th class="header-field" style="width:18em;">Обновлено</th>
            <th class="header-field" style="width:8em;">Статус</th>
            <th class="header-field" style="width:8em;">&nbsp;</th>
        </tr>
    </table>
@endsection
