<?php global $post, $ele_thumbnail_size; 
$thumbnail_size = !empty($ele_thumbnail_size) ? $ele_thumbnail_size : 'houzez-item-image-1';
?>
<div class="listing-image-wrap">
	<div class="listing-thumb">
		<a href="<?php echo esc_url(get_permalink()); ?>" class="listing-featured-thumb hover-effect">
			<?php
		    
		    if( has_post_thumbnail( $post->ID ) && get_the_post_thumbnail($post->ID) != '' ) {
		        the_post_thumbnail( $thumbnail_size, array('class' => 'img-fluid') );
		    } elseif (!empty(get_field('gallery_upload', $post->ID))) { ?>
		    		<div class="background-image" style="background-image: url(https://adztvetajq.cloudimg.io/<?php echo esc_url(get_field('gallery_upload', $post->ID)[0]); ?>);" title="<?php echo get_the_title($post->ID); ?>"></div>
		    <?php }  elseif (!empty(get_field('gallery_url', $post->ID))) { ?>
		    		<div class="background-image" style="background-image: url(https://adztvetajq.cloudimg.io/<?php echo esc_url(get_field('gallery_url', $post->ID)[0]['picture_attachement_ids']); ?>);" title="<?php echo get_the_title($post->ID); ?>"></div>
		    <?php } elseif(!empty(get_field('project_id', $post->ID))) { 
		    	$project_id = get_field('project_id', $post->ID)[0];
		    	?>
		    	<div class="background-image" style="background-image: url(https://adztvetajq.cloudimg.io/<?php echo esc_url(get_field('gallery_url', $project_id)[0]['picture_attachement_ids']); ?>);" title="<?php echo get_the_title($post->ID); ?>"></div>
		    <?php } else {
		        houzez_image_placeholder( $thumbnail_size );
		    }
		    ?>
		</a><!-- hover-effect -->
	</div>
</div>
