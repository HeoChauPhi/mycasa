<?php
add_action( 'admin_init', 'mycasa_wp_bp_config' );
function mycasa_wp_bp_config() {
  remove_menu_page( 'dg-batches' );
}
