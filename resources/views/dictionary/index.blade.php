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
        $=jQuery.noConflict();
        var dictionary = {
            _language:'en',
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
                            str+= '<td class="order-field" style="width:4em;">'+q.id+'</td>';
                            str+= '<td class="order-field" style="width:18em;">'+q.created+'</td>';
                            str+= '<td class="order-field" style="width:2em;">'+q.lang+'</td>';
                            str+= '<td class="order-field" style="width:40em;">'+q.original+'</td>';
                            str+= '<td class="order-field" style="width:40em;"><div class="editable-field"><div class="editable-value" data-ref="translate" data-rel="update?id='+q.id+'">'+q.translate+'</div></div></td>';
                            str+= '<td class="order-field" style="width:4em;"><div class="editable-field"><div class="editable-value" data-ref="priority" data-rel="update?id='+q.id+'">'+q.priority+'</div></div></td>';
                            str+= '<td class="order-field" style="width:18em;">'+q.updated+'</td>';
                            str+= '<td class="order-field" style="width:6em;">'+q.status+'</td>';
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
        </tr>
    </table>
@endsection
