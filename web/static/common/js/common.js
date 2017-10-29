/**
 * Created by huang on 2017/10/2.
 */


$(document).ready(function () {
    //ajax提交表单
    $('#form-body').on('submit', '.ajax-form', function () {
        var _this = $(this);
        var closeContentModal = _this.hasClass('close-content-modal');
        loadShow();
        $("button[type=submit]").removeClass('btn-primary').unbind('click')
        $(this).ajaxSubmit({
            'success': function (data) {
                loadHide();
                $("button[type=submit]").addClass('btn-primary').bind('click');
                try {
                    data = JSON.parse(data);
                } catch (e) {
                    AlertMessageModal.showAlertMessage('服务异常,请联系管理员');
                    return false;
                }
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

    $(".ajax-del").click(function(){
        var url=$(this).attr('data-url');
        var params=$(this).attr('data-params');
        try {
            params=JSON.parse(params);
        }catch (e){
            AlertMessageModal.showAlertMessage('参数异常');
            return false;
        }
        ajaxDel(this,url,params,true);
    });

});

function loadShow() {
    $(".div-load").show();
}

function loadHide() {
    $(".div-load").hide();
}

/**
 * 公共删除方法
 * @param el
 * @param url
 * @param params
 * @param removeParent
 * @param callback
 */
function ajaxDel(el, url, params, removeParent, callback) {
    loadShow();
    callback = callback || {};
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: params,
        success: function (data) {
            loadHide();
            if (!data)
                AlertMessageModal.showAlertMessage('服务异常');
            AlertMessageModal.showAlertMessage(data['message']);
            AlertMessageModal.closeAlertMessageCallback(function (res) {
                if (data.status == 1) {
                    if (removeParent) {
                        $(el).parent().parent().remove();
                    } else {
                        callback(true);
                    }
                } else {
                    callback(false);
                }
            });
        },
        error: function () {
            loadHide();
            AlertMessageModal.showAlertMessage('服务出错,请稍后再试');
        }
    });

}
