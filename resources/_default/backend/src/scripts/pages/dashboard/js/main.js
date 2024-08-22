(function ($) {
    let isAjaxDataInitialized = false;

    $(document).ready(function () {
        if (!isAjaxDataInitialized) {
            initializeAjaxData();
            isAjaxDataInitialized = true;
        }
    });

    function initializeAjaxData() {
        console.log('Initializing AJAX Data...');
        if (typeof getAjaxBattles === 'function') {
            getAjaxBattles();
        }
    }

})(jQuery);
