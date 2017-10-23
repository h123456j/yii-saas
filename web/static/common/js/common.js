/**
 * Created by huang on 2017/10/2.
 */


$(document).ready(function () {
    //ajax提交表单
    $('#form-body').on('submit', '.ajax-form', function () {
        var _this = $(this);
        var closeContentModal = _this.hasClass('close-content-modal');
        loadShow();
        $("button[type=submit]").removeClass('btn-primary').unbind('click');
        $(this).ajaxSubmit({
            'success': function (data) {
                $("button[type=submit]").addClass('btn-primary').bind('click');
                if (data)
                    data = JSON.parse(data);

                if (data['status'] == 1) {
                    if ($("#module-login").length > 0) {
                        window.location.href = BaseUrl + '/admin/index';
                    } else {
                        AlertMessageModal.showAlertMessage(data['message']);
                        if (closeContentModal)
                            AlertMessageModal.afterCloseAlertMessage(true, true);
                    }
                } else {
                    AlertMessageModal.showAlertMessage(data['message']);
                }
                loadHide();
            },
            'error': function () {
                $("button[type=submit]").addClass('btn-primary').bind('click');
                AlertMessageModal.showAlertMessage('服务出错');
                loadHide();
            },
            'beforeSubmit': function () {
                loadShow();
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

function ajaxDel(url,method,params){

}
