<?php
$search_title = __('real estate', 'houzez_child');

if (isset($_GET['project_id']) && $_GET['project_id'] != '') {
  $search_title = get_the_title($_GET['project_id']);
} elseif (isset($_GET['project_keyword']) && $_GET['project_keyword'] != '') {
  $search_title = $_GET['project_keyword'];
} 

get_template_part('template-parts/page/breadcrumb'); ?> 
<div class="d-flex align-items-center">
  <div class="page-title flex-grow-1">
    <h1><?php echo __($_GET['type'], 'houzez_child') . ': ' . $search_title; ?></h1>
  </div>
  <?php get_template_part('template-parts/listing/listing-switch-view') ;?> 
</div><!-- d-flex -->  
