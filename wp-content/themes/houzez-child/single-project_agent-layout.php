<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 29/09/16
 * Time: 5:10 PM
 * Since v1.4.0
 */
global $post, $houzez_local, $properties_ids;

get_template_part('header-project');

$content_classes = 'col-lg-8 col-md-12 bt-content-wrap';
if( houzez_option( 'agency_sidebar', 0 ) == 0 ) { 
    $content_classes = 'col-lg-12 col-md-12';
}
?>

<section class="content-wrap">
    <div class="container">
      <div class="page-title-wrap">
          <?php get_template_part('template-parts/page/breadcrumb'); ?> 
      </div><!-- page-title-wrap -->

      <div class="agent-profile-wrap">
          <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-12">
                  <div class="agent-image">
                    <?php if (get_field('gallery_upload')): ?>
                      <img width=350 height=350 src="<?php echo esc_url(get_field('gallery_upload')[0]); ?>" alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>">
                    <?php elseif (get_field('gallery_url')): ?>
                      <img width=350 height=350 src="<?php echo esc_url(get_field('gallery_url')[0]['picture_attachement_ids']); ?>" alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>">
                    <?php else: ?>
                      <img src="http://placehold.it/350x350&amp;text=My+Casa" alt="THE 9 STELLARS" width=350 height=350 alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>">
                    <?php endif; ?>
                  </div>
              </div>

              <div class="col-lg-9 col-md-9 col-sm-12">
                  <div class="agent-profile-top-wrap">
                      <div class="agent-profile-header">
                          <h1><?php the_title(); ?></h1>
                      </div>
                      <?php if (get_field('full_address')): ?>
                      <address>
                        <i class="houzez-icon icon-pin"></i>
                        <?php echo get_field('full_address')['address']; ?>
                      </address>
                      <?php endif; ?>
                  </div>

                  <div class="agent-profile-content">
                    <ul class="list-unstyled">
                      <?php if (get_field('is_foreigner_quota')): ?>
                        <?php $is_foreigner_quota = 'checked'; ?>
                      <?php else: ?>
                        <?php $is_foreigner_quota = null; ?>
                      <?php endif; ?>
                      <li>
                        <strong><?php echo __('Is Foreigner Quota: ', 'houzez_child') ?></strong>
                        <input type="checkbox" name="is_foreigner_quota" checked="checked">
                      </li>

                      <?php if (get_field('developer_name')): ?>
                        <li>
                          <strong><?php echo __('Developer Name: ', 'houzez_child') ?></strong>
                          <?php echo get_field('developer_name'); ?>
                        </li>
                      <?php endif; ?>

                      <?php if (get_field('avg_unit_price_sqm_usd')): ?>
                        <li>
                          <strong><?php echo __('Average sqm price USD: ', 'houzez_child') ?></strong>
                          <?php echo '$' . number_format((int)get_field('avg_unit_price_sqm_usd'), 0, '.', ','); ?>
                        </li>
                      <?php elseif (get_field('avg_unit_price_sqm_vnd')): ?>
                        <li>
                          <strong><?php echo __('Average sqm price VND: ', 'houzez_child') ?></strong>
                          <?php echo number_format((int)get_field('avg_unit_price_sqm_vnd'), 0, '.', ',') . ' VNĐ'; ?>
                        </li>
                      <?php endif; ?>

                      <?php if (get_field('status')): ?>
                        <li>
                          <strong><?php echo __('Status: ', 'houzez_child') ?></strong>
                          <?php echo get_field('status'); ?>
                        </li>
                      <?php endif; ?>
                    </ul>

                    <?php if (get_field('short_description')): ?>
                      <?php echo get_field('short_description'); ?>
                    <?php endif ?>
                  </div><!-- agent-profile-content -->
              </div><!-- col-lg-8 col-md-8 col-sm-12 -->
          </div><!-- row -->
      </div><!-- agent-profile-wrap -->

      <div class="row">
          <div class="<?php echo esc_attr($content_classes); ?>">

            <?php if( houzez_option('agency_bio', 0) != 0 ) { ?>
            <div class="agent-bio-wrap">
                <h2><?php echo esc_html__('About', 'houzez'); ?> <?php the_title(); ?></h2>
                <?php the_content(); ?>
            </div><!-- agent-bio-wrap -->
            <?php } ?>

            <?php if (get_field('unit_ids')): ?>
            <div class="tab-pane fade show active" id="tab-properties">

              <section class="listing-wrap listing-v1">
                <h2><?php echo esc_html__('Listing Arpartment', 'houzez_child'); ?></h2>

                <div class="listing-view grid-view card-deck">
                    <?php
                    global $paged;

                    $args_property = array(
                      'post_type' => 'property',
                      'posts_per_page' => houzez_option('num_of_agency_listings', 9),
                      'paged' => $paged,
                      'post_status' => 'publish',
                      'post__in' => get_field('unit_ids')
                    );

                    $agency_qry = new WP_Query( $args_property );

                    if ( $agency_qry->have_posts() ) :
                        while ( $agency_qry->have_posts() ) : $agency_qry->the_post();

                            get_template_part('template-parts/listing/item', 'v1');

                        endwhile;
                        wp_reset_postdata();
                    else:
                        get_template_part('template-parts/listing/item', 'none');
                    endif;
                    ?> 
                </div><!-- listing-view -->

                <?php houzez_pagination( $agency_qry->max_num_pages ); ?>
              </section>
              
            </div><!-- tab-pane -->
            <?php endif; ?>
            
          </div><!-- bt-content-wrap -->

          <?php if( houzez_option( 'agency_sidebar', 0 ) != 0 ) { ?>
          <div class="col-lg-4 col-md-12 bt-sidebar-wrap houzez_sticky">
            <aside class="sidebar-wrap">
              <div class="agent-contacts-wrap">
                <h3 class="widget-title"><?php esc_html_e('Contact', 'houzez'); ?></h3>
                <div class="agent-map">
                  <?php if (get_field('gallery_upload')): ?>
                    <img width=350 height=350 src="<?php echo esc_url(get_field('gallery_upload')[0]); ?>" alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>">
                  <?php elseif (get_field('gallery_url')): ?>
                    <img width=350 height=350 src="<?php echo esc_url(get_field('gallery_url')[0]['picture_attachement_ids']); ?>" alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>">
                  <?php endif; ?>
                  <?php if (get_field('full_address')): ?>
                  <address>
                    <i class="houzez-icon icon-pin"></i>
                    <?php echo get_field('full_address')['address']; ?>
                  </address>
                  <?php endif; ?>
                </div>
                <ul class="list-unstyled">
                  <?php if (get_field('is_foreigner_quota')): ?>
                    <?php $is_foreigner_quota = 'checked'; ?>
                  <?php else: ?>
                    <?php $is_foreigner_quota = null; ?>
                  <?php endif; ?>
                  <li>
                    <strong><?php echo __('Is Foreigner Quota: ', 'houzez_child') ?></strong>
                    <input type="checkbox" name="is_foreigner_quota" checked="checked">
                  </li>

                  <?php if (get_field('developer_name')): ?>
                    <li>
                      <strong><?php echo __('Developer Name: ', 'houzez_child') ?></strong>
                      <?php echo get_field('developer_name'); ?>
                    </li>
                  <?php endif; ?>

                  <?php if (get_field('avg_unit_price_sqm_usd')): ?>
                    <li>
                      <strong><?php echo __('Average sqm price: ', 'houzez_child') ?></strong>
                      <?php echo '$' . get_field('avg_unit_price_sqm_usd'); ?>
                    </li>
                  <?php endif; ?>

                  <?php if (get_field('status')): ?>
                    <li>
                      <strong><?php echo __('Status: ', 'houzez_child') ?></strong>
                      <?php echo get_field('status'); ?>
                    </li>
                  <?php endif; ?>
                </ul>

              </div><!-- agent-bio-wrap -->

              <?php if (get_field('gallery_upload')): ?>
              <div class="widget widget-wrap project-feature">
                <div class="widget-header">
                  <h3 class="widget-title"><?php esc_html_e('Featured', 'houzez'); ?></h3>
                </div>
                <div class="widget-body widget-featured-property-slider-wrap">
                  <div class="widget-featured-property-slider">
                    <?php foreach (get_field('gallery_upload') as $feature): ?>
                      <div class="featured-property-item-widget">
                        <img src="<?php echo esc_url($feature); ?>">
                      </div>
                    <?php endforeach ?>
                  </div>
                </div>
              </div>
              <?php elseif (get_field('gallery_url')): ?>
              <div class="widget widget-wrap project-feature">
                <div class="widget-header">
                  <h3 class="widget-title"><?php esc_html_e('Featured', 'houzez'); ?></h3>
                </div>
                <div class="widget-body widget-featured-property-slider-wrap">
                  <div class="widget-featured-property-slider">
                    <?php foreach (get_field('gallery_url') as $feature): ?>
                      <div class="featured-property-item-widget">
                        <img src="<?php echo esc_url($feature['picture_attachement_ids']); ?>">
                      </div>
                    <?php endforeach ?>
                  </div>
                </div>
              </div>
              <?php endif; ?>
            </aside>
          </div><!-- bt-sidebar-wrap -->
            <?php } ?>

        </div><!-- row -->
    </div><!-- container -->
</section><!-- listing-wrap -->

<?php get_footer(); ?>
