/**
 * Created by huangj06 on 2017/9/30.
 */


$(document).ready(function(){

    $(document).on('click','.content-modal',function(){
        loadShow();
        var title=$(this).attr('data-title'),
            url=$(this).attr('data-url');
        contentModal.setIframe(url);
        contentModal.showContentModal(title);
    });

    var contentModal={

        modal:$('#content-modal'),

        showContentModal:function(title){
            this.modal.find('.modal-title').html(title);
            this.modal.modal();
            this.modal.find('.modal-iframe').load(function(){
                loadHide();
            });
        },

        setModalTitle:function(title){
            $('#content-modal').find('.modal-title').html(title);
        },

        setIframe:function(url){
            $('#content-modal').find('.modal-iframe').attr("src",url);
        }

    };

});

function closeContentModal(){
    $('#content-modal').modal('hide');
}