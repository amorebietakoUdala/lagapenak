import $ from 'jquery';

$(function(){
    $('.js-save').on('click',function (e) {
        $(document.user).attr('action', $(e.currentTarget).data("url"));
        document.user.submit();
    });
    $('.js-back').on('click',function (e) {
        document.location.href = $(e.currentTarget).data("url");
    });
});