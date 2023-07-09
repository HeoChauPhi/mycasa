<?php
/**
 * Admin settings page.
 */

class MyCasaCareerSystem {
  /**
  * Holds the values to be used in the fields callbacks
  */
  private $options;

  private $data_options;

  /**
  * Start up
  */
  public function __construct() {
    add_action('admin_menu', array($this, 'add_plugin_page' ));
    add_action('admin_init', array($this, 'page_init'));
  }

  /**
  * Add options page
  */
  public function add_plugin_page() {
    add_submenu_page(
      'edit.php?post_type=career',
      __( 'Career Setting', 'mycasa' ),
      __( 'Career Setting', 'mycasa' ),
      'administrator',
      'mycasa-career-setting-admin',
      array($this, 'create_admin_page'),
    );
  }

  /**
  * Options page callback
  */
  public function create_admin_page() {
    // Set class property
    $this->options = get_option('career_board_settings');

    ?>
    <div class="wrap">
      <h1 style="margin-bottom: 30px;"><?php echo __('Career Setting', 'mycasa'); ?></h1>
      <form method="post" action="options.php" id="career-setting-form" class="career-form">
      <?php
        // This prints out all hidden setting fields
        settings_fields('career_option_config');
        do_settings_sections('mycasa-career-setting-admin');
        submit_button();
      ?>
      </form>
    </div>
    <?php
  }

  /**
  * Register and add settings
  */
  public function page_init() {
    // Add Script on setting page
    wp_register_script('mycasa-cpt-script', MYCASA_CPT_PLUGIN_PATH . '/access/js/mycasa-cpt-script.js', ['jquery'], '1.1', true );
    wp_enqueue_script( 'mycasa-cpt-script' );

    register_setting('career_option_config', 'career_board_settings', 'custom_browsers_sanitize');

    // Odoo API Connect
    add_settings_section(
      'mycasa_career_section', // ID
      __('', 'mycasa'), // Title
      array( $this, 'print_section_info' ), // Callback
      'mycasa-career-setting-admin' // Page
    );

    add_settings_field(
      'career_company_location',
      __('Company Location', 'mycasa'),
      array( $this, 'form_textfield' ), // Callback
      'mycasa-career-setting-admin', // Page
      'mycasa_career_section',
      'career_company_location'
    );

    add_settings_field(
      'career_company_email',
      __('Company Email', 'mycasa'),
      array( $this, 'form_email' ), // Callback
      'mycasa-career-setting-admin', // Page
      'mycasa_career_section',
      'career_company_email'
    );

    add_settings_field(
      'career_application_form',
      __('Application Form', 'mycasa'),
      array( $this, 'form_file' ), // Callback
      'mycasa-career-setting-admin', // Page
      'mycasa_career_section',
      'career_application_form'
    );

    add_settings_field(
      'career_contact_us',
      __('Contact Us', 'mycasa'),
      array( $this, 'form_wysiwyg' ), // Callback
      'mycasa-career-setting-admin', // Page
      'mycasa_career_section',
      'career_contact_us'
    );
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function custom_browsers_sanitize( $input ) {
    $new_input = array();

    if( isset( $input['career_company_location'] ) )
      $new_input['career_company_location'] = $input['career_company_location'];

    if( isset( $input['career_company_email'] ) )
      $new_input['career_company_email'] = $input['career_company_email'];

    if( isset( $input['career_application_form'] ) )
      $new_input['career_application_form'] = $input['career_application_form'];

    if( isset( $input['career_contact_us'] ) )
      $new_input['career_contact_us'] = $input['career_contact_us'];

    return $new_input;
  }

  /**
  * Print the Section text
  */
  public function print_section_info() {}

  /**
  * Get the settings option array and print one of its values
  */
  public function form_textfield($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<input type="text" size=60 id="form-id-%s" name="career_board_settings[%s]" value="%s" />', $name, $name, $value);
  }

  public function form_email($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<input type="email" size=60 id="form-id-%s" name="career_board_settings[%s]" value="%s" />', $name, $name, $value);
  }

  public function form_file($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<input class="upload_career_application_form_url" type="text" size=60 id="form-id-%s" name="career_board_settings[%s]" value="%s" readonly />', $name, $name, $value);
    printf('<button class="button button-secondary upload_career_application_form_button" type="button" value="%s">%s</button>', __('Upload Application Form', 'mycasa'), __('Upload Application Form', 'mycasa'));
    printf('<br /><b><i>%s <span style="color: red;">pdf, doc, docx, xls, xlsx</span>.</i></b>', __('Please upload profile with formats:', 'mycasa'));
  }

  public function form_wysiwyg($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    //printf('<textarea id="form-id-%s" name="career_board_settings[%s]" rows="4" cols="50"></textarea>', $name, $name);
    //print(wp_editor($value, $this->options['section_one_content']));
    wp_editor( html_entity_decode(stripslashes($value)), 'form-id-'.$name, array('textarea_name' => 'career_board_settings['.$name.']',));
  }
}
