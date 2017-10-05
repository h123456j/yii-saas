/**
 * Created by huangj06 on 2017/9/30.
 */


$(document).ready(function(){


    $(".content-modal").click(function(){
        var title=$(this).attr('modal-title'),
            url=$(this).attr('modal-url');

        contentModal.showContentModal(title);
    });

    var contentModal={

        modal:$('#content-model'),
        modalTitle:$('#content-model').find('.modal-title'),
        modalIframe:$('#content-model').find('.modal-iframe'),

        showContentModal:function(title){
            this.modalTitle.html(title);
            this.modal.modal();
        },

        setModalTitle:function(title){
            this.modalTitle.html(title);
        },

        setIframe:function(url){
            this.modalIframe.attr("src",url);
        }

    };

});