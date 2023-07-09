<?php
$blog_date = houzez_option('blog_date');
$blog_author = houzez_option('blog_author');
?>
<div class="blog-post-item blog-post-item-v1">

	<?php if( houzez_option('blog_featured_image', 1 ) ) { ?>
	<div class="blog-post-thumb">
		<a href="<?php echo esc_url(get_permalink()); ?>" class="hover-effect">
			<?php if( has_post_thumbnail( $post->ID ) && get_the_post_thumbnail($post->ID) != '' ) {
				the_post_thumbnail('539x359', array('class' => 'img-fluid'));
			} else {
			?>
				<img class="img-fluid rounded" src="<?php echo esc_url('https://via.placeholder.com/539x357&text=My+Casa') ?>" width="40" height="40" alt="image">
			<?php
			}
			?>
		</a>
	</div><!-- blog-post-thumb -->
	<?php } ?>
	
	<div class="blog-post-content-wrap">
		<div class="blog-post-meta">
			<ul class="list-inline">

				<?php if( $blog_date != 0 ) { ?>
				<li class="list-inline-item">
					<time datetime="<?php esc_attr( the_time( get_option( 'date_format' ) ));?>"><i class="houzez-icon icon-attachment mr-1"></i> <?php esc_attr( the_time( get_option( 'date_format' ) ));?></time>
				</li>
				<?php } ?>

				<li class="list-inline-item">
					<i class="houzez-icon icon-tags mr-1"></i></span> <?php the_category(', '); ?>
				</li>
			</ul>
		</div><!-- blog-post-meta -->
		<div class="blog-post-title">
			<h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
		</div><!-- blog-post-title -->
		<div class="blog-post-body">
			<?php echo houzez_clean_excerpt( 95, 'false' ); ?>
		</div><!-- blog-post-body -->
		<div class="blog-post-link">
			<a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html__('Continue Reading', 'houzez'); ?></a>
		</div><!-- blog-post-link -->
	</div><!-- blog-post-content-wrap -->

	<?php if( $blog_author != 0 ) { ?>
	<div class="blog-post-author">
		<i class="houzez-icon icon-single-neutral mr-1"></i> <?php echo esc_html__('by', 'houzez'); ?> <?php the_author(); ?>
	</div>
	<?php } ?>

</div><!-- blog-post-item -->