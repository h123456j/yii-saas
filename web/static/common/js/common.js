/**
 * Created by huang on 2017/10/2.
 */


$(document).ready(function () {
    //ajax提交表单
    $('#form-body').on('submit', '.ajax-form', function (e) {
        var _this = this;
        e.preventDefault();
        loadShow();
        $('.alert-danger').hide();
        $(this).ajaxSubmit({
            'success': function (data) {
                if ($("#module-login").length > 0) {
                    var data = JSON.parse(data);
                    if (data.ret == true){
                        window.location.href = BaseUrl + '/admin/index';
                    }else {
                        $('.alert-danger').show();
                    }
                }else {

                }
                loadHide();
            },
            'error': function () {
                loadHide();
            },
            'beforeSubmit': function () {
                loadShow();
            }
        });
        return false;
    });
});

function loadShow() {
    $(".div-load").show();
}

function loadHide() {
    $(".div-load").hide();
}
