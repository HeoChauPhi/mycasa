<?php
/**
 * Plugin Name: MyCasa Rest API
 * Plugin URI:  https://dev-mycasa.pantheonsite.io/
 * Description: Create Rest API
 * Version:     1.0
 * Author:      MyCasa
 * Author URI:  https://dev-mycasa.pantheonsite.io/
 * License:     GPL-2.0+
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

define( 'MYCASA_RESTAPI_PLUGIN_PATH', '/wp-content/plugins/mycasa-rest-api' );

add_action( 'rest_api_init', function() {
  register_rest_route( 'api/v1', '/stocks', [
    'methods' => 'GET',
    'callback' => 'mycasa_restapi_get_stocks',
    'permission_callback' => '__return_true',
  ] );
} );

// Get Google Address from Lat/Lon
function mycasa_restapi_get_address($latitude, $longitude) {
  $gg_map_api_key = 'AIzaSyDXTzcKeymQWRfKZgZGf_N6WuCK1HTxduo';
  //google map api url
  $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&sensor=false&key=AIzaSyDXTzcKeymQWRfKZgZGf_N6WuCK1HTxduo";
  $address_arr = [];
  $address_components = [];
  
  // send http request
  $geocode = file_get_contents($url);
  $json = json_decode($geocode);
  // $results = $json->results[0]->address_components;
  $results = $json->results;

  foreach ($results as $result) {
    $address_components  = array_merge($address_components, $result->address_components);
  }

  if ($address_components) {
    foreach ($address_components as $address) {
      if ( !empty(in_array('postal_code', $address->types)) ) {
        $address_arr['zip'] = $address->long_name;
      }
      if ( in_array('street_number', $address->types) ) {
        $address_arr['street_number'] = $address->long_name;
      }
      if ( in_array('route', $address->types) ) {
        $address_arr['street'] = $address->long_name;
      }
      if ( in_array('sublocality', $address->types) ) {
        $address_arr['province'] = $address->long_name;
      }
      if ( in_array('country', $address->types) ) {
        $address_arr['country'] = $address->long_name;
      }
      if ( in_array('administrative_area_level_1', $address->types) ) {
        $address_arr['city'] = $address->long_name;
      }
      if ( in_array('neighborhood', $address->types) ) {
        $address_arr['neighborhood'] = $address->long_name;
      }
    }
  }

  return array_unique($address_arr);
}

// Get all projects and assign thumbnail
function mycasa_restapi_get_stocks( $params ) {
  // $whitelist = [
  //   '172.27.0.6', // Local env
  //   '108.129.6.116/32',
  //   '34.248.101.243/32',
  //   '52.51.195.1/32',
  //   '34.251.220.39/32'
  // ];

  // if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
  //   wp_redirect(home_url());
  //   exit();
  // } else {
    $data_name = 'Mycasa group';
    $data_lang = 'en';
    $data_phone = '+84906899300';
    $data_email = 'sales@mycasagroup.com';
    $data_website = 'https://mycasagroup.com';
    $data_updated = '2021-05-17T00:00:00';
    $data_province = 'Ho Chi Minh City';
    $data_instagram = 'https://www.instagram.com/mycasagroup/';
    $data_facebook = 'https://www.facebook.com/mycasagroup';
    $data_youtube = 'https://www.youtube.com/channel/UCGHUJzJ5hZL-fu1HyZK4M_Q';
    $data_tiktok = 'https://vt.tiktok.com/ZSeAyNyop/';
    $data_linkedin = 'https://www.linkedin.com/company/mycasagroup';

    $xml = new XMLWriter();
    $xml->openMemory();
    $xml->startDocument('1.0', 'UTF-8'); // TODO: Start XML Document
    $xml->startElement('document'); // TODO: start document root element

    $xml->writeElement('agent_name', $data_name);
    $xml->writeElement('language', $data_lang);
    $xml->writeElement('phone', $data_phone);
    $xml->writeElement('email', $data_email);
    $xml->writeElement('website', $data_website);
    $xml->writeElement('updated_at', $data_updated);
    $xml->writeElement('province', $data_province);

    $xml->startElement('properties'); // TODO: start Properties root element

    $args =  [
      'post_type' => 'property',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'fields' => 'ids',
    ];

    $the_query = new WP_Query( $args );
    // The Loop
    if ( $the_query->have_posts() ) :
      foreach ($the_query->posts as $postid) {
        $data_pid = (int) $postid;
        $data_id = get_post_meta($data_pid, 'fave_unit-code', true) ? get_post_meta($data_pid, 'fave_unit-code', true) : $data_pid;
        $data_title = trim(get_the_title());
        $data_content = trim(strip_tags(get_the_content()));
        $data_rent_usd = get_post_meta($data_pid, 'fave_property_price', true) ? get_post_meta($data_pid, 'fave_property_price', true) : 0;
        $data_rent_vnd = get_post_meta($data_pid, 'fave_rent-vnd', true) ? get_post_meta($data_pid, 'fave_rent-vnd', true) : 0;
        $data_sale_usd = get_post_meta($data_pid, 'fave_resale-usd', true) ? get_post_meta($data_pid, 'fave_resale-usd', true) : 0;
        $data_sale_vnd = get_post_meta($data_pid, 'fave_resale-vnd', true) ? get_post_meta($data_pid, 'fave_resale-vnd', true) : 0;
        $data_type = wp_get_post_terms($data_pid, 'property_type', array('fields' => 'names')) ? implode(',', wp_get_post_terms($data_pid, 'property_type', array('fields' => 'names'))) : null;
        $data_project = get_post_meta($data_pid, 'fave_project-name', true) ? get_post_meta($data_pid, 'fave_project-name', true) : '';

        if ($data_project) {
          $data_prid = get_page_by_title($data_project, OBJECT, 'project')->ID;
          $data_video = get_field('video_url', $data_prid);
        }

        $data_address = get_post_meta($data_pid, 'fave_property_map_address', true) ? get_post_meta($data_pid, 'fave_property_map_address', true) : '';
        $data_location = get_post_meta($data_pid, 'fave_property_location', true) ? get_post_meta($data_pid, 'fave_property_location', true) : '0,0';
        $data_lat = explode(",", $data_location)[0];
        $data_lon = explode(",", $data_location)[1];
        $data_address_arr = mycasa_restapi_get_address($data_lat, $data_lon);
        $data_fully = 'fully';
        $data_ownership = 'freehold';
        $data_year = get_post_meta($data_pid, 'fave_property_year', true) ? date('Y', strtotime(get_post_meta($data_pid, 'fave_property_year', true))) : date('Y');
        $data_contract = '6 year';
        $data_bedrooms = get_post_meta($data_pid, 'fave_property_bedrooms', true) ? get_post_meta($data_pid, 'fave_property_bedrooms', true) : 2;
        $data_bathrooms = get_post_meta($data_pid, 'fave_property_bathrooms', true) ? get_post_meta($data_pid, 'fave_property_bathrooms', true) : 2;
        $data_floor = null;
        $data_floorarea = get_post_meta($data_pid, 'fave_property_size', true) ? get_post_meta($data_pid, 'fave_property_size', true) : 'contact';
        $data_floorarea_unit = get_post_meta($data_pid, 'fave_property_size_prefix', true) ? get_post_meta($data_pid, 'fave_property_size_prefix', true) : 'sqm';
        $data_plotarea = $data_floorarea;
        $data_plotarea_unit = $data_floorarea_unit;
        $data_images = get_field( 'gallery_url', $data_pid );
        $data_images_upload = get_field( 'gallery_upload', $data_pid );
        $data_amenities = wp_get_post_terms($data_pid, 'property_feature', array('fields' => 'names')) ? wp_get_post_terms($data_pid, 'property_feature', array('fields' => 'names')) : null;
        $data_source = get_permalink($data_pid);

        // TODO: Property Item
        $xml->startElement('property'); // TODO: Start Property Item

        $xml->writeElement('property_id', $data_id);

        $xml->startElement('prices'); // TODO: Start Prices List Element
        $xml->startElement('price'); // TODO: Start Price Rent USD Item Element
        $xml->writeAttribute('currency', 'USD');
        $xml->writeAttribute('tenure', 'rent');
        $xml->writeAttribute('period', 'monthly');
        $xml->text($data_rent_usd);
        $xml->endElement(); // TODO: End Price Rent USD Item Element
        $xml->startElement('price'); // TODO: Start Price Rent VND Item Element
        $xml->writeAttribute('currency', 'VND');
        $xml->writeAttribute('tenure', 'rent');
        $xml->writeAttribute('period', 'monthly');
        $xml->text($data_rent_vnd);
        $xml->endElement(); // TODO: End Price Rent VND Item Element
        $xml->startElement('price'); // TODO: Start Price Sale USD Item Element
        $xml->writeAttribute('currency', 'USD');
        $xml->writeAttribute('tenure', 'resale');
        $xml->text($data_sale_usd);
        $xml->endElement(); // TODO: End Price Sale USD Item Element
        $xml->startElement('price'); // TODO: Start Price Sale VND Item Element
        $xml->writeAttribute('currency', 'VND');
        $xml->writeAttribute('tenure', 'resale');
        $xml->text($data_sale_vnd);
        $xml->endElement(); // TODO: End Price Sale VND Item Element
        $xml->endElement(); // TODO: End Prices List Element

        $xml->writeElement('rental_min_terms', $data_contract);

        $xml->startElement('address'); // TODO: Start Address Element
        $xml->writeElement('province', $data_address_arr['province'] ? $data_address_arr['province'] : 'N/A');
        $xml->writeElement('city', $data_address_arr['city'] ? $data_address_arr['city'] : 'N/A');
        $xml->writeElement('area', $data_address_arr['area'] ? $data_address_arr['area'] : 'N/A');
        $xml->writeElement('transport', $data_address_arr['transport'] ? $data_address_arr['transport'] : 'N/A');
        $xml->writeElement('street', $data_address_arr['street'] ? $data_address_arr['street'] : 'N/A');
        $xml->writeElement('zip', $data_address_arr['i'] ? $data_address_arr['i'] : 'N/A');
        $xml->writeElement('gps_lat', $data_lat);
        $xml->writeElement('gps_lon', $data_lon);
        $xml->endElement(); // TODO: End Address Element

        $xml->writeElement('project', $data_project);

        $xml->startElement('details'); // TODO: Start Details Element
        $xml->writeElement('furnished', $data_fully);
        $xml->writeElement('ownership', $data_ownership);
        $xml->writeElement('video_id', $data_video ? $data_video  : $data_youtube);
        $xml->writeElement('type', $data_type);
        $xml->writeElement('sub_type', $data_type);
        $xml->writeElement('bedrooms', $data_bedrooms);
        $xml->writeElement('bathrooms', $data_bathrooms);

        $xml->startElement('floor_size');
        $xml->writeAttribute('unit', $data_floorarea_unit);
        $xml->text($data_floorarea);
        $xml->endElement();

        $xml->startElement('land_size');
        $xml->writeAttribute('unit', $data_plotarea_unit);
        $xml->text($data_plotarea);
        $xml->endElement();

        $xml->writeElement('floor', $data_floor ? $data_floor : 1);

        $xml->startElement('facilities'); // TODO: Start Features List Element
        if ( $data_amenities ) {
          foreach ($data_amenities as $amenity) {
            $xml->writeElement('facility', $amenity);
          }
        } else {
          $xml->writeElement('facility', null);
        }
        $xml->endElement(); // TODO: End Features List Element

        $xml->startElement('titles'); // TODO: Start Titles List Element
        $xml->startElement('title'); // TODO: Start Title Item Element
        $xml->writeAttribute('lang', 'en');
        $xml->text(sprintf('<![CDATA[%s]]>', $data_title));
        $xml->endElement(); // TODO: End Title Item Element
        $xml->endElement(); // TODO: End Titles List Element

        $xml->startElement('descriptions'); // TODO: Start Descriptions List Element
        $xml->startElement('description'); // TODO: Start Description Item Element
        $xml->writeAttribute('lang', 'en');
        $xml->text(sprintf('<![CDATA[%s]]>', $data_content));
        $xml->endElement(); // TODO: End Description Item Element
        $xml->endElement(); // TODO: End Descriptions List Element
        $xml->endElement(); // TODO: End Details Element

        $xml->startElement('images'); // TODO: Start Images Element
        if (!empty($data_images_upload)) {
          $data_pictures = $data_images_upload;

          foreach ($data_pictures as $index=>$url) {
            $xml->startElement('image'); // TODO: Start Image Item Element
            $xml->writeAttribute('number', ((int)$index + 1));
            $xml->text('image', esc_attr( $url ));
            $xml->endElement(); // TODO: End Image Item Element
          }
        } elseif(!empty($data_images)) {
          $data_pictures = $data_images;

          foreach ($data_pictures as $index=>$url) {
            $xml->startElement('image'); // TODO: Start Image Item Element
            $xml->writeAttribute('number', ((int)$index + 1));
            $xml->text(sprintf('https://adztvetajq.cloudimg.io/%s>', esc_attr( $url['picture_attachement_ids'] )));
            $xml->endElement(); // TODO: End Image Item Element
          }
        } else {
          $xml->startElement('image'); // TODO: Start Image Item Element
          $xml->text(null);
          $xml->endElement(); // TODO: End Image Item Element
        }
        $xml->endElement(); // TODO: End Images Element

        $xml->startElement('contact'); // TODO: Start Contact Element
        $xml->writeElement('name', $data_name);
        $xml->writeElement('phone', $data_phone);
        $xml->writeElement('email', $data_email);
        $xml->endElement(); // TODO: End Contact Element

        $xml->writeElement('datasource', $data_source);

        $xml->endElement(); // TODO: End Property Item
      }
    endif;

    //$output = $xml->asXML();
    $xml->endElement(); // TODO: End Properties root element
    $xml->endElement(); // TODO: End document root element
    $xml->endDocument(); // TODO: End XML Document
    $output = $xml->flush();

    return $output;
  // }
}

function mycasa_restapi_get_stocks_feed( $served, $result, $request, $server ) {
    // Bail if the route of the current REST API request is not our custom route.
    if ( '/api/v1/stocks' !== $request->get_route() ||
        // Also check that the callback is smg_feed().
        'mycasa_restapi_get_stocks' !== $request->get_attributes()['callback'] ) {
        return $served;
    }

    // Send headers.
    $server->send_header( 'Content-Type', 'text/xml' );

    // Echo the XML that's returned by smg_feed().
    echo $result->get_data();

    // And then exit.
    exit;
}
add_filter( 'rest_pre_serve_request', 'mycasa_restapi_get_stocks_feed', 10, 4 );
