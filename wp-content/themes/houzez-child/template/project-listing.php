<?php
/**
 * Template Name: Project Listing
 * Created by Mycasa.
 * User: Mycasa
 * Date: 09/02/2021
 * Time: 0:00 AM
 */
get_header();

global $post, $total_listing_found;

// Argument
$listing_args = array(
  'post_type' => 'project',
  'post_status' => 'publish',
  'meta_query' => array(
    'relation'    => 'AND',
  ),
  'tax_query' => array(
    'relation'    => 'AND',
  ),
);

// Get Status data
$status_arr = array();
$status_sql = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE CONVERT(`meta_key` USING utf8) = 'status' AND CONVERT(`meta_value` USING utf8) <> ''");

foreach ($status_sql as $status) {
  unset($status->meta_id);
  unset($status->post_id);
  unset($status->meta_key);
  if (!in_array($status->meta_value, $status_arr)) {
    array_push($status_arr, $status->meta_value);
  }
}
sort($status_arr);

// Filter by
$filterby = '';
if( isset( $_GET['status'] ) ) {
  $filterby = $_GET['status'];
}

if ($filterby) {
  array_push($listing_args['meta_query'], array(
    'key'   => 'status',
    'value'     => $filterby,
    'compare'   => '='
  ));
}

// Sortting by
$sortby = '';
if( isset( $_GET['sortby'] ) ) {
  $sortby = $_GET['sortby'];
}

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
} elseif ($sortby == 'a_date') {
  $listing_args['meta_key'] = 'hand_over_date';
  $listing_args['orderby'] = 'meta_value';
  $listing_args['order'] = 'ASC';
} elseif ($sortby == 'd_date') {
  $listing_args['meta_key'] = 'hand_over_date';
  $listing_args['orderby'] = 'meta_value';
  $listing_args['order'] = 'DESC';
} else {
  $listing_args['meta_key'] = 'hand_over_date';
  $listing_args['orderby'] = 'meta_value';
  $listing_args['order'] = 'DESC';
}

// Get project_keyword
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

// Get Street
if (isset($_GET['project_street']) && $_GET['project_street'] != '') {
  array_push($listing_args['meta_query'], array(
    'relation' => 'OR',
    array(
      'key'   => 'street',
      'value'     => $_GET['project_street'],
      'compare'   => 'IN'
    ),
    array(
      'key'   => 'street2',
      'value'     => $_GET['project_street'],
      'compare'   => 'IN'
    ),
  ));
}

// Get District
if (isset($_GET['project_district']) && $_GET['project_district'] != '') {
  array_push($listing_args['meta_query'], array(
    'key'   => 'district_id',
    'value'     => $_GET['project_district'],
    'compare'   => 'IN'
  ));
}

// Get City
if (isset($_GET['project_city']) && $_GET['project_city'] != '') {
  array_push($listing_args['meta_query'], array(
    'key'   => 'city_id',
    'value'     => $_GET['project_city'],
    'compare'   => 'IN'
  ));
}

// Get Is Foreigner Quota
if (isset($_GET['project_is_foreigner_quota']) && $_GET['project_is_foreigner_quota'] != null) {
   array_push($listing_args['meta_query'], array(
    'key'   => 'is_foreigner_quota',
    'value'     => 1,
    'compare'   => '='
  ));
}

// Get Hand Over Date
if (isset($_GET['project_year']) && $_GET['project_year'] != null) {
  array_push($listing_args['meta_query'], array(
    'key'   => 'hand_over_year',
    'value'     => $_GET['project_year'],
    'compare'   => 'IN'
  ));
}

// Get Price ranger
if (isset($_GET['project_min_price']) && $_GET['project_min_price'] != null && $_GET['project_max_price'] && $_GET['project_max_price'] != null) {
  array_push($listing_args['meta_query'], array(
    'key'   => 'avg_unit_price_sqm_usd',
    'value'     => array((int)$_GET['project_min_price'], (int)$_GET['project_max_price']),
    'compare'   => 'BETWEEN',
    'type' => 'NUMERIC'
  ));
}

// Get Feature
if (isset($_GET['feature']) && $_GET['feature'] != null) {
  array_push($listing_args['tax_query'], array(
    'taxonomy' => 'property_feature',
    'field' => 'slug',
    'terms' => $_GET['feature'],
    'include_children' => true,
    'operator' => 'IN'
  ));
}

$listing_args = apply_filters( 'houzez20_property_filter', $listing_args );

//print_r($listing_args);

$listings_query = new WP_Query( $listing_args );
//remove_filter( 'posts_where', 'houzez_child_title_filter', 10 );
$total_listing_found = $listings_query->found_posts;
?>

<?php get_template_part('template-parts/search/project-search'); ?> 

<section class="listing-wrap listing-v1">
    <div class="container">
        
        <div class="page-title-wrap">

            <?php get_template_part('template-parts/listing/listing-page-title'); ?>  

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
                    <div class="listing-tabs flex-grow-1"><?php echo $total_listing_found .' '. __('Projects', 'houzez_child'); ?></div> 

                    <div class="filter-by">
                      <div class="d-flex align-items-center">
                        <div class="sort-by-title">
                          <?php esc_html_e( 'Filter by:', 'houzez-child' ); ?>
                        </div><!-- sort-by-title -->  
                        <select id="filter_project" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e( 'All', 'houzez-child' ); ?>" data-live-search="false" data-dropdown-align-right="auto">
                          <option value=""><?php esc_html_e( 'All', 'houzez-child' ); ?></option>
                          <?php foreach ($status_arr as $status): ?>
                            <option <?php selected($filterby, $status); ?> value="<?php echo $status; ?>"><?php echo ucfirst($status); ?></option>
                          <?php endforeach; ?>
                        </select><!-- selectpicker -->
                      </div><!-- d-flex -->
                    </div> <!-- filter-by -->

                    <div class="sort-by">
                      <div class="d-flex align-items-center">
                        <div class="sort-by-title">
                          <?php esc_html_e( 'Sort by:', 'houzez' ); ?>
                        </div><!-- sort-by-title -->  
                        <select id="sort_project" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e( 'Default Order', 'houzez' ); ?>" data-live-search="false" data-dropdown-align-right="auto">
                          <option value=""><?php esc_html_e( 'Default Order', 'houzez' ); ?></option>
                          <option <?php selected($sortby, 'a_price'); ?> value="a_price"><?php esc_html_e('Price - Low to High', 'houzez'); ?></option>
                          <option <?php selected($sortby, 'd_price'); ?> value="d_price"><?php esc_html_e('Price - High to Low', 'houzez'); ?></option>                              
                          <!-- <option <?php //selected($sortby, 'a_date'); ?> value="a_date"><?php //esc_html_e('Date - Old to New', 'houzez' ); ?></option>
                          <option <?php //selected($sortby, 'd_date'); ?> value="d_date"><?php //esc_html_e('Date - New to Old', 'houzez' ); ?></option> -->
                        </select><!-- selectpicker -->
                      </div><!-- d-flex -->
                    </div><!-- sort-by -->

                  </div><!-- d-flex -->
                </div><!-- listing-tools-wrap -->   

                <div class="listing-view grid-view card-deck grid-view-3-cols">
                    <?php
                    if ( $listings_query->have_posts() ) :
                        while ( $listings_query->have_posts() ) : $listings_query->the_post();

                            get_template_part('template-parts/listing/item-project-listing');

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
