/* ========================================== 
scrollTop() >= 50
Should be equal the height of the header
========================================== */

$(window).scroll(function() {
    if ($(window).scrollTop() >= 400) {
        $("nav").addClass("fixed-header");
        $("nav p").addClass("visible-title");
    } else {
        $("nav").removeClass("fixed-header");
        $("nav p").removeClass("visible-title");
    }
});