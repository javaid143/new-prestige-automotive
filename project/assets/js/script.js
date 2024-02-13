
$(document).ready(function () {
  $('.owl-theme').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    // navText: ['<span class="prev"></span>', '<span class="next"></span>'],
    navText: ['<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="#fff" viewBox="0 0 24 24" style="transform: rotate(180deg);"><path d="M4 3.532l14.113 8.468-14.113 8.468v-16.936zm-2-3.532v24l20-12-20-12z"/></svg>', '<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="#fff" viewBox="0 0 24 24"><path d="M4 3.532l14.113 8.468-14.113 8.468v-16.936zm-2-3.532v24l20-12-20-12z"/></svg>'], // Custom arrow icons
    dots: false,
    autoplay: false, // Autoplay enabled
    autoplayTimeout: 2000, // Autoplay interval in milliseconds
    autoplayHoverPause: true, // Autoplay paused on mouse hover
    responsive: {
      0: {
        items: 1
      }
    }
  });
});
