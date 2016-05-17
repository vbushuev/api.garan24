@extends('layouts.master')

@section('title', 'Garan24 Checkout')

@section('sidebar')

@endsection

@section('content')

@endsection
@section('scripts')
<script src="js/api/1.0/garan24.core.js"></script>
<script src="js/jquery.blockUI.js"></script>
<script type="text/javascript">
        //$( "body" ).append("<iframs src='https:///garan24.ru/service/public/checkout'></iframs>").dialog({
        $.ajax({
            url:"http:///api.garan24.bs2/checkout",
            async:true,
            method:'get',
            beforSend:function(){
                $.blockUI({
                    message: "<i class=\"fa fa-spinner fa-spin fa-3x fa-fw\"></i><span class=\"sr-only\">Loading...</span>Thank you for your order. We are now redirecting you to Garan24 to make payment.",
                });
            },
            success:function(d,t,jx){
                $(".overlay").append(d).dialog({
                    modal:true
                });
            },
            complete:function(){
                $.unblockUI();
            }
        });
        /*$("<iframe src='http:///api.garan24.bs2/checkout'></iframe>").dialog({
        	width: 800,
            modal: true
        });*/
        /*var block = $.blockUI({
                message: "<i class=\"fa fa-spinner fa-spin fa-3x fa-fw\"></i><span class=\"sr-only\">Loading...</span>Thank you for your order. We are now redirecting you to Garan24 to make payment.",
                overlayCSS:{
                    background: "#fff",
                    opacity: 0.6
                },
                css: {
                    padding:        20,
                    textAlign:      "center",
                    color:          "#555",
                    border:         "3px solid #aaa",
                    backgroundColor:"#fff",
                    lineHeight:"32px"
                }
        });*/
        //console.debug("redirect to '.$environment_url.' with data "+JSON.stringify('.$json_data.'));
        var jdata={};
        //jQuery.redirect("'.$environment_url.'",JSON.stringify(jdata));

        //jQuery.post({url:"'.$environment_url.'",data:jdata});
</script>
@endsection
