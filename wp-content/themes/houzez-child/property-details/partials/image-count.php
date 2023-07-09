<?php 
global $post;
$images_count = get_field('gallery_url', $post->ID); 
$total_images = count($images_count);
 ?>
<div class="property-image-count visible-on-mobile"><i class="houzez-icon icon-picture-sun"></i> <?php echo esc_attr($total_images); ?></div>