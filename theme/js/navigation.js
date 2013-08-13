define(function(require) {
    //dependencies
    //var Boiler = require("Boiler");
    var menuItem = $("nav li a"),
        accordionHeader = $(".section-header"),
        hash = window.location.hash,
        accordion = {
            option: {
                heightStyle: "content",
                animated : false,
                autoHeight : false,
                active:0,
                collapsible: true,
                beforeActivate: function( event, ui) {
                    scrollToElement(ui);
                    animateIcons(ui);
                }
            }
        };


    function setActiveMenu(element){
        menuItem.removeClass("active");
        $(element).addClass("active")
    };

    function animateIcons(ui){
        if (!document.all && document.addEventListener) {
            $(ui.oldHeader).find(".collapse-icon").animate({
                transform: 'rotate(0deg)'
            })
            $(ui.newHeader).find(".collapse-icon").animate({
                transform: 'rotate(90deg)'
            });
        }
    };
    function scrollToElement(ui){
        if(ui.newHeader.offset()){
            if (ui.newHeader.index() == 0) {
                $('body,html').animate({scrollTop: 0});
            } else {
                if(ui.newHeader.offset() && ui.oldHeader.offset() && ui.newHeader.offset().top >  ui.oldHeader.offset().top){
                    $('body,html').animate({scrollTop: ui.newHeader.offset().top - $('header').height() - ui.oldPanel.height() -ui.oldHeader.height()});
                } else{
                    $('body,html').animate({scrollTop: ui.newHeader.offset().top - $('header').height()});
                }
            }
        }
    };

    function navigate(event){
        var target = $(event.target),
            targetHref;

        if(!$(target).hasClass("no-navigate")){
            targetHref = target.attr("href");
            $( "#accordion" ).accordion( "option", "active", $('.section-header').index($(".section-header[data-hash='" + targetHref.slice(1) + "']")));
            window.location.href = location.origin + "/" + targetHref;
        }
    };

    function init(){
        $( "#accordion" ).accordion(accordion.option);

        if(hash){
            if (hash == '#success') {
                // show modal popup for successful order
                $('#successModal').modal("show");
		    } else if (hash == '#reviewSuccess') {
                $('#successReviewModal').modal("show");
            } else {
                setActiveMenu($("[href='" + hash + "']"));
                $( "#accordion" ).accordion( "option", "active", $('.section-header').index($(".section-header[data-hash='" + hash.slice(1) + "']")));
            }
        };

        // add event listeners
        menuItem.on("click", function(event){
            setActiveMenu(event.target);
            navigate(event);
        });

        accordionHeader.on("click", function(){
            var hash = $(this).attr("data-hash");
            setActiveMenu($("[href='#" + hash + "']"));
            window.location.hash = hash;
        });

    }

    init();
});