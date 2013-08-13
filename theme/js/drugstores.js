define(function(require) {
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

    $(".pharmacy_header_left_select select#region").on("change", function(){
        getCityList($(this).val());
    });
    $(".pharmacy_header_left_select select#city").on("change", function(){
        var city = $(this).val();
        if(city != 0){
            getCityContent(city);
        }

    })
});