$(document).ready(function () {
    $(document).on('mouseenter', '.divbutton', function () {
        $(this).find(".button").show();
        $(this).find(".course_info").hide();
    }).on('mouseleave', '.divbutton', function () {
        $(this).find(".button").hide();
        $(this).find(".course_info").show();
    });
});