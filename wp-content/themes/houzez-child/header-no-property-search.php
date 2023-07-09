<?php
global $houzez_local;
$houzez_local = houzez_get_localization();
/**
 * @package Houzez
 * @since Houzez 1.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="profile" href="https://gmpg.org/xfn/11" />
    <meta name="format-detection" content="telephone=no">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php get_template_part('template-parts/header/nav-mobile'); ?>

<?php if(houzez_is_dashboard()) { ?>

  <main id="main-wrap" class="main-wrap dashboard-main-wrap">
  <?php get_template_part('template-parts/header/header-mobile'); ?>

<?php } else { ?>

  <main id="main-wrap" class="main-wrap <?php if(houzez_is_splash()) { echo 'splash-page-wrap'; }?>">

  <?php 
  if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
    get_template_part('template-parts/header/main'); 
  }?>

  <?php 
  if (is_singular('project')) {
    get_template_part('template-parts/search/project-search');
  }
  ?>

  <?php

  get_template_part('template-parts/banners/main');
  
}
