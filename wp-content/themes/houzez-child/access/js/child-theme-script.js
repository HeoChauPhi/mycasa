/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire, audiojs*/

(function($) {
  var iScrollPos = 0;
  function insertParam(key, value) {
    key = encodeURI(key);
    value = encodeURI(value);

    // get querystring , remove (?) and covernt into array
    var qrp = document.location.search.substr(1).split('&');

    // get qrp array length
    var i = qrp.length;
    var j;
    while (i--) {
      //covert query strings into array for check key and value
      j = qrp[i].split('=');

      // if find key and value then join
      if (j[0] == key) {
        j[1] = value;
        qrp[i] = j.join('=');
        break;
      }
    }

    if (i < 0) {
      qrp[qrp.length] = [key, value].join('=');
    }
    // reload the page
    document.location.search = qrp.join('&');
  }

  // Project search autocomplete
  var myCasaProjectAutoComplete = function () {

    var ajaxCount = 0;
    var auto_complete_container = $('#auto_complete_ajax');
    var lastLenght = 0;

    $('.houzez-project-keyword-autocomplete, .houzez-search-form-js input[name="project-name"], .houzez-search-form-js input[name="search-custom"], .advanced-search-half-map .houzez-search-form-js input[name="search-custom"], .banner-search-form-field-autocomplete #project-keyword').keyup(function() {

      var $this = $( this );

      var keyword = $( this ).val();
      
      keyword = $.trim( keyword );
      var currentLenght = keyword.length;

      if ( currentLenght >= 2 && currentLenght != lastLenght ) {

        lastLenght = currentLenght;
        auto_complete_container.empty();
        auto_complete_container.fadeIn();

        $.ajax({
          type: 'POST',
          url: customAjax.ajaxurl,
          data: {
            'action': 'mycasa_project_get_auto_complete_search',
            'key': keyword,
          },
          beforeSend: function( ) {
            console.log('befor send');
            auto_complete_container.empty();
          },
          success: function(data) {
            auto_complete_container.empty();
            auto_complete_container.append($.parseJSON(data));
            //console.log(data);
          },
          error: function(errorThrown) {
            console.log('error');
          }
        });

      } else {
        if ( currentLenght != lastLenght ) {
          auto_complete_container.fadeOut();
        }
      }

    });
  }

  // Project price ranger
  var project_price_range_search = function(currency_position = 'before', currency_symb = '$') {
    var min_price = parseFloat($('.project-price-range-wrap .value-min-price-range').val());
    var max_price = parseFloat($('.project-price-range-wrap .value-max-price-range').val());

    var current_min_price = parseFloat($('.project-price-range-wrap .current-min-price-range').val());
    var current_max_price = parseFloat($('.project-price-range-wrap .current-max-price-range').val());

    $('.project-price-range').slider({
      range: true,
      min: min_price,
      max: max_price,
      values: [current_min_price, current_max_price],
      slide: function (event, ui) {
        if( currency_position == 'after' ) {
          var min_price_range = thousandSeparator(ui.values[0]) + currency_symb;
          var max_price_range = thousandSeparator(ui.values[1]) + currency_symb;
        } else {
          var min_price_range = currency_symb + thousandSeparator(ui.values[0]);
          var max_price_range = currency_symb + thousandSeparator(ui.values[1]);
        }
        $(".project-price-range-wrap .min-price-range-hidden").val( ui.values[0] );
        $(".project-price-range-wrap .max-price-range-hidden").val( ui.values[1] );

        $(".project-price-range-wrap .min-price-range").text( min_price_range );
        $(".project-price-range-wrap .max-price-range").text( max_price_range );
      },
      stop: function( event, ui ) {
          
      },
      change: function( event, ui ) {  }
    });

    if( currency_position == 'after' ) {
      var min_price_range = thousandSeparator($(".project-price-range").slider("values", 0)) + currency_symb;
      var max_price_range = thousandSeparator($(".project-price-range").slider("values", 1)) + currency_symb;
    } else {
      var min_price_range = currency_symb + thousandSeparator($(".project-price-range").slider("values", 0));
      var max_price_range = currency_symb + thousandSeparator($(".project-price-range").slider("values", 1));
    }

    $(".project-price-range-wrap .min-price-range").text(min_price_range);
    $(".project-price-range-wrap .max-price-range").text(max_price_range);
  }

  // Add Comma to value
  var thousandSeparator = (n) => {
    if (typeof n === 'number') {
      n += '';
      var x = n.split('.');
      var x1 = x[0];
      var x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return x1 + x2;
    } else {
      return n;
    }
  }

  // Add js scroll to element
  function scrollToElement() {
    var scrool_id = $(this).attr('href');

    var search_sticky_height = 0;
    if ($('.advanced-search-nav').data('sticky') == 1) {
      search_sticky_height = $('.advanced-search-nav').outerHeight(true);
    }

    var admin_bar_height = 0;
    if ($('#wpadminbar').length > 0) {
      admin_bar_height = $('#wpadminbar').outerHeight(true);
    }

    var scroll_length = $(scrool_id).offset().top - search_sticky_height - admin_bar_height;
    $('html, body').animate({
      scrollTop: scroll_length
    }, 500);

    return false;
  }

  var price_range_search = function( min_price, max_price, currency_position = 'before', currency_symb = '$' ) {
    $(".price-range").slider({
      range: true,
      min: min_price,
      max: max_price,
      values: [min_price, max_price],
      slide: function (event, ui) {
          if( currency_position == 'after' ) {
              var min_price_range = thousandSeparator(ui.values[0]) + currency_symb;
              var max_price_range = thousandSeparator(ui.values[1]) + currency_symb;
          } else {
              var min_price_range = currency_symb + thousandSeparator(ui.values[0]);
              var max_price_range = currency_symb + thousandSeparator(ui.values[1]);
          }
          $(".min-price-range-hidden").val( ui.values[0] );
          $(".max-price-range-hidden").val( ui.values[1] );

          $(".min-price-range").text( min_price_range );
          $(".max-price-range").text( max_price_range );
      },
      stop: function( event, ui ) {}
    });

    if( currency_position == 'after' ) {
        var min_price_range = thousandSeparator($(".price-range").slider("values", 0)) + currency_symb;
        var max_price_range = thousandSeparator($(".price-range").slider("values", 1)) + currency_symb;
    } else {
        var min_price_range = currency_symb + thousandSeparator($(".price-range").slider("values", 0));
        var max_price_range = currency_symb + thousandSeparator($(".price-range").slider("values", 1));
    }

    $(".min-price-range").text(min_price_range);
    $(".max-price-range").text(max_price_range);
    $(".min-price-range-hidden").val($(".price-range").slider("values", 0));
    $(".max-price-range-hidden").val($(".price-range").slider("values", 1));
      
  }

  function number_format_custom(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  }

  function mortgage_calucaltion_section_custom(total_amount, down_payment, interest_rate, loan_term, currency_symbol) {
        
    if( isNaN( down_payment = Math.abs( down_payment ) ) ) {
      down_payment = 0;
    }

    if( isNaN( interest_rate = Math.abs( interest_rate ) ) ) {
      interest_rate = 0;
    }

    if( isNaN( loan_term = Math.abs( loan_term ) ) ) {
      loan_term = 0;
    }

    /*var advance_payment = Math.round((down_payment / 100) * total_amount);
    var bank_loan = total_amount - advance_payment;
    var loan_interest = Math.round((interest_rate / 100) * bank_loan) * loan_term;
    var total_amount = bank_loan + loan_interest;*/

    // Global calculator
    var down_payment_percent = down_payment / 100;
    var interest_rate_percent = interest_rate / 100;
    var loan_term_month = loan_term * 12;

    // Advance Payment
    var advance_payment = total_amount * down_payment_percent;
    var loan_total = total_amount - advance_payment;

    // First month calculator
    var first_principal = loan_total / loan_term_month;
    var first_interest = loan_total * interest_rate_percent / loan_term_month;

    // Add to first log table
    var first_result = '<tr>';
    first_result += '<td>1</td>';
    first_result += '<td>'+number_format_custom(Math.round(loan_total * 10000)/10000)+'</td>';
    first_result += '<td>'+number_format_custom(Math.round(first_principal * 10000)/10000)+'</td>';
    first_result += '<td>'+number_format_custom(Math.round(first_interest * 10000)/10000)+'</td>';
    first_result += '<td>'+number_format_custom(Math.round((first_principal + first_interest) * 10000)/10000)+'</td>';
    first_result += '</tr>';
    $('.loan-calculator tbody').append(first_result);

    // Second month calculator
    var principals = loan_total - first_principal;
    var second_interest = principals * interest_rate_percent / loan_term_month;

    // Add to seccond log table
    var second_result = '<tr>';
    second_result += '<td>2</td>';
    second_result += '<td>'+number_format_custom(Math.round(principals * 10000)/10000)+'</td>';
    second_result += '<td>'+number_format_custom(Math.round(first_principal * 10000)/10000)+'</td>';
    second_result += '<td>'+number_format_custom(Math.round(second_interest * 10000)/10000)+'</td>';
    second_result += '<td>'+number_format_custom(Math.round((first_principal + second_interest) * 10000)/10000)+'</td>';
    second_result += '</tr>';
    $('.loan-calculator tbody').append(second_result);

    // Each months calculator
    var interest_arr = [first_interest, second_interest];
    var interests = null;
    var log_result = null;

    for (var i = 3; i <= loan_term_month; i++) {
      principal = principals - first_principal;
      interests = principal * interest_rate_percent / loan_term_month;

      // Add to [i] log table
      log_result += '<tr>';
      log_result += '<td>'+i+'</td>';
      log_result += '<td>'+number_format_custom(Math.round(principal * 10000)/10000)+'</td>';
      log_result += '<td>'+number_format_custom(Math.round(first_principal * 10000)/10000)+'</td>';
      log_result += '<td>'+number_format_custom(Math.round(interests * 10000)/10000)+'</td>';
      log_result += '<td>'+number_format_custom(Math.round((first_principal + interests) * 10000)/10000)+'</td>';
      log_result += '</tr>';
      $('.loan-calculator tbody').append(log_result);

      interest_arr.push(interests);

      principals = principal;
      interests = null;
      log_result = null;
    }

    // Total interest
    var sum_interest = 0;
    $.each(interest_arr,function(){sum_interest+=parseFloat(this) || 0;});
    
    // Total
    var total_amount = loan_total + sum_interest;

    // Add log to total table
    var log_total = '<tr>';
    log_total += '<td>Total</td>';
    log_total += '<td></td>';
    log_total += '<td>'+number_format_custom(Math.round(loan_total * 10000)/10000)+'</td>';
    log_total += '<td>'+number_format_custom(Math.round(sum_interest * 10000)/10000)+'</td>';
    log_total += '<td>'+number_format_custom(Math.round(total_amount * 10000)/10000)+'</td>';
    log_total += '</tr>';
    $('.loan-calculator tfoot').append(log_total);
    
    if (currency_symbol == 'đ') {
      $('#advance_payment').html(number_format_custom(Math.round(advance_payment)) + ' vnđ');
      $('#bank_loan').html(number_format_custom(Math.round(loan_total)) + ' vnđ');
      $('#loan_interest').html(number_format_custom(Math.round(sum_interest)) + ' vnđ');
      $('#total_amount').html(number_format_custom(Math.round(total_amount)) + ' vnđ');
      $('#m_monthly_val').html(number_format_custom(Math.round(total_amount)) + ' vnđ');
    } else {
      $('#advance_payment').html('$ ' + number_format_custom(Math.round(advance_payment)));
      $('#bank_loan').html('$ ' + number_format_custom(Math.round(loan_total)));
      $('#loan_interest').html('$ ' + number_format_custom(Math.round(sum_interest)));
      $('#total_amount').html('$ ' + number_format_custom(Math.round(total_amount)));
      $('#m_monthly_val').html('$ ' + number_format_custom(Math.round(total_amount)));
    }

    var ctx = document.getElementById('mortgage-calculator-chart').getContext('2d');

    // if (typeof calDoughnutChart !== 'undefined') {
    //     calDoughnutChart.destroy();
    // }

    calDoughnutChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [Math.round(advance_payment), Math.round(loan_total), Math.round(sum_interest), Math.round(total_amount)],
          backgroundColor: [
          'rgba(255, 99, 132, 0.5)',
          'rgba(54, 162, 235, 0.5)',
          'rgba(255, 206, 86, 0.5)',
          'rgba(75, 192, 192, 0.5)'
          ],
          borderColor: [
          'rgba(255 ,99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        cutoutPercentage: 85,
        responsive: false,
        tooltips: false,
      }
    });
  }

  // Get URL Parameter
  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;

    for (i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');

      if (sParameterName[0] === sParam) {
        return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
    return false;
  };

  /* ==================================================================
   *
   * Loading Jquery
   *
   ================================================================== */
  $(document).ready(function() {
    // Call to function
    // Header search button
    if ($('.advanced-search-nav').length > 0) {
      $('.header-mobile .header-mobile-right').prepend('<button class="btn toggle-button-search"><i class="fas fa-search"></i></button>');

      $('.header-mobile .toggle-button-search').on('click', function() {
        $('.advanced-search-nav:not(.mobile-search-nav)').toggleClass('advanced-search-nav-show');

        if ($('#overlay-search-advanced-module').length > 0) {
          $('#overlay-search-advanced-module').toggleClass('open');
        }
      });
    }

    // Sort project
    $('#sort_project').on('change', function() {
      var key = 'sortby';
      var value = $(this).val();
      insertParam( key, value );
    });

    // Filter project
    $('#filter_project').on('change', function() {
      var key = 'filterby';
      var value = $(this).val();
      // insertParam( key, value );
      if ($('.project-search-nav .project_status').length > 0) {
        $('.project-search-nav .project_status').val(value);
        $('.project-search-nav button[type="submit"').trigger('click');        
      }
    });
    
    // Search bar Project
    /*if ($('.houzez-project-keyword-autocomplete').length > 0) {
      myCasaProjectAutoComplete();
    }

    if ($('.project-price-range-wrap').length > 0) {
      project_price_range_search();
    }*/
      
    // Bannerr Search
    if ( $('.banner-search-form-field-autocomplete').length > 0 ) {
      myCasaProjectAutoComplete();
    }      

    // Property //
    // Search bar Property
    /*if ($('.houzez-search-form-js input[name="project-name"]').length > 0 && $('.houzez-keyword-autocomplete').length == 0) {
      $('.houzez-search-form-js .advanced-search-v1 input[name="project-name"]').wrap('<div class="search-icon"></div>');
      $('.houzez-search-form-js .advanced-search-v1 .search-icon').append('<div id="auto_complete_ajax" class="auto-complete"></div>');
      myCasaProjectAutoComplete();
    }
    
    if ($('.houzez-search-form-js input[name="search-custom"]').length > 0 && $('.houzez-keyword-autocomplete').length == 0) {
      $('.houzez-search-form-js input[name="search-custom"]').removeClass('houzez_search_ajax');
      $('.houzez-search-form-js input[name="search-custom"]').wrap('<div class="search-icon"></div>');
      $('.houzez-search-form-js .search-icon').append('<div id="auto_complete_ajax" class="auto-complete"></div>');
      myCasaProjectAutoComplete();
    }*/

    // Add default value for label field search
    if ($('body').hasClass('tax-property_label') || $('body').hasClass('page-template-banner-search')) {
      var term_label = 'lease';
      if ($('body').hasClass('term-resell') || $('body').hasClass('banner-search-type-resell')) {
        term_label = 'resell';
      }

      $('#advanced-search-filters .advanced-search-filters select[name="label[]"]').val(term_label);
      $('#advanced-search-filters .advanced-search-filters select[name="label[]"]').selectpicker('refresh');
      $('#advanced-search-filters .advanced-search-filters select[name="label[]"]').parents('.flex-search').addClass('hidden');

      // For mobile search
      $('#overlay-search-advanced-module select[name="label[]"]').val(term_label);
      $('#overlay-search-advanced-module select[name="label[]"]').selectpicker('refresh');
      $('#overlay-search-advanced-module select[name="label[]"]').parents('.col-6').addClass('hidden');
    }

    // Comment form
    if ($('.property-review-wrap').length > 0) {
      $('.property-review-wrap .block-title-wrap > a.btn-slim').on('click', function() {
        $('#property-review-form').toggleClass('mobile-property-review-show');

        return false;
      });
    }
    // End Property //

    // Search half map
    /*if ($('.advanced-search-half-map .houzez-search-form-js input[name="search-custom"]').length > 0 && $('.houzez-keyword-autocomplete').length == 0) {
      $('.advanced-search-half-map .houzez-search-form-js input[name="search-custom"]').wrap('<div class="search-icon"></div>');
      $('.advanced-search-half-map .houzez-search-form-js .search-icon').append('<div id="auto_complete_ajax" class="auto-complete"></div>');
      myCasaProjectAutoComplete();
    }*/
    
    // $('#half-map-listing-area input[name="search-custom"]').removeClass('houzez_search_ajax');
    $('#half-map-listing-area .form-group > input, #half-map-listing-area .form-group select, #half-map-listing-area .control--checkbox > input').removeClass('houzez_search_ajax');
    //$('#half-map-listing-area .half-map-buttons-wrap > button, .overly_is_halfmap .houzez-search-form-js button.btn-search').removeClass('half-map-search-js-btn');

    if (typeof houzez_map_properties_override !== "undefined") {
      houzez_map_properties = houzez_map_properties_override;
    }

    // Search normal
    if ($('body').hasClass('page-template-template-search')) {
      let tax_label = getUrlParameter('label%5B%5D');
      $('.main-nav .menu-item').each(function(i, obj) {
        if ($(this).children('a').text().toLowerCase() == tax_label) {
          $(this).addClass('current-menu-item');
        }
      });
    }

    // Hidden auto_complete_ajax resulf
    if ($('#auto_complete_ajax').length > 0) {
      $('#auto_complete_ajax').before('<span class="hidden-search-ajax"><i aria-hidden="true" class="fas fa-times"></i></span>');

      $('.hidden-search-ajax').on('click', function() {
        $(this).next('#auto_complete_ajax').empty();
      });
    }

    // Scroll to element
    $('.js-scroll-to-element').on('click', scrollToElement);

    // Custom form file
    $(document).on('change','.js-form-file' , function(){
      var filename = $(this).val().match(/[^\\/]*$/)[0];
      var parent_field = $(this).parents('.form-field');
      parent_field.find('.field-description').html('File selected: <span class="file-selected">' + filename + '</span>');
    });

    // Auto add informatio to conact form 7
    if ($('.career-page-title').length > 0 && $('input.career-title').length > 0) {
      var career_title = $('.career-page-title').val();
      $('input.career-title').val(career_title);
    }

    if ($('.post-name-hidden').length > 0 && $('input.post-name').length > 0) {
      var post_name = $('.post-name-hidden').val();
      $('input.post-name').val(post_name);
      if ( $('.hz-form-message').length > 0 ) {
        $('.hz-form-message').append('Hello, I am interested in [' + post_name + ']');
      }
    }

    if ($('.post-link-hidden').length > 0 && $('input.post-link').length > 0) {
      var post_link = $('.post-link-hidden').val();
      $('input.post-link').val(post_link);
    }

    // Project Detail
    var project_detail_gallery = $('#project-gallery-js');
    if( project_detail_gallery.length > 0 ) { 
      project_detail_gallery.lightSlider({
        rtl: false,
        gallery:true,
        item:1,
        thumbItem:8,
        slideMargin: 0,
        speed:500,
        adaptiveHeight: true,
        auto:false,
        loop:true,
        prevHtml: '<button type="button" class="slick-prev slick-arrow"></button>',
        nextHtml: '<button type="button" class="slick-next slick-arrow"></button>',
        onSliderLoad: function() {
          project_detail_gallery.removeClass('cS-hidden');
          $('.top-gallery-section .lSPager > li').each(function(e) {
            let thumb_url = $(this).find('img').attr('src');
            $(this).find('> a').css({
              'background-image': 'url('+thumb_url+')',
              'padding-top': 'calc(70 / ' + $(this).innerWidth() + ' * 100%)',
            });
          });
        },
        onAfterSlide: function (el) {
          $('.top-gallery-section .lSPager > li').each(function(e) {
            let thumb_url = $(this).find('img').attr('src');
            $(this).find('> a').css({
              'background-image': 'url('+thumb_url+')',
              'padding-top': 'calc(70 / ' + $(this).innerWidth() + ' * 100%)',
            });
          });
        }
      });
    }

    if( $('#calculate_loan_custom').length > 0 ) {

      var total_price = $('#total_price').val();
      var down_payment = $('#down_payment').val();
      var interest_rate = $('#interest_rate').val();
      var loan_term = $('#loan_term').val();
      var currency_symbol = $('#currency_symbol').val();

      mortgage_calucaltion_section_custom(total_price, down_payment, interest_rate, loan_term, currency_symbol);

      $('#calculate_loan_custom').on('click', function(e) {
        e.preventDefault();

        $('.loan-calculator tbody, .loan-calculator tfoot').empty();

        var total_price = $('#total_price').val();
        var down_payment = $('#down_payment').val();
        var interest_rate = $('#interest_rate').val();
        var loan_term = $('#loan_term').val();
        var currency_symbol = $('#currency_symbol').val();

        mortgage_calucaltion_section_custom(total_price, down_payment, interest_rate, loan_term, currency_symbol);

      });

      $('.loan-calculator .popup-close').on('click', function(){
        $('.loan-calculator').trigger('click');
      });
    }

    $(window).resize(function() {
      // Call to function
      if( project_detail_gallery.length > 0 ) { 
        project_detail_gallery.goToSlide(1);
      }
    });

    // Home page
    if ($('.elementor-widget-houzez_elementor_testimonials_v2').length > 0) {
      $('.elementor-widget-houzez_elementor_testimonials_v2 .testimonial-item .testimonial-body').matchHeight();
    }

    // Blog list page
    if ($('body').hasClass('page-template-blog-grid-2cols')) {
      $('.blog-wrap .blog-post-item-wrap .blog-post-item').matchHeight();
    }

    // About Us
    if ($('.elementor-widget-houzez_elementor_blog_posts').length > 0) {
      $('.elementor-widget-houzez_elementor_blog_posts .blog-posts-module-v1 .module-row > div').each(function(){
        if ($(this).find('.blog-post-item .blog-post-thumb').length == '') {
          $(this).find('.blog-post-item').prepend('<div class="blog-post-thumb"><img src="https://via.placeholder.com/592x444?Text=My+Casa" /></div>');
        }
      });
      $('.elementor-widget-houzez_elementor_blog_posts .blog-posts-module-v1 .blog-post-content-wrap').matchHeight();
    }

    if ($('.js-slide-carousel').length > 0) {
      $('.js-slide-carousel > .elementor-container').slick({
        lazyLoad: 'ondemand',
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        arrows: true,
        adaptiveHeight: true,
        dots: true,
        responsive: [{
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 769,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          }
        ]
      });
    }

    // Add class no-translate
    $('.block-title-wrap > h2').addClass('notranslate');
  });

  $(window).scroll(function() {
    // Call to function
  });

  $(window).load(function() {
    // Call to function
    if ($('#half-map-listing-area .price-range').length > 0) {
      $('.price-range').slider('destroy');
      price_range_search(0, 25000000);
    }
  });

})(jQuery);