<?php
global $post;
$properties_images = get_field( 'gallery_url', $post->ID );
$properties_images_upload = get_field( 'gallery_upload', $post->ID );
$gallery_caption = houzez_option('gallery_caption', 0); 

if(!empty($properties_images_upload)) {
?>
<div class="top-gallery-section top-gallery-variable-width-section">
	<div class="listing-slider-variable-width houzez-all-slider-wrap">
		<?php
		$i = 0;
    foreach( $properties_images_upload as $prop_image_meta ) { $i++;
		
			echo '<div>
				<a rel="gallery-1" href="#" data-slider-no="'.esc_attr($i).'" class="houzez-trigger-popup-slider-js swipebox" data-toggle="modal" data-target="#property-lightbox">
					<img width=800 height=600 class="img-responsive" data-lazy="'.esc_attr( $prop_image_meta ).'" src="'.esc_attr( $prop_image_meta ).'" alt="'.esc_attr(get_the_title($post->ID)).'" title="'.esc_attr(get_the_title($post->ID)).'">
				</a>';

			echo '</div>';

			if($i == count($properties_images_upload)) {
				$i = 0;
			}
    }
    ?>
	
	</div>
</div><!-- top-gallery-section -->
<?php } elseif(!empty($properties_images) && count($properties_images)) {
?>
<div class="top-gallery-section top-gallery-variable-width-section">
	<div class="listing-slider-variable-width houzez-all-slider-wrap">
		<?php
		$i = 0;
    foreach( $properties_images as $prop_image_id => $prop_image_meta ) { $i++;
		
			echo '<div>
				<a rel="gallery-1" href="#" data-slider-no="'.esc_attr($i).'" class="houzez-trigger-popup-slider-js swipebox" data-toggle="modal" data-target="#property-lightbox">
					<img width=800 height=600 class="img-responsive" data-lazy="https://adztvetajq.cloudimg.io/'.esc_attr( $prop_image_meta['picture_attachement_ids'] ).'" src="https://adztvetajq.cloudimg.io/'.esc_attr( $prop_image_meta['picture_attachement_ids'] ).'" alt="'.esc_attr(get_the_title($post->ID)).'" title="'.esc_attr(get_the_title($post->ID)).'">
				</a>';

			echo '</div>';

			if($i == count($properties_images)) {
				$i = 0;
			}
    }
    ?>
	
	</div>
</div><!-- top-gallery-section -->
<?php } ?>