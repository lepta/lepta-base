define(function(require) {
    //dependencies
    //var Boiler = require("Boiler");
    var animateIcons = function(ui){
        if (!document.all && document.addEventListener) {
            $(ui.oldHeader).find(".collapse-icon").animate({
                transform: 'rotate(0deg)'
            })
            $(ui.newHeader).find(".collapse-icon").animate({
                transform: 'rotate(90deg)'
            });
        }
    };
    var scrollToElement = function(ui){
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
    //return an object with the public interface for an 'application' object.
    return {
        hash: window.location.hash,
        navigate: function(event){
            var target = $(event.target),
                targetHref;
            if(!$(target).hasClass("no-navigate")){
                targetHref = target.attr("href");
                $( "#accordion" ).accordion( "option", "active", $('.section-header').index($(".section-header[data-hash='" + targetHref.slice(1) + "']")));
                window.location.href = location.origin + "/" + targetHref;
            }
        },
        accordion: {
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
        },
        init : function() {
            $( "#accordion" ).accordion(this.accordion.option);
        }
    }
});