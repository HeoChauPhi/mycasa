<?php
global $post;
?>

<!-- Gallery -->
<div class="tab-pane show active" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
  <?php
  $size = 'houzez-gallery';
  $project_images = get_field( 'gallery_url', $post->ID );
  $project_images_upload = get_field('gallery_upload', $post->ID);
  ?>

  <?php if ($project_images_upload): ?>
  <div class="top-gallery-section">
    <div id="project-gallery-js" class="project-gallery listing-slider cS-hidden">
      <?php $i = 0; ?>
      <?php foreach ($project_images_upload as $image): $i++; ?>
        <div data-thumb="https://adztvetajq.cloudimg.io/<?php echo esc_url($image); ?>" class="project-gallery-item">
          <a rel="gallery-1" data-slider-no="<?php echo esc_attr($i); ?>" href="#" class="houzez-trigger-popup-slider-js swipebox" data-toggle="modal" data-target="#property-lightbox" style="background-image: url(<?php echo esc_url($image); ?>);">
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div><!-- top-gallery-section -->
  <?php elseif (!empty($project_images) && count($project_images)): ?>
  <div class="top-gallery-section">
    <div id="project-gallery-js" class="project-gallery listing-slider cS-hidden">
      <?php $i = 0; ?>
      <?php foreach ($project_images as $image): $i++; ?>
        <div data-thumb="<?php echo esc_url($image['picture_attachement_ids']); ?>" class="project-gallery-item">
          <a rel="gallery-1" data-slider-no="<?php echo esc_attr($i); ?>" href="#" class="houzez-trigger-popup-slider-js swipebox" data-toggle="modal" data-target="#property-lightbox" style="background-image: url(https://adztvetajq.cloudimg.io/<?php echo esc_url($image['picture_attachement_ids']); ?>);">
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div><!-- top-gallery-section -->
  <?php else: ?>
  <div class="top-gallery-section">
    <?php houzez_image_placeholder( $size ); ?>
  </div>
  <?php endif; ?>
</div>

<!-- Google Map -->
<?php
$project_address = get_field('full_address', $post->ID);
?>
<div class="tab-pane" id="pills-map" role="tabpanel" aria-labelledby="pills-map-tab">
  <div class="map-wrap">
    <div id="houzez-single-listing-map">
      <div class="google-build-map" style="width: 100%; height: 100%;">
        <div class="marker" data-lat="<?php echo $project_address['lat'];?>" data-lng="<?php echo $project_address['lng']; ?>" data-icon="<?php echo home_url('wp-content/uploads/2016/02/x1-single-family-home.png'); ?>">
          <div class="address">
            <div class="map-info-window">
              <div class="item-wrap">
                <div class="item-header">
                  <a class="hover-effect"><img class="img-fluid listing-thumbnail" src="<?php echo $project_images[0]['picture_attachement_ids'] ?>" alt="<?php echo get_the_title($post->ID); ?>"></a>
                </div>
                <div class="item-body flex-grow-1">
                  <h2 class="item-title"><a href="<?php echo get_the_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h2>
                  <ul class="list-unstyled item-info">
                    <?php if (get_field('avg_unit_price_sqm_usd', $post->ID)): ?>
                    <li class="item-price"><?php echo '$' . number_format((int)get_field('avg_unit_price_sqm_usd', $post->ID), 0, '.', ','); ?></li>
                    <?php elseif (get_field('avg_unit_price_sqm_vnd', $post->ID)): ?>
                    <li class="item-price"><?php echo number_format((int)get_field('avg_unit_price_sqm_vnd', $post->ID), 0, '.', ',') . ' VNĐ'; ?></li>
                    <?php endif; ?>

                    <!-- Get Project type term -->
                    <?php if (get_the_terms($post->ID, 'project_type')):
                      $project_type = get_the_terms($post->ID, 'project_type');
                      $count_project_type = count($project_type);
                      $loop_term = 0;
                    ?>
                    <li class="item-type">
                    <?php foreach ($project_type as $term) {
                      $term_id = $term->term_id;
                      $term_name = $term->name;

                      if(++$loop_term === $count_project_type) {
                        echo esc_attr($term_name);
                      } else {
                        echo esc_attr($term_name) . ', ';
                      }
                    } ?>
                    </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<div class="tab-pane google-street-view" id="pills-street-view" role="tabpanel" aria-labelledby="pills-street-view-tab" data-lat="<?php echo $project_address['lat'];?>" data-lng="<?php echo $project_address['lng']; ?>">
</div>
