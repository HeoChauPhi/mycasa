<?php
global $post;

$property_label = get_terms(array(
  'taxonomy' => 'property_label'
));
?>

<?php
if (!empty($property_label) && $property_label[0] != null && !empty(get_field('unit_ids', $post->ID))):
  foreach ($property_label as $term): 
    $term_id = $term->term_id;
    $term_slug = $term->slug;
    $term_name = $term->name;
    $search_url = 'search-results/?label[]=' . $term_slug . '&project-name=' . get_the_title($post->ID);
    ?>
    <div id="<?php echo $term_slug; ?>-listings-wrap" class="<?php echo $term_slug; ?>-listings-wrap similar-listing property-section-wrap">
      <div class="block-wrap">
        <div class="block-title-wrap d-flex justify-content-between align-items-center">
          <h2><?php echo $term_name . ' ' . __('listing', 'houzez_child'); ?></h2>

          <a class="view-more" href="<?php echo home_url($search_url); ?>" target="_blank"><?php echo __('View more properties', 'houzez_child'); ?></a>
        </div>
        <div class="block-content-wrap">
        <?php
        $property_args = array(
          'post_type' => 'property',
          'post_status' => 'publish',
          'post__in' => get_field('unit_ids', $post->ID),
          'posts_per_page' => 6,
          'tax_query' => array(
            'relation' => 'AND',
            array(
              'taxonomy' => 'property_label',
              'field' => 'slug',
              'terms' => array( $term_slug ),
              'include_children' => true,
              'operator' => 'IN'
            )
          ),
        );

        $properties = new WP_Query($property_args);
        if ( $properties->have_posts() ) : ?>
          <div class="listing-view grid-view card-deck grid-view-3-cols">
          <?php 
          while ( $properties->have_posts() ) : $properties->the_post();
            get_template_part('template-parts/listing/item', 'v1');
          endwhile; ?>
          </div>
        <?php
        endif;
        $properties = null;
        wp_reset_postdata();
        ?>
        </div>
      </div>
    </div> 
    <?php
  endforeach;
endif;
