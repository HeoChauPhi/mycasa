(function($) {


  $(document).ready(function() {
    // Call to function

    // Odoo Image Preview
    if ($('.acf-field[data-name="picture_attachement_ids"]').length > 0) {
      $('.acf-field[data-name="picture_attachement_ids"]').each(function() {
        let img_url = $(this).find('.acf-input-wrap > input').val();
        $(this).find('.acf-input-wrap').append('<img src="' + img_url + '" width="150" height="150">');
      });
    }

    if ($('.acf-field[data-name="picture_path"]').length > 0) {
      let img_url = $('.acf-field[data-name="picture_path"] .acf-input-wrap > input').val();
      $('.acf-field[data-name="picture_path"] .acf-input-wrap').append('<img src="' + img_url + '" width="150" height="150">');
    }

    // Auto get year for project ACF field
    if ($('.post-type-project .acf-field[data-name="hand_over_date"] input[type="text"]').length > 0 && $('.post-type-project .acf-field[data-name="hand_over_year"] input[type="text"]').length > 0) {
      var date_element = $('.post-type-project .acf-fields .acf-field[data-name="hand_over_date"] .acf-input input[type="text"]'),
          year_element = $('.post-type-project .acf-field[data-name="hand_over_year"] input[type="text"]');
      
      var hand_over_year = '';

      if (date_element.val() && year_element.val() == '') {
        hand_over_year = new Date(date_element.val()).getFullYear();
        year_element.val(hand_over_year);
      }

      date_element.on('change', function(){
        hand_over_year = new Date($(this).val()).getFullYear();
        year_element.val(hand_over_year);
      });
    }

    // ACF fields for post member
    if ($('.post-type-post .acf-field[data-name="properties_for_agent"] input[type="text"]').length > 0) {
      var current_agent = $('.post-type-post .acf-field[data-name="properties_for_agent"] input[type="text"]').val();

      $('.post-type-post .acf-field[data-name="properties_for_agent"] input[type="text"]').hide().before('<select class="acf-agents-select2"></select>');

      $.ajax({
        type : 'POST',
        url: ajaxurl,
        data: {
          action: 'acf_get_properties_by_agent',
          current_agent: current_agent
        },
        beforeSend: function( ) {},
        success: function(data) {
          $('.acf-agents-select2').html($.parseJSON(data));
        },
        error: function(errorThrown) {
          console.log('errorThrown');
        }
      });
      
      $('.acf-agents-select2').select2();

      $('.acf-agents-select2').on('select2:select', function (e) {
        var data = e.params.data;
        if (data.text == 'None') {
          $('.post-type-post .acf-field[data-name="properties_for_agent"] input[type="text"]').val('');
        } else {
          $('.post-type-post .acf-field[data-name="properties_for_agent"] input[type="text"]').val(data.text);
        }
      });
    }
  });

  $(window).load(function() {
    // Call to function
  });

  $(window).resize(function() {
    // Call to function
  });
})(jQuery);
