<?php
/**
 * Template Name: Property Listing Half Map
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 11/06/16
 * Time: 11:00 PM
 */
get_header();
global $search_style;

$listing_view = houzez_option('halfmap_posts_layout', 'list-view-v1');
$enable_save_search = houzez_option('enable_disable_save_search');

$have_switcher = true;

$wrap_class = $item_layout = $view_class = $cols_in_row = '';
if($listing_view == 'list-view-v1') {
    $wrap_class = 'listing-v1';
    $item_layout = 'v1';
    $view_class = 'list-view';

} elseif($listing_view == 'grid-view-v1') {
    $wrap_class = 'listing-v1';
    $item_layout = 'v1';
    $view_class = 'grid-view';

} elseif($listing_view == 'list-view-v2') {
    $wrap_class = 'listing-v2';
    $item_layout = 'v2';
    $view_class = 'list-view';

} elseif($listing_view == 'grid-view-v2') {
    $wrap_class = 'listing-v2';
    $item_layout = 'v2';
    $view_class = 'grid-view';

} elseif($listing_view == 'grid-view-v3') {
    $wrap_class = 'listing-v3';
    $item_layout = 'v3';
    $view_class = 'grid-view';
    $have_switcher = false;

} elseif($listing_view == 'grid-view-v4') {
    $wrap_class = 'listing-v4';
    $item_layout = 'v4';
    $view_class = 'grid-view';
    $have_switcher = false;

} elseif($listing_view == 'list-view-v5') {
    $wrap_class = 'listing-v5';
    $item_layout = 'v5';
    $view_class = 'list-view';

} elseif($listing_view == 'grid-view-v5') {
    $wrap_class = 'listing-v5';
    $item_layout = 'v5';
    $view_class = 'grid-view';

} elseif($listing_view == 'grid-view-v6') {
    $wrap_class = 'listing-v6';
    $item_layout = 'v6';
    $view_class = 'grid-view';
    $have_switcher = false;

} 

$page_content_position = houzez_get_listing_data('listing_page_content_area');

$listing_args = array(
  'post_type' => 'property',
  'post_status' => 'publish',
  'meta_query' => array(
    'relation'    => 'AND',
  ),
  'tax_query' => array(
    'relation'    => 'AND',
  ),
);

$listing_qry = apply_filters( 'houzez20_property_filter', $listing_args );
$listing_qry = houzez_prop_sort ( $listing_qry );

if (isset($_GET['search-custom']) && $_GET['search-custom'] != '') {
  array_push($listing_qry['meta_query'], array(
    'relation'    => 'OR',
    array(
      'key'   => 'fave_project-name',
      'value'     => $_GET['search-custom'],
      'compare'   => 'LIKE'
    ),
    array(
      'key'   => 'fave_property_map_address',
      'value'     => $_GET['search-custom'],
      'compare'   => 'LIKE'
    ),
    array(
      'key'   => 'fave_code',
      'value'     => $_GET['search-custom'],
      'compare'   => 'LIKE'
    ),
  ));
}

array_push($listing_qry['tax_query'], array(
  'taxonomy' => 'property_status',
  'field' => 'slug',
  'terms' => array( 'living' ),
  'include_children' => true,
  'operator' => 'NOT IN'
));

if (isset($_GET['type']) && $_GET['type'] != '') {
  array_push($listing_qry['tax_query'], array(
    'taxonomy' => 'property_type',
    'field' => 'slug',
    'terms' => $_GET['type'],
    'operator' => 'IN'
  ));
}

if (isset($_GET['label']) && $_GET['label'] != '') {
  array_push($listing_qry['tax_query'], array(
    'taxonomy' => 'property_label',
    'field' => 'slug',
    'terms' => $_GET['label'],
    'operator' => 'IN'
  ));
}

if (isset($_GET['bedrooms']) && $_GET['bedrooms'] != '') {
  array_push($listing_qry['meta_query'], array(
    'key' => 'fave_property_bedrooms',
    'value' => $_GET['bedrooms'],
    'type' => 'CHAR',
    'compare' => '='
  ));
}

if (isset($_GET['min-price']) && $_GET['min-price'] != '' && isset($_GET['max-price']) && $_GET['max-price'] != '') {
  array_push($listing_qry['meta_query'], array(
    'key' => 'fave_property_price',
    'value' => array($_GET['min-price'], $_GET['max-price']),
    'type' => 'NUMERIC',
    'compare' => 'BETWEEN'
  ));
}

$search_query = new WP_Query( $listing_qry );  
$total_properties = $search_query->found_posts;

$enable_search = houzez_option('enable_halfmap_search', 1);
$search_style = houzez_option('halfmap_search_layout', 'v4');

if( isset($_GET['halfmap_search']) && $_GET['halfmap_search'] != '' ) {
    $search_style = $_GET['halfmap_search'];
}

if( wp_is_mobile() ) {
    $search_style = 'v1';
}

if($enable_search != 0 && $search_style != 'v4') {
    get_template_part('template-parts/search/search-half-map-header');
}

