(function($) {
  /*
  *  new_map
  *
  *  This function will render a Google Map onto the selected jQuery element
  *
  *  @type  function
  *  @date  8/11/2013
  *  @since 4.3.0
  *
  *  @param $el (jQuery element)
  *  @return  n/a
  */
  function new_map( $el ) {
    // var
    var $markers = $el.find('.marker');

    var $fullscreenControl = true;
    var $mapTypeControl = true;
    if ($el.data('fullscreen-control') == false) {
      $fullscreenControl = false;
    }

    if ($el.data('maptype-control') == false) {
      $mapTypeControl = false;
    }

    // vars
    var args = {
      zoom    : 18,
      center    : new google.maps.LatLng(0, 0),
      scrollwheel : false,
      fullscreenControl: $fullscreenControl,
      mapTypeControl: $mapTypeControl,
      mapTypeId : google.maps.MapTypeId.ROADMAP,
      styles: [
        {
          "featureType": "water",
          "elementType": "geometry.fill",
          "stylers": [
            {
              "color": "#aadafd"
            }
          ]
        }
      ]      
    };
    // create map
    var map = new google.maps.Map( $el[0], args);
    // add a markers reference
    map.markers = [];
    // add markers
    $markers.each(function(){
      add_marker( $(this), map );
    });
    // center map
    center_map( map );
    // return
    return map;
  }

  /*
  *  add_marker
  *
  *  This function will add a marker to the selected Google Map
  *
  *  @type  function
  *  @date  8/11/2013
  *  @since 4.3.0
  *
  *  @param $marker (jQuery element)
  *  @param map (Google Map object)
  *  @return  n/a
  */
  function add_marker( $marker, map ) {
    // var
    var iconBase = $marker.attr('data-icon');
    var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
    // create marker
    var marker = new google.maps.Marker({
      position  : latlng,
      map     : map,
      icon  : iconBase
    });
    // add to array
    map.markers.push( marker );
    // if marker contains HTML, add it to an infoWindow
    if( $marker.html() ) {
      // create info window
      var infowindow = new google.maps.InfoWindow({
        content   : $marker.html()
      });
      infowindow.open( map, marker );
      // show info window when marker is clicked
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.open( map, marker );
      });
    }
  }

  /*
  *  center_map
  *
  *  This function will center the map, showing all markers attached to this map
  *
  *  @type  function
  *  @date  8/11/2013
  *  @since 4.3.0
  *
  *  @param map (Google Map object)
  *  @return  n/a
  */
  function center_map( map ) {
    // vars
    var bounds = new google.maps.LatLngBounds();
    // loop through all markers and create bounds
    $.each( map.markers, function( i, marker ){
      var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
      bounds.extend( latlng );
    });
    // only 1 marker?
    if( map.markers.length == 1 ) {
      // set center of map
      map.setCenter( bounds.getCenter() );
      map.setZoom( 18 );
    } else {
      // fit to bounds
      map.fitBounds( bounds );
    }
  }

  /*
  * Street View
  */
  function street_view_map($el) {
    var lat = $('#'+$el).attr('data-lat'),
        lng = $('#'+$el).attr('data-lng');

    var panorama = new google.maps.StreetViewPanorama(
      document.getElementById($el),
      {
        position: { lat: parseFloat(lat), lng: parseFloat(lng) },
        pov: { heading: 165, pitch: 0 },
        zoom: 1,
      }
    );

    return panorama;
  }

  /*
  *  document ready
  *
  *  This function will render each map when the document is ready (page has loaded)
  *
  *  @type  function
  *  @date  8/11/2013
  *  @since 5.0.0
  *
  *  @param n/a
  *  @return  n/a
  */
  // global var
  var map = null;
  $(document).ready(function(){
    $('.google-build-map').each(function(){
      // create map
      map = new_map( $(this) );
    });

    // $('.google-street-view').each(function(){
    //   street_map = street_view_map($(this));
    // });

    $('.pills-street-view-tab').on('click', function(){
      street_el_id = $(this).attr('href').replace('#', '');
      street_map = street_view_map(street_el_id);
    });
  });
})(jQuery);