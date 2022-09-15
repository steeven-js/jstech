// navbarDropdown
if ($(window).width() < 992) {
  $('.navigation .dropdown-toggle').on('click', function () {
    $(this).siblings('.dropdown-menu').animate({
      height: 'toggle'
    }, 300);
  });
}