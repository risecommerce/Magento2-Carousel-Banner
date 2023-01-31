define([
    'jquery',
    'slick'
], function ($) {
    'use strict';
    return function (config) {
        $('.risecommerce_banner_slider').slick(
            {
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                adaptiveHeight: true,
                autoplay: parseInt(config.autoplay),
                autoplaySpeed: parseInt(config.autoplay_speed),
                pauseOnHover:false,
                arrows: true
            }
        );
    }
});