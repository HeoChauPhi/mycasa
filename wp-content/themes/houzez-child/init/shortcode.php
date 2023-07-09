<?php
add_shortcode( 'project_search_autocomplete', 'create_project_search_autocomplete' );
function create_project_search_autocomplete($attrs) {
  extract(shortcode_atts (array(
    'key' => ''
  ), $attrs));
  ob_start();
  global $wp, $wpdb;

  $title_sql_string = '';
  $title_key_arr = explode(' ', $key);
  foreach ($title_key_arr as $index => $key_item) {
    $title_sql_string .= "(CONVERT(`post_title` USING utf8) LIKE '%%".$key_item."%')";

    if ($index !== array_key_last($title_key_arr)) {
      $title_sql_string .= " OR ";
    }
  }

  $project_title_sql = $wpdb->get_results("SELECT * FROM `wp_posts` WHERE CONVERT(`post_type` USING utf8) = 'project' AND (" . $title_sql_string . ")");
  $property_title_sql = $wpdb->get_results("SELECT * FROM `wp_posts` WHERE CONVERT(`post_type` USING utf8) = 'property' AND (" . $title_sql_string . ")");
  // $project_address = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE CONVERT(`meta_key` USING utf8) = 'full_address' AND CONVERT(`meta_value` USING utf8) LIKE '%%".$key."%'");

  $property_query = null;
  if (!empty($property_title_sql)) {
    $property_ids = array();
    foreach ($property_title_sql as $property) {
      array_push($property_ids, $property->ID);
    }

    $property_args = array(
      'post_type' => 'property',
      'post_status' => 'publish',
      'post__in'  => $property_ids,
    );

    $property_query = new WP_Query( $property_args );
  }
  ?>

  <div class="auto-complete-keyword">
    <ul class="list-group">
      <?php /* if ($project_address): ?>
        <li class="list-group-label list-group-item"><?php echo __('List at', 'houzez_child') . ': ' . $key; ?></li>
        <?php foreach ($project_address as $project_add): ?>
        <li class="list-group-item">
          <div class="d-flex align-items-center">
            <div class="auto-complete-image-wrap">
              <a href="<?php echo get_permalink($project_add->post_id); ?>">
                <?php if (get_field('gallery_upload', $project_add->post_id)): ?>
                  <img src="<?php echo esc_url(get_field('gallery_upload', $project_add->post_id)[0]); ?>" width="40" height="40" alt="image">
                <?php elseif (get_field('gallery_url', $project_add->post_id)): ?>
                  <img src="<?php echo esc_url(get_field('gallery_url', $project_add->post_id)[1]['picture_attachement_ids']); ?>" width="40" height="40" alt="image">
                <?php else: ?>
                <img class="img-fluid rounded" src="<?php echo esc_url('https://via.placeholder.com/150x150&text=My+Casa') ?>" width="40" height="40" alt="image">
                <?php endif; ?>
              </a>    
            </div><!-- auto-complete-image-wrap -->
            <div class="auto-complete-content-wrap ml-3">
              <div class="auto-complete-title">
                <a href="<?php echo get_permalink($project_add->post_id); ?>"><?php echo get_the_title($project_add->post_id); ?></a>
              </div>
            </div><!-- auto-complete-content-wrap -->
          </div><!-- d-flex -->
        </li>
        <?php endforeach; ?>
      <?php endif; */ ?>

      <li class="list-group-label list-group-item"><button type="submit"><?php echo __('List at', 'houzez_child') . ': ' . $key; ?></button></li>

      <?php if ($project_title_sql): ?>
        <li class="list-group-label list-group-item"><?php echo __('Projects for', 'houzez_child') . ': ' . $key; ?></li>
        <?php foreach ($project_title_sql as $project): ?>
        <li class="list-group-item">
          <div class="d-flex align-items-center">
            <div class="auto-complete-image-wrap">
              <a href="<?php echo get_permalink($project->ID); ?>">
                <?php if (get_field('gallery_upload', $project->ID)): ?>
                  <img src="<?php echo esc_url(get_field('gallery_upload', $project->ID)[0]); ?>" width="40" height="40" alt="image">
                <?php elseif (get_field('gallery_url', $project->ID)): ?>
                  <img src="<?php echo esc_url(get_field('gallery_url', $project->ID)[0]['picture_attachement_ids']); ?>" width="40" height="40" alt="image">
                <?php else: ?>
                <img class="img-fluid rounded" src="<?php echo esc_url('https://via.placeholder.com/150x150&text=My+Casa') ?>" width="40" height="40" alt="image">
                <?php endif; ?>
              </a>    
            </div><!-- auto-complete-image-wrap -->
            <div class="auto-complete-content-wrap ml-3">
              <div class="auto-complete-title">
                <a href="<?php echo get_permalink($project->ID); ?>"><?php echo get_the_title($project->ID); ?></a>
              </div>
            </div><!-- auto-complete-content-wrap -->
          </div><!-- d-flex -->
        </li><!-- list-group-item -->
        <?php endforeach; ?>
      <?php endif; ?>

      <?php if ($property_query->posts): ?>
        <li class="list-group-label list-group-item"><?php echo __('Properties for', 'houzez_child') . ': ' . $key; ?></li>
        <?php foreach ($property_query->posts as $property): ?>
        <li class="list-group-item">
          <div class="d-flex align-items-center">
            <div class="auto-complete-image-wrap">
              <a href="<?php echo get_permalink($property->ID); ?>">
                <?php if (get_field('gallery_upload', $property->ID)): ?>
                  <img src="<?php echo esc_url(get_field('gallery_upload', $property->ID)[0]); ?>" width="40" height="40" alt="image">
                <?php elseif (get_field('gallery_url', $property->ID)): ?>
                  <img src="<?php echo esc_url(get_field('gallery_url', $property->ID)[0]['picture_attachement_ids']); ?>" width="40" height="40" alt="image">
                <?php else: ?>
                <img class="img-fluid rounded" src="<?php echo esc_url('https://via.placeholder.com/150x150&text=My+Casa') ?>" width="40" height="40" alt="image">
                <?php endif; ?>
              </a>    
            </div><!-- auto-complete-image-wrap -->
            <div class="auto-complete-content-wrap ml-3">
              <div class="auto-complete-title">
                <a href="<?php echo get_permalink($property->ID); ?>"><?php echo get_the_title($property->ID); ?></a>
              </div>
            </div><!-- auto-complete-content-wrap -->
          </div><!-- d-flex -->
        </li>
        <?php endforeach; ?>
      <?php endif; ?>

      <?php // if (empty($project_title_sql) && empty($property_query->posts) && empty($project_address)): ?>
      <?php if ( empty($project_title_sql) && empty($property_query->posts) ): ?>
        <li class="list-group-item"><?php echo __('We didn’t find any results', 'houzez_child'); ?></li>
      <?php endif ?>
    </ul>
    <?php // if (!empty($project_title_sql) || !empty($property_query->posts) || !empty($project_address)): ?>
    <?php if ( !empty($project_title_sql) || !empty($property_query->posts) ): ?>
    <div class="auto-complete-footer">
      <span class="auto-complete-count"><i class="houzez-icon icon-pin mr-1"></i> <?php echo (count($project_title_sql) + count($property_query->posts) + count($project_address)) . ' ' . __('Listings found', 'houzez_child') ?></span>
      <a target="_blank" href="<?php echo home_url( 'project-listing' ); ?>/?project_keyword=<?php echo $key; ?>" class="search-result-view"><?php echo __('View All Results', 'houzez_child') ?></a>
    </div>
    <?php endif ?>
  </div>

 
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

// currency switch
add_shortcode( 'translate_switch', 'create_translate_switch' );
function create_translate_switch($attrs) {
  extract(shortcode_atts (array(
    'key' => ''
  ), $attrs));
  ob_start();
  ?>
  <div id="translate-switch">
    <?php echo '<div id="gtranslate_wrapper">' . do_shortcode('[gtranslate]') . '</div>'; ?>
  </div>

  <script type="text/javascript">
    (function($) {
      $(document).ready(function() {
        // Call to function
        if ($.cookie('mycasa_selected_lang')) {
          $('#gtranslate_wrapper .selected > a').html($.cookie('mycasa_selected_lang'));
        }

        // if (!$.cookie('googtrans')) {
        //   $.cookie('googtrans', '/en/en', { path: '/' });
        // }

        $('#gtranslate_wrapper .option > a').on('click', function() {
          var switch_lang = $(this).find('img').attr('alt');
          $.removeCookie('googtrans');
          $.cookie('googtrans', '/en/' + switch_lang, { path: '/' });

          // Update Flag
          var selected_lang = $('#gtranslate_wrapper .selected > a').html();
          $.removeCookie('mycasa_selected_lang');
          $.cookie('mycasa_selected_lang', selected_lang, { path: '/' });

          location.reload();
        });
      });

      $(window).load(function() {
        // Call to function
        var current_lang = "<?php echo $_COOKIE['googtrans']; ?>";
        
        //console.log(current_lang);
        if (current_lang != null) {
          $('select.selectpicker').selectpicker('refresh')
        }
      });
    })(jQuery);
  </script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}