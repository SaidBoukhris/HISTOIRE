/* ========================================== 
scrollTop() >= 50
Should be equal the the height of the header
========================================== */

$(window).scroll(function() {
    if ($(window).scrollTop() >= 200) {
        $("nav").addClass("fixed-header");
        $("nav div").addClass("visible-title");
    } else {
        $("nav").removeClass("fixed-header");
        $("nav div").removeClass("visible-title");
    }
});