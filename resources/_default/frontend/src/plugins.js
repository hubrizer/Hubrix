module.exports = [
    // Include jQuery only for jQuery-dependent plugins
    //require('../../../../node_modules/jquery/dist/jquery.min.js'),

    // Bootstrap 5, which no longer depends on jQuery
    //require('../../../../node_modules/bootstrap/dist/js/bootstrap.min.js'),

    // Popper.js (required for Bootstrap tooltips, dropdowns, etc.)
    //require('../../../../node_modules/@popperjs/core/dist/umd/popper.js'),

    // Moment.js for date manipulation
    require('../../../../node_modules/moment-mini/moment.min.js'),

    // Other packages
    require('../../../../node_modules/wnumb/wNumb.js'),
    require('../../../../node_modules/nouislider/dist/nouislider.js'),
    require('../../../../node_modules/swiper/swiper-bundle.js'),
    require('../../../../node_modules/autosize/dist/autosize.min.js'),
    require('../../../../node_modules/flatpickr/dist/flatpickr.js'),
    require('../../../../node_modules/tiny-slider/dist/min/tiny-slider.js'),
    require('../../../../node_modules/@eonasdan/tempus-dominus/dist/js/tempus-dominus.min.js'),
    require('../../../../node_modules/@eonasdan/tempus-dominus/dist/plugins/customDateFormat.js'),
];
