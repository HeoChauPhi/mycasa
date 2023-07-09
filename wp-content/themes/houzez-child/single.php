<?php
/**
 * The Template for displaying all single posts
 * @since Houzez 1.0
 */

get_header();
$is_sticky = '';
$sticky_sidebar = houzez_option('sticky_sidebar');
if( $sticky_sidebar['default_sidebar'] != 0 ) { 
    $is_sticky = 'houzez_sticky'; 
}
$blog_author_box = houzez_option('blog_author_box');

$member_type_tax = wp_get_post_terms( $post->ID, 'member_type', array(
  'fields' => 'slugs',
  'hide_empty' => false,
));

$content_class = 'col-lg-12 col-md-12';
if (empty($member_type_tax)) {
 $content_class = 'col-lg-8 col-md-12 bt-content-wrap';
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>
<section class="blog-wrap">
    <div class="container">
        <div class="page-title-wrap">
          <div class="breadcrumb-wrap">
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo get_home_url(); ?>"><span><?php echo __('Home', 'houzez_child'); ?></span></a></li>
                <li class="breadcrumb-item active"><?php echo get_the_title(); ?></li>
              </ol>
            </nav>
          </div><!-- breadcrumb-wrap -->
        </div><!-- page-title-wrap -->
        <div class="row">
            <div class="<?php echo $content_class; ?>">                      

                <div class="article-wrap single-article-wrap">

                    <?php
                    // Start the Loop.
                    while ( have_posts() ) : the_post(); ?>

                        <article class="post-wrap">
                            
                            <div class="post-header-wrap">
                                <div class="post-title-wrap">
                                    <h1 class="<?php if (!empty($member_type_tax)){echo 'no-margin';} ?>"><?php the_title(); ?></h1>
                                </div><!-- post-title-wrap -->
                                <?php if (empty($member_type_tax)): ?>
                                <?php get_template_part('template-parts/blog/meta'); ?>
                                <?php endif; ?>

                            </div><!-- post-header-wrap -->
                            <?php if (empty($member_type_tax)): ?>
                            <div class="post-thumbnail-wrap">
                                <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                            </div><!-- post-thumbnail-wrap -->
                            <?php endif ?>

                            <div class="post-content-wrap">
                                <?php the_content(); ?>

                                <?php
                                $args = array(
                                    'before'           => '<div class="pagination-main"><ul class="pagination">' . esc_html__('Pages:','houzez'),
                                    'after'            => '</ul></div>',
                                    'link_before'      => '<span>',
                                    'link_after'       => '</span>',
                                    'next_or_number'   => 'next',
                                    'nextpagelink'     => '<span aria-hidden="true"><i class="fa fa-angle-right"></i></span>',
                                    'previouspagelink' => '<span aria-hidden="true"><i class="fa fa-angle-left"></i></span>',
                                    'pagelink'         => '%',
                                    'echo'             => 1
                                );
                                wp_link_pages( $args );
                                ?>
                                
                            </div><!-- post-content-wrap -->
                            

                            <?php 
                            if(houzez_option('blog_tags')) {
                                get_template_part( 'template-parts/blog/tags' ); 
                            }
                            ?>

                            <?php 
                            if (!empty($member_type_tax)): ?>
                              <?php
                                $property_args = array(
                                  'post_type' => 'property',
                                  'post_status' => 'publish',
                                  'orderby' => 'meta_value date',
                                  'meta_key' => 'fave_featured',
                                  'meta_query' => array(
                                    'relation'    => 'OR',
                                    array(
                                      'key'   => 'fave_create-uid',
                                      'value'     => get_field('properties_for_agent'),
                                      'compare'   => '='
                                    )
                                  )
                                );

                                $property_args = apply_filters( 'houzez20_property_filter', $property_args );
                                $properties = new WP_Query($property_args);
                                $total_posts = $properties->found_posts;
                              ?>

                            <div class="property-listings-wrap similar-listing property-section-wrap">
                              <div class="block-wrap">
                                <div class="block-title-wrap d-flex justify-content-between align-items-center">
                                  <h2><?php echo __('my listing', 'houzez_child'); ?></h2>
                                  <span><?php echo esc_attr($total_posts); ?> <?php esc_html_e('Properties', 'houzez');?></span>
                                </div>
                                <div class="block-content-wrap">
                                <?php
                                if ( $properties->have_posts() ) : ?>
                                  <div class="listing-view grid-view card-deck grid-view-3-cols">
                                  <?php 
                                  while ( $properties->have_posts() ) : $properties->the_post();
                                    get_template_part('template-parts/listing/item', 'v1');
                                  endwhile; ?>
                                  </div>
                                <?php
                                endif;
                                wp_reset_postdata();
                                ?>

                                <?php houzez_pagination( $properties->max_num_pages ); ?>
                                </div>
                              </div>
                            </div>
                            <?php endif ?>
                            

                        </article><!-- post-wrap -->

                        <?php 
                        if (empty($member_type_tax)) {
                          if(houzez_option('blog_next_prev')) { 
                              get_template_part( 'template-parts/blog/next-prev-post' ); 
                          }

                          get_template_part( 'template-parts/blog/post-author' );

                          if(houzez_option('blog_related_posts')) {
                              get_template_part( 'template-parts/blog/related-posts' ); 
                          }
                        }
                        ?> 
                        
                        
                        <?php 
                        if (empty($member_type_tax)) {
                          // If comments are open or we have at least one comment, load up the comment template.
                          if ( comments_open() || get_comments_number() ) {
                              comments_template();
                          }
                        }
                    endwhile; ?>
                </div><!-- article-wrap -->
            </div><!-- bt-content-wrap -->
            <?php if (empty($member_type_tax)): ?>
            <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php echo esc_attr($is_sticky); ?>">
                <?php get_sidebar(); ?>
            </div><!-- bt-sidebar-wrap -->
            <?php endif; ?>
        </div><!-- row -->
    </div><!-- container -->
</section><!-- blog-wrap -->

<?php
}
get_footer();
