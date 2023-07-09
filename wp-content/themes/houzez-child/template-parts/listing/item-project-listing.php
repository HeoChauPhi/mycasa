<?php global $ele_thumbnail_size; ?>
<div class="item-listing-wrap hz-item-gallery-js card" <?php houzez_property_gallery('houzez-item-image-1'); ?>>
  <div class="item-wrap item-wrap-v1 item-wrap-no-frame h-100">
    <div class="d-flex align-items-center h-100">
      <div class="item-header child-custom--item-header">
        <?php get_template_part('template-parts/listing/partials/item-labels-project'); ?>
        <?php get_template_part('template-parts/listing/partials/item-price'); ?>
        <?php get_template_part('template-parts/listing/partials/item-tools-project'); ?>
        <?php get_template_part('template-parts/listing/partials/item-image'); ?>
        <div class="preview_loader"></div>
      </div><!-- item-header -->  
      <div class="item-body flex-grow-1">
        <?php get_template_part('template-parts/listing/partials/item-labels-project'); ?>
        <?php get_template_part('template-parts/listing/partials/item-title'); ?>
        <?php get_template_part('template-parts/listing/partials/item-price'); ?>
        
        <?php if (get_field('full_address', get_the_ID())): ?>
        <address class="item-address"><?php echo get_field('full_address', get_the_ID())['address']; ?></address>
        <?php endif; ?>
        <div class="item-wrap-button">
          <?php
          $term_feature = wp_get_post_terms( get_the_ID(), 'property_feature', array("fields" => "all"));

          if (!empty($term_feature)): ?>
            <div class="list-item-features">
            <?php
            $count_term_feature = count($term_feature);
            $loop_term_feature = 0;
            foreach( $term_feature as $feature ) {
              $feature_id = $feature->term_id;
              $feature_name = $feature->name;

              if(++$loop_term_feature === $count_term_feature) {
                echo '<a href="'.get_term_link($feature_id).'" class="item-feature">'.esc_attr($feature_name).'</a>';
              } else {
                echo '<a href="'.get_term_link($feature_id).'" class="item-feature">'.esc_attr($feature_name).'</a>, ';
              }
            }
            ?>
            </div>
          <?php endif; ?>
          <?php get_template_part('template-parts/listing/partials/item-btn-v1'); ?>
        </div>
      </div><!-- item-body -->
    </div><!-- d-flex -->
  </div><!-- item-wrap -->
</div><!-- item-listing-wrap -->