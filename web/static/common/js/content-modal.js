/**
 * Created by huangj06 on 2017/9/30.
 */
$(document).ready(function () {

    $(document).on('click', '.content-modal', function () {
        loadShow();
        var title = $(this).attr('data-title'),
            url = $(this).attr('data-url');
        ContentModal.setIframe(url);
        ContentModal.showContentModal(title);
    });
});

//内容模态框
var ContentModal = {

    contentModal: $('#content-modal'),

    showContentModal: function (title) {
        this.contentModal.find('.modal-title').html(title);
        this.contentModal.modal();
        this.contentModal.find('.modal-iframe').load(function () {
            loadHide();
        });
    },

    setModalTitle: function (title) {
        this.contentModal.find('.modal-title').html(title);
    },

    setIframe: function (url) {
        this.contentModal.find('.modal-iframe').attr("src", url);
    },

    closeContentModal: function (reload) {
        reload = reload || false;
        this.contentModal.modal('hide');
        this.contentModal.on('hidden.bs.modal', function () {
            if (reload)
                window.location.reload();
        });
    }
};

//信息弹窗提示框
var AlertMessageModal = {

    alertModal: $('#alert-modal'),

    showAlertMessage: function (message) {
        message = message || '提示信息';
        this.alertModal.find('.modal-body').html(message);
        this.alertModal.modal();
    },

    closeAlertMessageCallback:function(callback){
        callback = callback || {};
        this.alertModal.on('hidden.bs.modal',function(){
            callback(true);
        });
    },

    afterCloseAlertMessage: function (closeParentContentModal, reload) {
        closeParentContentModal = closeParentContentModal || false;
        reload = reload || false;
        this.alertModal.on('hidden.bs.modal', function () {
            if (closeParentContentModal)
                setTimeout(function () {
                    parent.ContentModal.closeContentModal(reload);
                }, 700);
        });
    }
};
