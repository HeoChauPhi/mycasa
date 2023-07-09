<?php
/**
 * Template Name: Banner Search
 * Created by Mycasa.
 * User: Mycasa
 * Date: 09/02/2021
 * Time: 0:00 AM
 */

add_filter( 'body_class','houzez_child_banner_search_body_classes' );
function houzez_child_banner_search_body_classes( $classes ) {
  $classes[] = 'banner-search-type-' . $_GET['type'];
  return $classes;
}
get_header();

global $post, $total_listing_found;

$listing_args = array(
  'post_status' => 'publish',
  'meta_query' => array(
    'relation'    => 'AND',
  ),
);

$sortby = '';
if( isset( $_GET['sortby'] ) ) {
  $sortby = $_GET['sortby'];
}

if (isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] != 'project') {
  $listing_args['post_type'] = 'property';
  $listing_args['orderby'] = 'meta_value date';
  $listing_args['meta_key'] = 'fave_featured';

  $listing_args['tax_query'] = array(
    'relation'    => 'AND',
    array(
      'taxonomy' => 'property_status',
      'field' => 'slug',
      'terms' => array( 'living' ),
      'include_children' => true,
      'operator' => 'NOT IN'
    ),
    array(
      'taxonomy' => 'property_label',
      'field' => 'slug',
      'terms' => $_GET['type'],
      'include_children' => true,
      'operator' => 'IN'
    )
  );

  if ($_GET['type'] == 'lease') {
    $price_field_slug = 'fave_property_price';
    if ( !empty($_COOKIE['googtrans']) ) {
      $current_lang = $_COOKIE['googtrans'];
      
      if ($current_lang == '/en/vi') {
        $price_field_slug = 'fave_rent-vnd';
      }
    }

    if ($sortby == 'a_price') {
      $listing_args['meta_key'] = $price_field_slug;
      $listing_args['orderby'] = 'meta_value_num';
      $listing_args['order'] = 'ASC';
    } elseif ($sortby == 'd_price') {
      $listing_args['meta_key'] = $price_field_slug;
      $listing_args['orderby'] = 'meta_value_num';
      $listing_args['order'] = 'DESC';
    } elseif ($sortby == 'featured_first') {
      $listing_args['orderby'] = 'meta_value date';
      $listing_args['meta_key'] = 'fave_featured';
    }
  } elseif ($_GET['type'] == 'resell') {
    $price_field_slug = 'fave_resale-usd';
    if ( !empty($_COOKIE['googtrans']) ) {
      $current_lang = $_COOKIE['googtrans'];
      
      if ($current_lang == '/en/vi') {
        $price_field_slug = 'fave_resale-vnd';
      }
    }

    if ($sortby == 'a_price') {
      $listing_args['meta_key'] = $price_field_slug;
      $listing_args['orderby'] = 'meta_value_num';
      $listing_args['order'] = 'ASC';
    } elseif ($sortby == 'd_price') {
      $listing_args['meta_key'] = $price_field_slug;
      $listing_args['orderby'] = 'meta_value_num';
      $listing_args['order'] = 'DESC';
    } elseif ($sortby == 'featured_first') {
      $listing_args['orderby'] = 'meta_value date';
      $listing_args['meta_key'] = 'fave_featured';
    }
  }

  if (isset($_GET['project_keyword']) && $_GET['project_keyword'] != '') {
    array_push($listing_args['meta_query'], array(
      'relation'    => 'OR',
      array(
        'key'   => 'fave_project-name',
        'value'     => $_GET['project_keyword'],
        'compare'   => 'LIKE'
      ),
      array(
        'key'   => 'fave_property_map_address',
        'value'     => mycasa_to_odoo_stripvn($_GET['project_keyword']),
        'compare'   => 'LIKE'
      ),
      array(
        'key'   => 'fave_code',
        'value'     => $_GET['project_keyword'],
        'compare'   => 'LIKE'
      ),
    ));
  }

  if (isset($_GET['project_id']) && $_GET['project_id'] != '') {
    array_push($listing_args['meta_query'], array(
      'key'   => 'project_id',
      'value'     => $_GET['project_id'],
      'compare'   => 'LIKE'
    ));
  }

  if (isset($_GET['sale_price']) && $_GET['sale_price'] != '') {
    $sale_price_arr = explode('-', $_GET['sale_price']);

    if ( !empty($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/vi' ) {
      array_push($listing_args['meta_query'], array(
        'key'   => 'fave_resale-vnd',
        'value'     => $sale_price_arr,
        'type' => 'NUMERIC',
        'compare'   => 'BETWEEN'
      ));
    } else {
      array_push($listing_args['meta_query'], array(
        'key'   => 'fave_resale-usd',
        'value'     => $sale_price_arr,
        'type' => 'NUMERIC',
        'compare'   => 'BETWEEN'
      ));
    }
  }

  if (isset($_GET['rent_price']) && $_GET['rent_price'] != '') {
    $rent_price_arr = explode('-', $_GET['rent_price']);

    if ( !empty($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/vi' ) {
      array_push($listing_args['meta_query'], array(
        'key'   => 'fave_rent-vnd',
        'value'     => $rent_price_arr,
        'type' => 'NUMERIC',
        'compare'   => 'BETWEEN'
      ));
    } else {
      array_push($listing_args['meta_query'], array(
        'key'   => 'fave_property_price',
        'value'     => $rent_price_arr,
        'type' => 'NUMERIC',
        'compare'   => 'BETWEEN'
      ));
    }
  }

  if (isset($_GET['area_size']) && $_GET['area_size'] != '') {
    $area_arr = explode('-', $_GET['area_size']);

    array_push($listing_args['meta_query'], array(
      'key'   => 'fave_property_size',
      'value'     => $area_arr,
      'type' => 'NUMERIC',
      'compare'   => 'BETWEEN'
    ));
  }

  if (isset($_GET['bedroom_number']) && $_GET['bedroom_number'] != '') {
    $compare = ((int)$_GET['bedroom_number'] < 5) ? '=' : '>=';

    array_push($listing_args['meta_query'], array(
      'key'   => 'fave_property_bedrooms',
      'value'     => $_GET['bedroom_number'],
      'type' => 'NUMERIC',
      'compare'   => $compare
    ));
  }
} elseif ($_GET['type'] == 'project') {
  $listing_args['post_type'] = 'project';

  $price_field_slug = 'avg_unit_price_sqm_usd';
  if ( !empty($_COOKIE['googtrans']) ) {
    $current_lang = $_COOKIE['googtrans'];
    
    if ($current_lang == '/en/vi') {
      $price_field_slug = 'avg_unit_price_sqm_vnd';
    }
  }

  if ($sortby == 'a_price') {
    $listing_args['meta_key'] = $price_field_slug;
    $listing_args['orderby'] = 'meta_value_num';
    $listing_args['order'] = 'ASC';
  } elseif ($sortby == 'd_price') {
    $listing_args['meta_key'] = $price_field_slug;
    $listing_args['orderby'] = 'meta_value_num';
    $listing_args['order'] = 'DESC';
  }

  if (isset($_GET['project_keyword']) && $_GET['project_keyword'] != '') {
    array_push($listing_args['meta_query'], array(
      'relation'    => 'OR',
      array(
        'key'   => 'display_name',
        'value'     => $_GET['project_keyword'],
        'compare'   => 'LIKE'
      ),
      array(
        'key'   => 'full_address',
        'value'     => mycasa_to_odoo_stripvn($_GET['project_keyword']),
        'compare'   => 'LIKE'
      ),
    ));
    
    /*function houzez_child_title_filter( $where, $wp_query ) {
      global $wpdb;
      // 2. pull the custom query in here:
      if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
          $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $_GET['project_keyword'] ) ) . '%\'';
      }
      return $where;
    }

    $listing_args['search_prod_title'] = $_GET['project_keyword'];
    add_filter( 'posts_where', 'houzez_child_title_filter', 10, 2 );*/
  }
}

$listing_args = apply_filters( 'houzez20_property_filter', $listing_args );

$listings_query = new WP_Query( $listing_args );
//remove_filter( 'posts_where', 'houzez_child_title_filter', 10 );
$total_listing_found = $listings_query->found_posts;

?> 

<section class="listing-wrap listing-v1">
    <div class="container">
        
        <div class="page-title-wrap">

            <?php get_template_part('template-parts/listing/banner-search-page-title'); ?>  

        </div><!-- page-title-wrap -->

        <div class="row">
            <div class="col-lg-12 col-md-12"> 

                <?php
                if ( have_posts() ) {
                    while ( have_posts() ) {
                    the_post();
                    ?>
                    <article <?php post_class(); ?>>
                        <?php the_content(); ?>
                    </article>
                    <?php
                  }
                } ?>                      
                
                <div class="listing-tools-wrap">
                  <div class="d-flex align-items-center mb-2">
                    <div class="listing-tabs flex-grow-1"><?php echo $total_listing_found .' '. __('Properties', 'houzez_child'); ?></div>

                    <div class="sort-by">
                      <div class="d-flex align-items-center">
                        <div class="sort-by-title">
                          <?php esc_html_e( 'Sort by:', 'houzez' ); ?>
                        </div><!-- sort-by-title -->  
                        <select id="sort_project" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e( 'Default Order', 'houzez' ); ?>" data-live-search="false" data-dropdown-align-right="auto">
                          <option value="featured_first"><?php esc_html_e( 'Default Order', 'houzez' ); ?></option>
                          <option <?php selected($sortby, 'a_price'); ?> value="a_price"><?php esc_html_e('Price - Low to High', 'houzez'); ?></option>
                          <option <?php selected($sortby, 'd_price'); ?> value="d_price"><?php esc_html_e('Price - High to Low', 'houzez'); ?></option>
                        </select><!-- selectpicker -->
                      </div><!-- d-flex -->
                    </div><!-- sort-by -->

                  </div><!-- d-flex -->
                </div><!-- listing-tools-wrap -->   

                <div class="listing-view grid-view card-deck grid-view-3-cols">
                  <?php
                  if ( $listings_query->have_posts() ) :
                    while ( $listings_query->have_posts() ) : $listings_query->the_post();
                      if ($_GET['type'] == 'project') {
                        get_template_part('template-parts/listing/item-project-listing');
                      } else {
                        get_template_part('template-parts/listing/item', 'v1');
                      }

                    endwhile;
                  else:
                    get_template_part('template-parts/listing/item', 'none');
                  endif;
                  wp_reset_postdata();
                  ?>   
                </div><!-- listing-view -->

                <?php houzez_pagination( $listings_query->max_num_pages ); ?>
                
            </div><!-- col-lg-12 col-md-12 -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- listing-wrap -->

<?php get_footer(); ?>
