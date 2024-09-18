module.exports = [
    // Include jQuery only for jQuery-dependent plugins
    //require('../../../../node_modules/jquery/dist/jquery.min.js'),

    // Bootstrap 5, which no longer depends on jQuery
    //require('../../../../node_modules/bootstrap/dist/js/bootstrap.min.js'),

    // Popper.js (required for Bootstrap tooltips, dropdowns, etc.)
    //require('../../../../node_modules/@popperjs/core/dist/umd/popper.js'),

    // Moment.js for date manipulation
    require('../../../../node_modules/moment-mini/moment.min.js'),

    // jQuery-dependent plugins
    require('../../../../node_modules/bootstrap-daterangepicker/daterangepicker.js'),
    require('../../../../node_modules/bootstrap-maxlength/src/bootstrap-maxlength.js'),

    // Other packages
    require('../../../../node_modules/select2/dist/js/select2.full.js'),
    require('../../../../node_modules/nouislider/dist/nouislider.js'),
    require('../../../../node_modules/flatpickr/dist/flatpickr.min.js'),
    require('../../../../node_modules/sweetalert2/dist/sweetalert2.min.js'),
    require('../../../../node_modules/wnumb/wNumb.js'),

    //require('../src/scripts/mixins/vendors/plugins/@form-validation/umd/bundle/popular.min.js'),
    //require('../src/scripts/mixins/vendors/plugins/@form-validation/umd/bundle/full.min.js'),
    //require('../src/scripts/mixins/vendors/plugins/@form-validation/umd/plugin-bootstrap5/index.min.js'),

    require('../../../../node_modules/inputmask/dist/inputmask.js'),
    require('../../../../node_modules/inputmask/dist/bindings/inputmask.binding.js'),
    require('../../../../node_modules/autosize/dist/autosize.js'),
    require('../../../../node_modules/clipboard/dist/clipboard.min.js'),
    require('../../../../node_modules/dropzone/dist/min/dropzone.min.js'),
    require('../../../../node_modules/apexcharts/dist/apexcharts.min.js'),
    require('../../../../node_modules/countup.js/dist/countUp.umd.js'),
    require('../../../../node_modules/tiny-slider/dist/min/tiny-slider.js'),
    require('../../../../node_modules/@eonasdan/tempus-dominus/dist/js/tempus-dominus.min.js'),
    require('../../../../node_modules/@eonasdan/tempus-dominus/dist/plugins/customDateFormat.js'),
];
