(function($) {
  function setDate() {
    var dateFormat = "yy-mm-dd",
        from = $( "#data_time_from" )
          .datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1
          })
          .on( "change", function() {
            to.datepicker( "option", "minDate", getDate( this ) );
          }),
        to = $( "#data_time_to" ).datepicker({
          dateFormat: "yy-mm-dd",
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          from.datepicker( "option", "maxDate", getDate( this ) );
        });

    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }

      return date;
    }
  }

  $(document).ready(function() {
    // Call to function
    //$( ".mycasa-form-datepicker" ).MonthPicker({ MonthFormat: 'yy-mm' });
    setDate();

    $('.mycasa-form-datepicker-clear').on('click', function(){
      //$('.mycasa-form-datepicker').MonthPicker('Clear');
      $('.input-get-data-time').val(null);
      $('.input-get-data-time').datepicker( "destroy" );
      setDate();
      return false;
    });
  });

  $(window).load(function() {
    // Call to function
  });

  $(window).resize(function() {
    // Call to function
  });
})(jQuery);
