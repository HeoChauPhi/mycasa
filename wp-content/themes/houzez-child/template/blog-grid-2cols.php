<?php
/**
 * Template Name: Blog Grid 2 Columns Template
 * Created by PhpStorm.
 * User: MyCasa
 * Date: 25/01/16
 * Time: 9:12 PM
 */
get_header();
global $houzez_local, $wp, $wp_query, $wpdb, $paged;
if ( is_front_page()  ) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}

$number_of_posts = houzez_option('masorny_num_posts');
if (!$number_of_posts) {
    $number_of_posts = '12';
}

$member_type_tax = get_terms( array(
  'taxonomy' => 'member_type',
  'fields' => 'slugs',
  'hide_empty' => false,
));

$wp_query_args = array(
  'post_type' => 'post',
  'posts_per_page' => $number_of_posts,
  'paged' => $paged,
  'post_status' => 'publish',
  'tax_query' => array(
    'relation'    => 'AND',
    array(
      'taxonomy' => 'member_type',
      'field' => 'slug',
      'terms' => $member_type_tax,
      'include_children' => true,
      'operator' => 'NOT IN'
    ),
  ),
);

// Get search_keyword
if (isset($_GET['search_keyword']) && $_GET['search_keyword'] != '') {
  function houzez_child_blog_post_title_filter( $where, $wp_query ) {
    global $wpdb;
    // 2. pull the custom query in here:
    if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
      $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $_GET['search_keyword'] ) ) . '%\'';
    }
    return $where;
  }

  $wp_query_args['search_prod_title'] = $_GET['search_keyword'];
  add_filter( 'posts_where', 'houzez_child_blog_post_title_filter', 10, 2 );
}

// Get Category
if (isset($_GET['category']) && $_GET['category'] != null) {
  array_push($wp_query_args['tax_query'], array(
    'taxonomy' => 'category',
    'field' => 'slug',
    'terms' => array($_GET['category']),
    'include_children' => true,
    'operator' => 'IN'
  ));
}

$the_query = New WP_Query($wp_query_args);
remove_filter( 'posts_where', 'houzez_child_blog_post_title_filter', 10 );
?>

<section class="blog-wrap">
  <div class="container">
    <div class="page-title-wrap">
      <?php get_template_part('template-parts/page/breadcrumb'); ?> 
      <div class="d-flex align-items-center">
          <?php get_template_part('template-parts/page/page-title'); ?> 
      </div><!-- d-flex -->  
    </div><!-- page-title-wrap -->
    <div class="row">

      <?php 
      if( $the_query->have_posts() ): 
        while( $the_query->have_posts() ): $the_query->the_post(); ?>

        <div class="blog-post-item-wrap col-lg-6 col-md-6">
          <?php get_template_part('template-parts/blog/masonry-post'); ?>
        </div>

        <?php if ($the_query->current_post == 0): ?>
          <?php get_template_part('template-parts/search/block-blog-search'); ?>
        <?php endif; ?>

        <?php endwhile; 
      else:
        get_template_part('template-parts/search/block-blog-search');
      endif; ?>
      <?php wp_reset_postdata(); ?>

    </div><!-- row -->

    <?php houzez_pagination( $the_query->max_num_pages ); ?>
  </div><!-- container -->
</section><!-- listing-wrap -->
<?php get_footer(); ?>