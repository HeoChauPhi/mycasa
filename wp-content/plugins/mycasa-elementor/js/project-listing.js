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
    if ($('#popup-form-deposit').length > 0) {
      var form_wrap = $('#popup-form-deposit .wpcf7-form');

      form_wrap.find('input[name="deposit-type"').on('click', function() {
        form_wrap.find('.deposit-type-name').text($(this).val());
      });

      $('#popup-form-deposit .popup-form-deposit-close i[class*="fa"]').on('click', function(){
        $('#popup-form-deposit').trigger('click');
      });
    }
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