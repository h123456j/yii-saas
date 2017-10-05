/**
 * Created by huang on 2017/10/4.
 */


$(document).ready(function(){

    $(document).on('click','.li-controller',function(){

    });

    $(document).on('click','.li-action',function(){
        $('.li-action').css({"background-color":"#ffffff","color":"#000000"});
        $(this).css({"background-color":"#848484","color":"#FFFFFF"});
        var json=$(this).attr('data-json');
        var data=JSON.parse(json);
        //console.log(data);
        //template.config("escape", false);
        var html=template("api-doc",data);
        $(".div-right").html(html);
    });

});