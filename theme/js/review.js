define(function(require) {
    $(".review-more").click(function(){
        $(".review-section").animate({marginTop: "-" + $(".review-section .review").eq(0).height() + "px"}, 500, function(){
            $(".review-section .review").eq(0).clone().appendTo(".review-section");
            $(".review-section .review").eq(0).remove();
            $(".review-section").css({"marginTop":"0px"});
        });
    });
});