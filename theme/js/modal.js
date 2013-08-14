define(function(require) {
    // listeners
    $(".order-button").on("click", function(){
        $("#orderModal").modal("show", "slow");
    });

    $(".delivery-button").on("click", function(){
        $("#deliveryModal").modal("show");
    });

    $("#deliveryModal .order-button").on("click", function(){
        $("#deliveryModal").modal("hide");
        $("#orderModal").modal("show");
    });

    $(".review-button").on("click", function(){
        $("#reviewModal").modal("show");
    });

    $(".modal").on('show.bs.modal', function(){
        $('html').css('overflow', 'hidden');
        $('.page-container').addClass('scroll');
    });
    $(".modal").on('hide.bs.modal', function(){
        $('html').css('overflow', 'auto');
        $('.page-container').removeClass('scroll');
    });
        $("select").customSelect && $("select").customSelect();
});