//"use strict";
//
//require.config({
//    /*
//     * Let's define short alias for commonly used AMD libraries and name-spaces. Using
//     * these alias, we do not need to specify lengthy paths, when referring a child
//     * files. We will 'import' these scripts, using the alias, later in our application.
//     */
//    paths : {
//        // requirejs plugins in use
//        text : './libs/require/text',
//        i18n : './libs/require/i18n',
//        path : './libs/require/path',
//        // namespace that aggregate core classes that are in frequent use
//        Boiler : './app/core/_boiler_'
//    }
//});

$(function(){
    //init
    var hash = window.location.hash,
        options = {
            heightStyle: "content",
            animated : false,
            autoHeight : false,
            active:0,
            collapsible: true,
            create: function( event, ui ) {},
            beforeActivate: function( event, ui ) {
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
                if (!document.all && document.addEventListener) {
                    $(ui.oldHeader).find(".collapse-icon").animate({
                        transform: 'rotate(0deg)'
                    })
                    $(ui.newHeader).find(".collapse-icon").animate({
                        transform: 'rotate(90deg)'
                    });
                }
            },
            activate: function( event, ui ) {
                if(!ui.newHeader.hasClass("ui-state-active")){
                    ui.newHeader.addClass("close")
                }
            }
        };

    $( "#accordion" ).accordion(options);
    if(hash){
		if (hash == '#success') {
			// show modal popup for successful order
			show($('#successModal'));
		} else {
			setActiveMenu($("[href='" + hash + "']"));
			$( "#accordion" ).accordion( "option", "active", $('.section-header').index($(".section-header[data-hash='" + hash.slice(1) + "']")));
		}
    }

    $("select").customSelect && $("select").customSelect();
    $(".faq-accordion .question .answer").eq(0).slideToggle();
    // add listeners
    $("nav li").on("click", function(event){
        setActiveMenu(event.target);
        navigate(event);
    })
    $(".review-more").click(function(){
        $(".review-section").animate({marginTop: "-90px"}, 500, function(){
            $(".review-section .review").eq(0).clone().appendTo(".review-section");
            $(".review-section .review").eq(0).remove();
            $(".review-section").css({"marginTop":"0px"});
        });
    });
    $(".order-button").on("click", function(){
        show($("#orderModal"));

    })
    $(".delivery-button").on("click", function(){
        show($("#deliveryModal"));
    })
    $(".review-button").on("click", function(){
        show($("#reviewModal"));
    })
    $("#deliveryModal .order-button").on("click", function(){
        hide($("#deliveryModal"));
        show($("#orderModal"));
    });
    $(".modal").on('show', function(){
        $('html').css('overflow', 'hidden');
        $('.page-container').addClass('scroll');
    });
    $(".modal").on('hide', function(){
        $('html').css('overflow', 'auto');
        $('.page-container').removeClass('scroll');
    })
    $(".modal .close").on("click", function(){
        hide($(".modal"));
    })
    $(".section-header").on("click", function(){
        var hash = $(this).attr("data-hash");
        setActiveMenu($("[href='#" + hash + "']"));
        window.location.hash = hash;
    })
    $(".pharmacy_header_left_select select#region").on("change", function(){
        getCityList($(this).val());
    });
    $(".pharmacy_header_left_select select#city").on("change", function(){
        getCityContent($(this).val());
    })
    $(".faq-accordion .question").on("click", function(){
        if ($(this).find('.answer').css('display') == 'none') {
            $('.faq-accordion').find('.answer').slideUp();
            $(this).find('.answer').slideDown();
        } else {
            $(this).find('.answer').slideUp();
        }
    });
    // privet functions
    function show(modal){
        modal.removeClass("hide");
        modal.stop().animate({opacity: "1"},'slow');
        modal.trigger('show');
    }
    function hide(modal){
        modal.stop().animate({opacity: "0"},'fast', function(){
            modal.addClass("hide");
        });
        modal.trigger('hide');
    }
    function setActiveMenu(element){
        $("nav li a").removeClass("active");
        $(element).addClass("active")
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
    function getCityList(region){
        if(!region) return
        var select = ".pharmacy_header_left_select select#city";

        $(select + ' option:first').attr("selected", "selected");
        $(select + ' option:not(:first)').remove();
        $(select).attr("disabled","disabled").trigger('update');

        function onGetCityListSuccess(result){
            if(!result) return
            var cityList = $.parseJSON(result).data,
                options = "";

            $.each(cityList, function(key, value) {
                options += '<option value="' + key + '">' + value + '</option>';
            });
            $(select).append(options).attr("disabled", false);
        };

        function onGetCityListError(error){
            console && console.log("Empty data or error occurred on getCityList request")
        };
        $.ajax({
            type: "POST",
            url: "/drugstores/getCities/",
            data: {"region": region},
            success: onGetCityListSuccess,
            error: onGetCityListError
        });
    };

    function getCityContent(city){
        function onGetCityContentSuccess(result){
            if(!result) return
            var redirectUrl = $.parseJSON(result).data;
            if(redirectUrl){
                location.href = redirectUrl;
            }

        };

        function onGetCityContentError(error){
            console && console.log(error)
        };

        $.ajax({
            type: "POST",
            url: "/drugstores/getRedirectUrl/",
            data: {"city": city},
            success: onGetCityContentSuccess,
            error: onGetCityContentError
        });
    }
})
