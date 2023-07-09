<?php
global $post, $current_user;
?>
<div class="property-form-wrap">
	<?php 
		if ( get_field('agent_group', 'option') ) {
			$agent_data = get_field('agent_group', 'option');
		?>
			<div class="agent-details">
				<div class="d-flex align-items-center">
					<div class="agent-image">
						<img class="rounded" src="<?php echo wp_get_attachment_image_url($agent_data['agent_avatar'], 'thumbnail'); ?>" alt="<?php echo $agent_data['agent_name']; ?>" width="70" height="70">
					</div>
					<ul class="agent-information list-unstyled">
						<li class="agent-name"><?php echo $agent_data['agent_name']; ?></li>
					</ul>
				</div>
			</div>
		<?php
		} else {
			echo $return_array['agent_data'];
		}
	?>

	<div class="property-form clearfix">
		<?php echo do_shortcode('[contact-form-7 id="82523" title="Agent Form"]'); ?>
		<input type="hidden" name="post_name" class="post-name-hidden" value="<?php echo get_the_title(); ?>">
		<input type="hidden" name="post_link" class="post-link-hidden" value="<?php echo get_permalink(); ?>">
	</div><!-- property-form -->
</div><!-- property-form-wrap -->
