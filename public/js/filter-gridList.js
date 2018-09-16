var downloadGrid = (function () {
    "use strict";

    var $cardContainer = $('.download-cards');
    var $downloadCard = $('.download-card__content-box');
    var $viewTrigger = $('button:not(#btn_filter)').attr('data', 'trigger');

    function swapTriggerActiveClass(e) {
        $viewTrigger.removeClass('active');
        $(e.target).addClass('active');
    }

    function swapView(e) {
        var $currentView = $(e.target).attr('data-trigger');
        $cardContainer.attr('data-view', $currentView);
    }

    $(document).ready(function () {
        $viewTrigger.click(function (e) {
            swapTriggerActiveClass(e);
            swapView(e);
        });
    });

})();
$("#radio-salary").click(function () {
    $("#highest").prop('disabled', function (i, v) {
        return !v;
    });
});
$("#btn_filter").on("click", function () {
    $("#sidebar").toggle(300);
    $(this).toggleClass('active');
    $("#vacancy-list").toggleClass('col-lg-9 col-lg-12');
});