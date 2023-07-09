<?php 
global $post; 
$site_breadcrumb = houzez_option('site_breadcrumb');
$page_breadcrumb = get_post_meta($post->ID, 'fave_page_breadcrumb', true);
?>

<div class="breadcrumb-wrap">
<?php
if($page_breadcrumb != 'hide') {
  if( $site_breadcrumb != 0 ) {
?>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>"><span><?php echo __('Home', 'houzez_child'); ?></span></a></li>
      <?php if (wp_get_post_terms($post->ID, 'property_label')): ?>
        <?php
        $term_obj = wp_get_post_terms($post->ID, 'property_label')[0];
        $term_link = get_term_link($term_obj);
        $term_name = $term_obj->name;
        ?>
        <li class="breadcrumb-item"><a href="<?php echo $term_link; ?>"> <span><?php echo $term_name; ?></span></a></li>
      <?php endif; ?>
      
      <?php if (get_field('project_id', $post->ID)): ?>
        <?php $project_link = get_field('project_id', $post->ID)[0]; ?>
        <li class="breadcrumb-item notranslate"><a href="<?php echo get_post_permalink($project_link) ?>"> <span><?php echo get_the_title($project_link); ?></span></a></li>
      <?php endif; ?>

      <li class="breadcrumb-item active notranslate"><?php echo get_the_title($post->ID); ?></li></ol>
  </nav>
<?php } 
}?>
</div><!-- breadcrumb-wrap -->