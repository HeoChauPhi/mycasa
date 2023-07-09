/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire, audiojs*/

(function($) {
  var iScrollPos = 0;

  /* ==================================================================
   *
   * Loading Jquery
   *
   ================================================================== */
  $(document).ready(function() {
    // Call to function
    $('.banner-search-tabs .nav-item .nav-link').on('click', function(){
      $('.banner-search-tabs > input.search-by').val($(this).data('val'));
      if ($(this).data('val') == 'project') {
        $('.banner-search-advanced .banner-search-adv-field').find('input, select').attr('disabled', true);
        $('.banner-search-advanced-wrap').addClass('hidden');
      } else {
        $('.banner-search-advanced .banner-search-adv-field').find('input, select').removeAttr('disabled', false);
        $('.banner-search-advanced-wrap').removeClass('hidden');
      }

      $('.banner-search-field-price-wrap').addClass('hidden');
      $('.banner-search-field-'+$(this).data('val')+'-price-wrap').removeClass('hidden');
      $('.banner-search-field-price-wrap.hidden').find('input, select').attr('disabled', true);

      $('.banner-search-advanced select.selectpicker').selectpicker('refresh');
    });
  });

  $(window).scroll(function() {
    // Call to function
  });

  $(window).load(function() {
    // Call to function
  });

  $(window).resize(function() {
    // Call to function
  });

})(jQuery);