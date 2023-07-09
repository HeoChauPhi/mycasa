<?php
/**
 * Constructor Parameters
 *
 * @param string    $text_domain your plugin text domain.
 * @param string    $parent_menu_slug the menu slug name where the "Recommendations" submenu will appear.
 * @param string    $submenu_label To change the submenu name.
 * @param string    $submenu_page_name an unique page name for the submenu.
 * @param int       $priority Submenu priority adjust.
 * @param string    $hook_suffix use it to load this library assets only to the recommedded plugins page. Not into the whol admin area.
 *
 */

if( class_exists('Hasthemes\HTContact_Form\Recommended_Plugins') ){
    $recommendations = new Hasthemes\HTContact_Form\Recommended_Plugins(
        array( 
            'text_domain'       => 'ht-contactform',
            'parent_menu_slug'  => 'htcontact-form',
            'menu_type'         => 'menupage',
            'menu_icon'         => 'dashicons-email-alt',
            'menu_capability'   => 'manage_options',
            'menu_page_slug'    => '',
            'priority'          => 300,
            'assets_url'        => '',
            'hook_suffix'       => '',
        )
    );

    $recommendations->add_new_tab(array(
        'title' => esc_html__( 'Recommended Plugins', 'ht-contactform' ),
        'active' => true,
        'plugins' => array(
            array(
                'slug'      => 'ht-mega-for-elementor',
                'location'  => 'htmega_addons_elementor.php',
                'name'      => esc_html__( 'HT Mega for Elementor', 'ht-contactform' )
            ),
            array(
                'slug'      => 'move-addons',
                'location'  => 'move-addons.php',
                'name'      => esc_html__( 'Move Addons for Elementor', 'ht-contactform' )
            ),
            array(
                'slug'      => 'hashbar-wp-notification-bar',
                'location'  => 'init.php',
                'name'      => esc_html__( 'Notification Bar for WordPress', 'ht-contactform' )
            ),
            array(
                'slug'      => 'insert-headers-and-footers-script',
                'location'  => 'init.php',
                'name'      => esc_html__( 'Insert Headers and Footers Code', 'ht-contactform' )
            )
            
        )
    ));

    $recommendations->add_new_tab(array(
        'title' => esc_html__( 'WooCommerce', 'ht-contactform' ),

        'plugins' => array(

            array(
                'slug'      => 'woolentor-addons',
                'location'  => 'woolentor_addons_elementor.php',
                'name'      => esc_html__( 'WooLentor – WooCommerce Elementor Addons + Builder', 'ht-contactform' )
            ),
            array(
                'slug'      => 'wishsuite',
                'location'  => 'wishsuite.php',
                'name'      => esc_html__( 'WishSuite', 'ht-contactform' )
            ),
            array(
                'slug'      => 'ever-compare',
                'location'  => 'ever-compare.php',
                'name'      => esc_html__( 'EverCompare', 'ht-contactform' )
            ),
            array(
                'slug'      => 'quickswish',
                'location'  => 'quickswish.php',
                'name'      => esc_html__( 'QuickSwish', 'ht-contactform' )
            ),
            array(
                'slug'      => 'just-tables',
                'location'  => 'just-tables.php',
                'name'      => esc_html__( 'JustTables', 'ht-contactform' )
            ),
            array(
                'slug'      => 'whols',
                'location'  => 'whols.php',
                'name'      => esc_html__( 'Whols', 'ht-contactform' )
            ),
            array(
                'slug'      => 'swatchly',
                'location'  => 'swatchly.php',
                'name'      => esc_html__( 'Swatchly', 'ht-contactform' )
            ),

        )

    ));

    $recommendations->add_new_tab(array(
        'title' => esc_html__( 'Other Plugins', 'ht-contactform' ),
        'plugins' => array(
            array(
                'slug'      => 'wp-plugin-manager',
                'location'  => 'plugin-main.php',
                'name'      => esc_html__( 'WP Plugin Manager', 'ht-contactform' )
            ),
            array(
                'slug'      => 'ht-easy-google-analytics',
                'location'  => 'ht-easy-google-analytics.php',
                'name'      => esc_html__( 'HT Easy GA4 ( Google Analytics 4 )', 'ht-contactform' )
            ),
            array(
                'slug'      => 'docus',
                'location'  => 'docus.php',
                'name'      => esc_html__( 'Docus', 'ht-contactform' )
            ),
            array(
                'slug'      => 'data-captia',
                'location'  => 'data-captia.php',
                'name'      => esc_html__( 'DataCaptia', 'ht-contactform' )
            )

        )
    ));
}
