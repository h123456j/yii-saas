/**
 * Created by huang on 2017/10/29.
 */


$(document).ready(function(){

    var dateTimePicker=$(".datetimepick");
    dateTimePicker.attr('readonly',true);
    dateTimePicker.datetimepicker({
        language:'cn',
        todayBtn:true,
        format: 'yyyy-mm-dd',
        minView:2,
        autoclose:true
    });
});