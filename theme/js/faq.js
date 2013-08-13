define(function(require) {
    $(".faq-accordion .question").on("click", function(){
        if ($(this).find('.answer').css('display') == 'none') {
            $('.faq-accordion').find('.answer').slideUp();
            $(this).find('.answer').slideDown();
        } else {
            $(this).find('.answer').slideUp();
        }
    });
});