$google_build_map = array();
?>
<section class="half-map-wrap map-on-left clearfix">
    <div id="map-view-wrap" class="half-map-left-wrap">
        <div class="map-wrap">
            <?php get_template_part('template-parts/map-buttons'); ?>
            
            <div id="houzez-properties-map"></div> 

            <?php if(houzez_get_map_system() == 'google') { ?>
            <div id="houzez-map-loading" class="houzez-map-loading">
                <div class="mapPlaceholder">
                    <div class="loader-ripple spinner">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>

    <div id="half-map-listing-area" class="half-map-right-wrap <?php echo esc_attr($wrap_class); ?>">

        <?php 
        if($enable_search != 0 && $search_style == 'v4') {
            get_template_part('template-parts/search/search-half-map');
        }
        ?>

        <?php
        if ( $page_content_position !== '1' ) {
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    ?>
                    <article <?php post_class(); ?>>
                        <?php the_content(); ?>
                    </article>
                    <?php
                }
            } 
        }?>

        <div class="page-title-wrap">
            <div class="d-flex align-items-center">
                <div class="page-title flex-grow-1">
                    <span><?php echo esc_attr($total_properties); ?></span> <?php esc_html_e('Results Found', 'houzez');?>
                </div>

                <?php get_template_part('template-parts/listing/listing-sort-by'); ?>  
                <?php 
                if($have_switcher) {
                    get_template_part('template-parts/listing/listing-switch-view'); 
                }?> 
            </div>  
        </div>

        <div class="listing-view <?php echo esc_attr($view_class); ?>" data-layout="<?php echo esc_attr($item_layout); ?>">
            
            <div id="houzez_ajax_container">
                <div class="card-deck">
                <?php
                if ( $search_query->have_posts() ) :
                    while ( $search_query->have_posts() ) : $search_query->the_post();

                        get_template_part('template-parts/listing/item', $item_layout);

                        $address_arr = array(
                        'address' => get_post_meta($post->ID, 'fave_property_map_address', true),
                        'lat' => 0,
                        'lng' => 0
                      );
                      if (function_exists('mycasa_to_odoo_gmap_latlng')) {
                        $address_arr = mycasa_to_odoo_gmap_latlng(get_post_meta($post->ID, 'fave_property_map_address', true));
                      }

                      $price_map = '';
                      if ( !empty($_COOKIE['googtrans']) ) {
                        $current_lang = $_COOKIE['googtrans'];
                        $price_data = houzez_child_price_by_pll($current_lang);

                        if ( !empty($price_data['rent_price']) && !empty($price_data['total_sale_price']) ) {
                          $price_map = $price_data['rent_price'] . '/' . $price_data['after_rent_price'] . ' - ' . $price_data['total_sale_price'];
                        } elseif ( !empty($price_data['rent_price']) && empty($price_data['total_sale_price']) ) {
                          $price_map = $price_data['rent_price'] . '/' . $price_data['after_rent_price'];
                        } elseif ( empty($price_data['rent_price']) && !empty($price_data['total_sale_price']) ) {
                          $price_map = $price_data['total_sale_price'];
                        } else {
                          $price_map = __('contact', 'houzez_child');
                        }
                      } else {
                        if ($post->post_type == 'property' && empty(get_post_meta($post->ID, 'fave_property_price', true))) {
                          $price_map = !empty(get_post_meta($post->ID, 'fave_resale-usd', true)) ? '$' . number_format((int)get_post_meta($post->ID, 'fave_resale-usd', true), 0, '.', ',') : __('Contact', 'houzez_child');
                        } else {
                          $property_rent_price = !empty(get_post_meta($post->ID, 'fave_property_price', true)) ? '$' . number_format((int)get_post_meta($post->ID, 'fave_property_price', true), 0, '.', ',') : null;
                          $property_sale_price = !empty(get_post_meta($post->ID, 'fave_resale-usd', true)) ? '$' . number_format((int)get_post_meta($post->ID, 'fave_resale-usd', true), 0, '.', ',') : null;                      
                          $price_map = $property_rent_price . ' - ' . $property_sale_price;
                        }
                      }

                      if (!empty(get_field('gallery_upload', $post->ID))) {
                        $property_thumb = get_field('gallery_upload', $post->ID)[0];
                      } elseif (!empty(get_field('gallery_url', $post->ID))) {
                        $property_thumb = get_field('gallery_url', $post->ID)[0]['picture_attachement_ids'];
                      } elseif (!empty(get_field('project_id', $post->ID))) {
                        $project_id = get_field('project_id', $post->ID)[0];
                        $property_thumb = get_field('gallery_url', $project_id)[0]['picture_attachement_ids'];
                      } else {
                        $property_thumb = 'https://via.placeholder.com/150x150&text=My+Casa';
                      }
                      
                      array_push($google_build_map, array(
                        "title" => get_the_title(),
                        "url" => get_the_permalink(),
                        "price" => $price_map,
                        "property_id" => $post->ID,
                        "pricePin" => "123",
                        "address" => get_post_meta($post->ID, 'fave_property_map_address', true),
                        "property_type" => "",
                        "lat" => $address_arr['lat'],
                        "lng" => $address_arr['lng'],
                        "term_id" => '',
                        "marker" => home_url('/wp-content/themes/houzez/img/map/pin-single-family.png'),
                        "retinaMarker" => home_url('/wp-content/themes/houzez/img/map/pin-single-family.png'),
                        "thumbnail" => $property_thumb
                      ));

                    endwhile;
                else:
                    
                    echo '<div class="search-no-results-found">';
                        esc_html_e('No results found', 'houzez');
                    echo '</div>';
                    
                endif;
                wp_reset_postdata();
                wp_localize_script( 'child-theme-script', 'houzez_map_properties_override', $google_build_map );
                ?> 
                </div>

                <div class="clearfix"></div>
                <?php houzez_pagination( $search_query->max_num_pages ); ?>
            </div>
            
        </div><!-- listing-view -->

        <?php
        if ('1' === $page_content_position ) {
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    ?>
                    <section class="content-wrap">
                        <?php the_content(); ?>
                    </section>
                    <?php
                }
            }
        }
        ?>
        
    </div>
</section>
<?php get_footer(); ?>