<?php
require_once('init/shortcode.php');
require_once('init/function-ajax.php');
require_once('init/theme-init.php');

// Add google API Key
add_action('acf/init', function() {
  $theme_options = get_option('houzez_options');
  $google_api_key = $theme_options['googlemap_api_key'];
  acf_update_setting('google_api_key', $google_api_key);
});

// Register Child theme style
if(!is_admin()) {
  // Add scripts
  function houzez_child_scripts() {
    $theme_options = get_option('houzez_options');
    $google_api_key = $theme_options['googlemap_api_key'];

    wp_register_script('houzez-child-cookie', get_stylesheet_directory_uri() . '/access/js/libs/jquery.cookie.js', array('jquery'), '1.4.1', true);
    wp_enqueue_script('houzez-child-cookie');

    wp_register_script('houzez-child-matchheight', get_stylesheet_directory_uri() . '/access/js/libs/jquery.matchHeight-min.js', array('jquery'), '0.7.0', true);
    wp_enqueue_script('houzez-child-matchheight');

    if ( is_singular('project') ) {
      wp_enqueue_script('houzez-child-google-map-api', 'https://maps.google.com/maps/api/js?libraries=places&language=' . get_locale() . '&key=' . esc_html($google_api_key), array(), false, true);
      wp_script_add_data( 'houzez-child-google-map-api', 'defer', true );

      wp_register_script('houzez-child-chart', get_template_directory_uri() . '/js/vendors/Chart.min.js', array('jquery'), '1.1.3', true);
      wp_enqueue_script('houzez-child-chart');

      wp_register_script('houzez-child-lightslider', get_template_directory_uri() . '/js/vendors/lightslider.min.js', array('jquery'), '1.1.3', true);
      wp_enqueue_script('houzez-child-lightslider');

      wp_register_script('houzez-child-google-build-map', get_stylesheet_directory_uri() . '/access/js/libs/jquery.google-build-map.js', array('jquery'), '1.0.0', TRUE);
      wp_enqueue_script('houzez-child-google-build-map');
    }

    wp_register_script('child-theme-script', get_stylesheet_directory_uri() . '/access/js/child-theme-script.js', array('jquery'), '1.8.0', true);
    wp_localize_script( 'child-theme-script', 'customAjax', array( 'ajaxurl' => admin_url('admin-ajax.php' )));
    wp_enqueue_script('child-theme-script');
  }
  add_action('wp_print_scripts', 'houzez_child_scripts');

  // Add stylesheet
  function houzez_child_styles() {
    if ( is_singular('project') ) {
      wp_enqueue_style('lightslider', get_template_directory_uri() . '/css/lightslider.css', array(), '1.1.3');
    }

    $styles = get_stylesheet_directory_uri() . '/access/css/child-theme-style.css';
    
    wp_register_style('child-theme-style', $styles, array(), '1.0', 'all');
    wp_enqueue_style('child-theme-style');
  }
  add_action('wp_enqueue_scripts', 'houzez_child_styles');
}

// Add admin script
function houzez_child_admin_scripts() {
  wp_register_script('admin-script', get_stylesheet_directory_uri() . '/access/js/admin-script.js', array('jquery'), '1.0.0', true);
  wp_enqueue_script('admin-script');
}
add_action('admin_init', 'houzez_child_admin_scripts');

// Add admin style
function houzez_child_admin_styles() {
  wp_register_style('admin-style', get_stylesheet_directory_uri() . '/access/css/admin-style.css', array(), '1.0', 'all');
  wp_enqueue_style('admin-style');
}
add_action('admin_init', 'houzez_child_admin_styles');

// Fix redirect Project singular post type
add_filter('redirect_canonical','houzez_child_disable_redirect_canonical');
function houzez_child_disable_redirect_canonical($redirect_url) {
  if (is_singular('project')) $redirect_url = false;
  if (is_singular('post')) $redirect_url = false;
  return $redirect_url;
}

if(!function_exists('houzez_child_hide_admin_bar')) {
  function houzez_child_hide_admin_bar() {
    if (current_user_can('editor')) {
      show_admin_bar( true );
    }
  }
  add_action( 'wp', 'houzez_child_hide_admin_bar' );
  add_action( 'admin_init', 'houzez_child_hide_admin_bar', 9 );
}

// Fontawesome Icon Class
function houzez_child_fa_icon_class($mimetype, $type = 'far') {
  $icon_class = $type . ' ' . 'fa-file color-txt';

  switch ($mimetype) {
    case 'application/pdf':
      $icon_class = $type . ' ' . 'fa-file-pdf color-pdf';
      break;
    
    default:
      $icon_class = $icon_class;
      break;
  }

  return $icon_class;
}

