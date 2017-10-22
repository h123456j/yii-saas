/**
 * Created by huang on 2017/10/2.
 */


$(document).ready(function () {
    //ajax提交表单
    $('#form-body').on('submit', '.ajax-form', function (e) {
        var _this = this
        $("button[type=submit]").removeClass('btn-primary').unbind('click');
        $(this).ajaxSubmit({
            'success': function (data) {
                $("button[type=submit]").addClass('btn-primary').bind('click');
                if (data)
                    data = JSON.parse(data);
                if ($("#module-login").length > 0) {
                    var data = JSON.parse(data);
                    if (data.ret == true) {
                        window.location.href = BaseUrl + '/admin/index';
                    } else {
                        $('.alert-danger').show();
                    }
                } else {
                    showAlertMessage(data['message']);
                }
            },
            'error': function () {
                $("button[type=submit]").addClass('btn-primary').bind('click');
                showAlertMessage('服务出错') ;
            },
            'beforeSubmit': function () {

            }
        });
        return false;
    });


    $("#btn-message-close").click(function () {
        $("#top-message").hide();
    });

});

function loadShow() {
    $(".div-load").show();
}

function loadHide() {
    $(".div-load").hide();
}

function showAlertMessage(message)
{
    message =message || '提示信息';
    var alertMessage=$("#alert-modal");
    console.log(alertMessage);
    alertMessage.find(".modal-body").html(message);
    alertMessage.modal();
}
