/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire, audiojs*/

(function($) {
  var iScrollPos = 0;

  // Media Upload
  function open_media_window() {
    var file_mime = 'application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/excel, application/vnd.ms-excel, application/x-excel, application/x-msexcel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    var file_mime_arr = file_mime.split(', ');
    if (this.window === undefined) {
      this.window = wp.media({
        title: 'Insert a media',
        library: {
          type: file_mime
        },
        multiple: false,
        button: {text: 'Insert'}
      });

      var self = this; // Needed to retrieve our variable in the anonymous function below
      this.window.on('select', function() {
        var first = self.window.state().get('selection').first().toJSON();
        //wp.media.editor.insert('[myshortcode id="' + first.id + '"]');
        //console.log(first);
        if ($.inArray(first.mime, file_mime_arr) != -1) {
          $('.upload_career_application_form_url').val(first.url);
        } else {
          alert('Please upload profile with formats: pdf, doc, docx, xls, xlsx!');
        }
      });
    }

    this.window.open();
    return false;
  }


  /* ==================================================================
   *
   * Loading Jquery
   *
   ================================================================== */
  $(document).ready(function() {
    // Call to function
    $('.upload_career_application_form_button').on('click', open_media_window);
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