// Get Price by Language code (slug)
function houzez_child_price_by_pll($langcode) {
  global $post;
  $price_group = array();

  switch ($langcode) {
    case '/en/vi':
    case '/en/vn':
      if ($post->post_type == 'property') {
        $price_group = array(
          'rent_price' => get_post_meta($post->ID, 'fave_rent-vnd', true) ? number_format((int)get_post_meta($post->ID, 'fave_rent-vnd', true), 0, '.', ',') . __('vnd', 'houzez_child') : null,
          'after_rent_price' => __('month', 'houzez_child'),
          'total_sale_price' => get_post_meta($post->ID, 'fave_resale-vnd', true) ? number_format((int)get_post_meta($post->ID, 'fave_resale-vnd', true), 0, '.', ',') . __('vnd', 'houzez_child') : null,
          'sale_price_sqm' => get_post_meta($post->ID, 'fave_price-sqm-vnd', true) ? number_format((int)get_post_meta($post->ID, 'fave_price-sqm-vnd', true), 0, '.', ',') . __('vnd', 'houzez_child') : null,
          'after_sale_price' => __('sqm', 'houzez_child')
        );
      } elseif ($post->post_type == 'project') {
        $price_group = array(
          'project_price' => get_field( 'avg_unit_price_sqm_vnd', $post->ID) ? number_format((int)get_field( 'avg_unit_price_sqm_vnd', $post->ID), 0, '.', ',') . __('vnd', 'houzez_child') : __('Contact', 'houzez_child')
        );
      }      
      break;
    
    default:
      if ($post->post_type == 'property') {
        $price_group = array(
          'rent_price' => get_post_meta($post->ID, 'fave_property_price', true) ? '$' . number_format((int)get_post_meta($post->ID, 'fave_property_price', true), 0, '.', ',') : null,
          'after_rent_price' => get_post_meta($post->ID, 'fave_property_price_postfix', true),
          'total_sale_price' => get_post_meta($post->ID, 'fave_resale-usd', true) ? '$' . number_format((int)get_post_meta($post->ID, 'fave_resale-usd', true), 0, '.', ',') : null,
          'sale_price_sqm' => get_post_meta($post->ID, 'fave_price-sqm-usd', true) ? '$' . number_format((int)get_post_meta($post->ID, 'fave_price-sqm-usd', true), 0, '.', ',') : null,
          'after_sale_price' => get_post_meta($post->ID, 'fave_property_size_prefix', true)
        );
      } elseif ($post->post_type == 'project') {
        $price_group = array(
          'project_price' => get_field( 'avg_unit_price_sqm_usd', $post->ID) ? '$' . number_format((int)get_field( 'avg_unit_price_sqm_usd', $post->ID), 0, '.', ',') : __('Contact', 'houzez_child')
        );
      }
      break;
  }

  return $price_group;
}

// Insert to wp_head and wp_footer
add_action('wp_footer', 'houzez_child_insert_footer'); 
function houzez_child_insert_footer() {
  echo do_shortcode('[hfe_template id="82164"]');
  echo do_shortcode('[translate_switch]');
}

// Image Crop functions
function houzez_child_crop_align($image, $cropWidth, $cropHeight, $horizontalAlign = 'center', $verticalAlign = 'middle') {
  $imgsize = getimagesize($image);
  $mime = $imgsize['mime'];

  switch ($mime) {
    case 'image/gif':
      $image_create = "imagecreatefromgif";
      break;

    case 'image/png':
      $image_create = "imagecreatefrompng";
      break;

    case 'image/jpeg':
      $image_create = "imagecreatefromjpeg";
      break;

    default:
      return false;
      break;
  }

  $im = $image_create($image);

  $width = imagesx($im);
  $height = imagesy($im);
  $horizontalAlignPixels = houzez_child_calculate_pixels_align($width, $cropWidth, $horizontalAlign);
  $verticalAlignPixels = houzez_child_calculate_pixels_align($height, $cropHeight, $verticalAlign);
  $imObj = imageCrop($im, [
    'x' => $horizontalAlignPixels[0],
    'y' => $verticalAlignPixels[0],
    'width' => $horizontalAlignPixels[1],
    'height' => $verticalAlignPixels[1]
  ]);

  ob_start();
  imagePng($imObj);
  $imgData = ob_get_clean();
  imagedestroy($im);

  $imUrl = 'data:image/png;base64,'.base64_encode($imgData);
  return $imUrl;
}

function houzez_child_calculate_pixels_align($imageSize, $cropSize, $align) {
  switch ($align) {
    case 'left':
    case 'top':
      return [0, min($cropSize, $imageSize)];
    case 'right':
    case 'bottom':
      return [max(0, $imageSize - $cropSize), min($cropSize, $imageSize)];
    case 'center':
    case 'middle':
      return [
        max(0, floor(($imageSize / 2) - ($cropSize / 2))),
        min($cropSize, $imageSize),
      ];
    default: return [0, $imageSize];
  }
}
