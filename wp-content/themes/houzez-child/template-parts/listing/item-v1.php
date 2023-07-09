<?php global $ele_thumbnail_size; ?>
<div class="item-listing-wrap hz-item-gallery-js card" <?php houzez_property_gallery('houzez-item-image-1'); ?>>
	<div class="item-wrap item-wrap-v1 item-wrap-no-frame h-100">
		<div class="d-flex align-items-center h-100">
			<div class="item-header child-custom--item-header">
				<?php //get_template_part('template-parts/listing/partials/item-featured-label'); ?>
				<?php get_template_part('template-parts/listing/partials/item-labels'); ?>
				<?php get_template_part('template-parts/listing/partials/item-price'); ?>
				<?php get_template_part('template-parts/listing/partials/item-tools'); ?>
				<?php get_template_part('template-parts/listing/partials/item-image'); ?>
				<div class="preview_loader"></div>
			</div><!-- item-header -->	
			<div class="item-body flex-grow-1">
				<?php get_template_part('template-parts/listing/partials/item-labels'); ?>
				<?php get_template_part('template-parts/listing/partials/item-title'); ?>
				<?php get_template_part('template-parts/listing/partials/item-price'); ?>
				<?php get_template_part('template-parts/listing/partials/item-address'); ?>

				<!-- <h6><?php // echo get_post_meta(get_the_ID(), 'fave_project-name', true); ?></h6>
				<h6><?php // echo get_post_meta(get_the_ID(), 'fave_property_size', true); ?></h6>
				<h6><?php // echo get_post_meta(get_the_ID(), 'fave_property_bedrooms', true); ?></h6> -->

				<?php if (get_post_meta(get_the_ID(), 'fave_project-name', true) || get_post_meta(get_the_ID(), 'fave_code', true)): ?>
				<div class="item-description notranslate"><?php echo get_post_meta(get_the_ID(), 'fave_project-name', true); ?></div>
				<?php endif; ?>
				<?php get_template_part('template-parts/listing/partials/item-features-v1'); ?>
				<?php get_template_part('template-parts/listing/partials/item-btn-v1'); ?>
				<?php get_template_part('template-parts/listing/partials/item-author'); ?>
				<?php get_template_part('template-parts/listing/partials/item-date'); ?>
			</div><!-- item-body -->

			<?php if(houzez_option('disable_date', 1) || houzez_option('disable_agent', 1)) { ?>
			<div class="item-footer clearfix">
				<?php get_template_part('template-parts/listing/partials/item-author'); ?>
				<?php get_template_part('template-parts/listing/partials/item-date'); ?>
			</div>
			<?php } ?>
		</div><!-- d-flex -->
	</div><!-- item-wrap -->
</div><!-- item-listing-wrap -->