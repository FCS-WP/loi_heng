jQuery(document).ready(function($) {
  $('.menu-item-has-children > a:after').on('click', function(e) {
      e.preventDefault();
      var $submenu = $(this).parent().find('.sub-menu').first();
      $('.sub-menu').not($submenu).removeClass('show'); 
      $submenu.toggleClass('show');
  });

  $('.bot_cat_button').on('click', function() {
      $(this).toggleClass('active');
      $('.bot_nav_cat_wrap').toggleClass('active');
      $('.bot_nav_cat_wrap').slideToggle();
  });
});