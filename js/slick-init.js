/*!
  * init slick slider
  */
(function () {
    jQuery(document).ready(function ($) {
        $('.slider').slick({
            autoplay: false,
            dots: true,
            infinite: false,
            arrows: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            rows: 0
        });
    });
})();

