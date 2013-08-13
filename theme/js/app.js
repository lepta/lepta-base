"use strict";

require.config({
    paths : {
        fileUpload : './fileUpload',
        navigation: './navigation',
        modal: './modal',
        drugstores: './drugstores',
        review: './review',
        faq: './faq'
    }
});
define(function(require) {
    // dependencies
    var navigation = require('navigation'),
        modal = require('modal'),
        drugstores = require('drugstores'),
        review = require('review'),
        faq = require('faq'),
        fileUpload = require('fileUpload');

    function init(){
        $("select").customSelect && $("select").customSelect();
    }

    init();
});
