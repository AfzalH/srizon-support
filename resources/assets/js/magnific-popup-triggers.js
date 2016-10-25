$(function () {
    $('.popup-with-form').magnificPopup({
        type: 'inline',
        preloader: false
    });
});

$('.ajax-popup-link').magnificPopup({
    type: 'ajax',
    callbacks: {
        close: function () {
            tinymce.remove();
            init_tinymce();
        },
        ajaxContentAdded: function () {
            tinymce.remove();
            init_tinymce_without_popup();
        }
    }
});