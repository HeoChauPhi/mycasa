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
    $('.number-counter-js').each(function () {
      var $this = $(this);
      $({ Counter: $this.data('from-value') }).animate({ Counter: $this.data('to-value') }, {
        duration: $this.data('duration'),
        easing: 'swing',
        step: function () {
          $this.text(Math.ceil(this.Counter));
        }
      });
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