<?php
/**
 * Admin settings page.
 */

class MyCasaConnectOdooSystem {
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
    // This page will be under "Settings"
    add_menu_page(
      __('MyCasa connect Odoo Setting', 'mycasa'),
      __('MyCasa to Odoo', 'mycasa'),
      'administrator',
      'mycasa-connect-odoo-setting-admin',
      array($this, 'create_admin_page'),
      plugins_url('/odoo-icon.png', __FILE__),
      99
    );

    add_submenu_page(
      'mycasa-connect-odoo-setting-admin',
      __( 'Setting', 'mycasa' ),
      __( 'Setting', 'mycasa' ),
      'administrator',
      'mycasa-connect-odoo-setting-admin',
      array( $this, 'create_admin_page' )
    );

    add_submenu_page(
      'mycasa-connect-odoo-setting-admin',
      __( 'Setting Data', 'mycasa' ),
      __( 'Setting Data', 'mycasa' ),
      'administrator',
      'mycasa-connect-odoo-setting-data',
      array( $this, 'create_data_page' )
    );

    /*// Import with batch process plugin
    add_submenu_page(
      'mycasa-connect-odoo-setting-admin',
      __( 'Import Data', 'mycasa' ),
      __( 'Import Data', 'mycasa' ),
      'administrator',
      'dg-batches'
    );*/

    add_submenu_page(
      'mycasa-connect-odoo-setting-admin',
      __( 'Import Data', 'mycasa' ),
      __( 'Import Data', 'mycasa' ),
      'administrator',
      'mycasa-connect-odoo-import-data',
      array( $this, 'create_import_page' )
    );

    add_submenu_page(
      'mycasa-connect-odoo-setting-admin',
      __( 'Remove Data', 'mycasa' ),
      __( 'Remove Data', 'mycasa' ),
      'administrator',
      'mycasa-connect-odoo-remove-data',
      array( $this, 'create_remove_page' )
    );
  }

  /**
  * Options page callback
  */
  public function create_admin_page() {
    // Set class property
    $this->options = get_option('mycasa_connect_odoo_board_settings');

    ?>
    <div class="wrap">
      <h1 style="margin-bottom: 30px;"><?php echo __('Odoo Setting', 'mycasa'); ?></h1>
      <form method="post" action="options.php" id="odoo-setting-form" class="odoo-setting-form">
      <?php
        // This prints out all hidden setting fields
        settings_fields('mycasa_connect_odoo_option_config');
        do_settings_sections('mycasa-connect-odoo-setting-admin');
        echo '<div class="odoo-setting-form-action">';
        submit_button();
        echo '<button id="odoo-verify-user" class="button button-secondary">'. __('Verify Account', 'mycasa') .'</button><span id="odoo-verify-message" class="odoo-verify-message"></span></div>';
      ?>
      </form>
      <script type="text/javascript">
        (function($) {
          $(document).ready(function(){
            $('#odoo-verify-user').on('click', function() {
              $odoo_url       = $('#odoo-setting-form #form-id-mycasa_connect_odoo_url').val();
              $odoo_db        = $('#odoo-setting-form #form-id-mycasa_connect_odoo_db').val();
              $odoo_username  = $('#odoo-setting-form #form-id-mycasa_connect_odoo_username').val();
              $odoo_password  = $('#odoo-setting-form #form-id-mycasa_connect_odoo_password').val();
              $.ajax({
                type : "post",
                dataType : "json",
                url : ajaxurl,
                data : {
                  action: "mycasa_to_odoo_verify_user",
                  odoo_url: $odoo_url,
                  odoo_db: $odoo_db,
                  odoo_username: $odoo_username,
                  odoo_password: $odoo_password
                },
                beforeSend: function() {
                  $('#odoo-setting-form #form-id-mycasa_connect_odoo_uid').val("");
                  $('#odoo-verify-user').attr("disabled", true);
                  $('#odoo-verify-message').removeClass('success').empty();
                },
                success: function(response) {
                  $('#odoo-verify-message').text(response.odoo_verify.message);
                  $('#odoo-verify-user').attr("disabled", false);
                  if (response.odoo_verify.status == true) {
                    $('#odoo-setting-form #form-id-mycasa_connect_odoo_uid').val(response.odoo_verify.uid);
                    $('#odoo-verify-message').addClass('success');
                    $("#odoo-setting-form #submit").trigger( "click" );
                  }
                },
                error: function(response) {
                  $('#odoo-setting-form #form-id-mycasa_connect_odoo_uid').val("");
                  $('#odoo-verify-user').attr("disabled", false);
                  $('#odoo-verify-message').text(response.odoo_verify.message);
                }
              });

              return false;
            });
          });
        })(jQuery);
      </script>
    </div>
    <?php
  }

  /**
  * Register and add settings
  */
  public function page_init() {
    register_setting('mycasa_connect_odoo_option_config', 'mycasa_connect_odoo_board_settings', 'custom_browsers_sanitize');

    // Odoo API Connect
    add_settings_section(
      'mycasa_connect_odoo_section_id', // ID
      __('Odoo Information', 'mycasa'), // Title
      array( $this, 'print_section_info' ), // Callback
      'mycasa-connect-odoo-setting-admin' // Page
    );

    add_settings_field(
      'mycasa_connect_odoo_url',
      __('Odoo URL', 'mycasa'),
      array( $this, 'form_textfield' ), // Callback
      'mycasa-connect-odoo-setting-admin', // Page
      'mycasa_connect_odoo_section_id',
      'mycasa_connect_odoo_url'
    );

    add_settings_field(
      'mycasa_connect_odoo_db',
      __('Odoo Database', 'mycasa'),
      array( $this, 'form_textfield' ), // Callback
      'mycasa-connect-odoo-setting-admin', // Page
      'mycasa_connect_odoo_section_id',
      'mycasa_connect_odoo_db'
    );

    add_settings_field(
      'mycasa_connect_odoo_username',
      __('Odoo Username', 'mycasa'),
      array( $this, 'form_textfield' ), // Callback
      'mycasa-connect-odoo-setting-admin', // Page
      'mycasa_connect_odoo_section_id',
      'mycasa_connect_odoo_username'
    );

    add_settings_field(
      'mycasa_connect_odoo_password',
      __('Odoo Password', 'mycasa'),
      array( $this, 'form_textfield' ), // Callback
      'mycasa-connect-odoo-setting-admin', // Page
      'mycasa_connect_odoo_section_id',
      'mycasa_connect_odoo_password'
    );

    add_settings_field(
      'mycasa_connect_odoo_uid',
      __('Odoo Uid', 'mycasa'),
      array( $this, 'form_textfield_readonly' ), // Callback
      'mycasa-connect-odoo-setting-admin', // Page
      'mycasa_connect_odoo_section_id',
      'mycasa_connect_odoo_uid'
    );

    // Project Setting Fields
    register_setting('mycasa_connect_odoo_data_option_config', 'mycasa_connect_odoo_data_settings', 'custom_browsers_sanitize');

    add_settings_section(
      'mycasa_connect_odoo_data_section_setting', // ID
      __('Import Data Config', 'mycasa'), // Title
      array( $this, 'print_section_info' ), // Callback
      'mycasa-connect-odoo-data-setting-admin' // Page
    );

    add_settings_field(
      'mycasa_connect_odoo_data_export_time',
      __('Export Time (Month and Year)', 'mycasa'),
      array( $this, 'form_select_data_month_year' ), // Callback
      'mycasa-connect-odoo-data-setting-admin', // Page
      'mycasa_connect_odoo_data_section_setting',
      'mycasa_connect_odoo_data_export_time'
    );

    add_settings_field(
      'mycasa_connect_odoo_data_limit',
      __('Data Limit Import', 'mycasa'),
      array( $this, 'form_data_textfield' ), // Callback
      'mycasa-connect-odoo-data-setting-admin', // Page
      'mycasa_connect_odoo_data_section_setting',
      'mycasa_connect_odoo_data_limit'
    );
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function custom_browsers_sanitize( $input ) {
    $new_input = array();

    if( isset( $input['mycasa_connect_odoo_url'] ) )
      $new_input['mycasa_connect_odoo_url'] = $input['mycasa_connect_odoo_url'];

    if( isset( $input['mycasa_connect_odoo_db'] ) )
      $new_input['mycasa_connect_odoo_db'] = $input['mycasa_connect_odoo_db'];

    if( isset( $input['mycasa_connect_odoo_username'] ) )
      $new_input['mycasa_connect_odoo_username'] = $input['mycasa_connect_odoo_username'];

    if( isset( $input['mycasa_connect_odoo_password'] ) )
      $new_input['mycasa_connect_odoo_password'] = $input['mycasa_connect_odoo_password'];

    if( isset( $input['mycasa_connect_odoo_uid'] ) )
      $new_input['mycasa_connect_odoo_uid'] = $input['mycasa_connect_odoo_uid'];

    if( isset( $input['mycasa_connect_odoo_data_export_time'] ) )
      $new_input['mycasa_connect_odoo_data_export_time'] = $input['mycasa_connect_odoo_data_export_time'];

    if( isset( $input['mycasa_connect_odoo_data_limit'] ) )
      $new_input['mycasa_connect_odoo_data_limit'] = $input['mycasa_connect_odoo_data_limit'];

    return $new_input;
  }

  /**
   * Get Data Setting
   */
  public function create_data_page() {
    $this->data_options = get_option('mycasa_connect_odoo_data_settings');

    ?>
    <div class="wrap">
      <h1 style="margin-bottom: 30px;"><?php echo __('Get Data Setting', 'mycasa'); ?></h1>
      <!-- <form method="post" action="options.php" id="odoo-data-setting-form" class="odoo-setting-form odoo-data-setting-form"> -->
      <?php
        // This prints out all hidden setting fields
        // settings_fields('mycasa_connect_odoo_data_option_config');
        // do_settings_sections('mycasa-connect-odoo-data-setting-admin');
        //submit_button();
      ?>
      <!-- </form> -->
      <div id="odoo-data-setting-form" class="odoo-setting-form odoo-data-setting-form">
        <div class="get-data-time">
          <h2 class="field-label"><?php echo __('Export Time', 'mycasa') ?></h2>
          <label><?php echo __(' From', 'mycasa') ?></label>
          <input type="text" name="data_time_from" id="data_time_from" class="input-get-data-time" readonly>
          <label><?php echo __('To', 'mycasa') ?></label>
          <input type="text" name="data_time_to" id="data_time_to" class="input-get-data-time" readonly>
          <button type="button" class="mycasa-form-datepicker-clear"> <?php echo __('Clear', 'mycasa'); ?></button>
          <br>
          <i><?php echo __('For Project and Property types', 'mycasa') ?></i>
        </div>
        <input type="hidden" name="get_data_limit" id="get_data_limit" value=500>
      </div>
      <h2 style="margin-bottom: 30px;"><?php echo __('Get Data process', 'mycasa'); ?></h2>
      <div class="odoo-getting-data">
        <div class="odoo-getting-data-actions">
          <button class="btn-get-data button button-secondary" data-value="real.estate.project" data-folder="project"><?php echo __('Get Projects Data', 'mycasa') ?></button>
          <button class="btn-get-data button button-secondary" data-value="real.estate.unit" data-folder="property"><?php echo __('Get Properties (Stock) Data', 'mycasa') ?></button>
          <button class="btn-get-data button button-secondary" data-value="real.estate.amenity" data-folder="amenity"><?php echo __('Get All Amenities Data', 'mycasa') ?></button>
          <button class="btn-get-data button button-secondary" data-value="real.estate.unit.tag" data-folder="tags"><?php echo __('Get All Property Tags', 'mycasa') ?></button>
          <!-- <button class="btn-get-data button button-secondary" data-value="real.estate.image" data-folder="picture"><?php //echo __('Get All Pictures Data', 'mycasa') ?></button>
          <button class="btn-get-data button button-secondary" data-value="ir.attachment" data-folder="document"><?php //echo __('Get All Documents Data', 'mycasa') ?></button> -->
          <input class="odoo-getting-data-connect-status" type="hidden" name="connect-status" value="connect">
          <input class="odoo-getting-data-loop" type="hidden" name="connect-loop" value=0>
          <input class="odoo-getting-data-count" type="hidden" name="connect-count" value=0>
        </div>
        <div class="odoo-getting-data-log">
          <code><?php echo __('No data', 'mycasa'); ?></code>
        </div>
      </div>
      <script type="text/javascript">
        (function($) {
          $(document).ready(function(){
            $('.odoo-getting-data-actions .btn-get-data').on('click', function() {
              $option_time_from  = null;
              $option_time_to  = null;
              if ($(this).data('value') == 'real.estate.project' || $(this).data('value') == 'real.estate.unit') {
                $option_time_from  = $('#data_time_from').val();
                $option_time_to  = $('#data_time_to').val();
              }
              $module = $(this).data('value');
              $folder = $(this).data('folder');
              $option_limit = $('#get_data_limit').val();
              $data_connect = $('.odoo-getting-data-connect-status').val();
              $data_loop = $('.odoo-getting-data-loop').val();
              $data_count = $('.odoo-getting-data-count').val();

              if (parseInt($option_limit ) > 500 || parseInt($option_limit) < 0) {
                $('#form-id-mycasa_connect_odoo_data_limit').val(500);
                $option_limit = 500;
                alert('<?php echo __('Please enter a minimum 0 and maximum of 500 records', 'mycasa'); ?>')
              }

              $this = $(this);
              // console.log($data_connect);
              // console.log($data_loop);

              $.ajax({
                type : "post",
                dataType : "json",
                url : ajaxurl,
                data : {
                  action: "mycasa_to_odoo_get_data",
                  module: $module,
                  folder: $folder,
                  option_time_from: $option_time_from,
                  option_time_to: $option_time_to,
                  option_limit: $option_limit,
                  data_connect: $data_connect,
                  data_loop: $data_loop,
                  data_count: $data_count
                },
                beforeSend: function() {
                  $('.btn-get-data').attr("disabled", true);
                  $('#form-id-mycasa_connect_odoo_data_limit').attr("readonly", true);

                  // Add to log message
                  if ($data_connect == 'connect' && $data_loop == 0) {
                    $('.odoo-getting-data-log').empty();
                  }
                  if ($data_loop == 0) {
                    $('.odoo-getting-data-log').append('<code><?php echo __('Getting data from Odoo Server...', 'mycasa'); ?></code><code><?php echo __('Pleases do not reload this page', 'mycasa'); ?></code>');
                  }
                },
                success: function(response) {
                  // console.log(response);
                  if (response.odoo_verify.status == 1) {
                    // Add to log message
                    $.each(response.odoo_verify.data, function(key, value) {
                      $('.odoo-getting-data-log').append('<code><?php echo __('Got ', 'mycasa'); ?>' + $this.data('folder') + ' ' + value + '</code>');
                    });

                    // Reset the data push
                    $('.odoo-getting-data-count').val(response.odoo_verify.data_count);
                    $('.odoo-getting-data-connect-status').val('connect');
                    $('.odoo-getting-data-loop').val(response.odoo_verify.offset_start);

                    // Reconnect
                    $this.trigger('click');
                  } else {
                    // Reset the data push
                    $('.odoo-getting-data-loop').val(0);
                    $('.odoo-getting-data-count').val(0);
                    $('.btn-get-data').attr({"disabled": false});
                    $('.odoo-getting-data-connect-status').val('connect');
                    $('#form-id-mycasa_connect_odoo_data_limit').attr("readonly", false);

                    // Add to log message
                    $('.odoo-getting-data-log').append('<code class="log-success"><?php echo __('Success.', 'mycasa'); ?></code>');
                  }
                  $('.odoo-getting-data-log').scrollTop(9999999);
                },
                error: function(response) {
                  if (response.status == 500) {
                    // Add to log message
                    $('.odoo-getting-data-log').append('<code class="log-error">' + response.statusText + '!</code>');
                    setTimeout(function () {
                      $('.odoo-getting-data-log').append('<code><?php echo __('Waiting for re-connecting...', 'mycasa'); ?></code>');
                    }, 1000);

                    // Reset the data push              
                    $('.odoo-getting-data-connect-status').val('re-connect');
                    setTimeout(function () {
                      $this.trigger('click');
                    }, 5000);
                  }
                  $('.odoo-getting-data-log').scrollTop(9999999);
                }
              });

              return false;
            });
          });
        })(jQuery);
      </script>
    </div>
    <?php
  }

  /**
  * Option Remove setting
  */
  public function create_remove_page() {
    ?>
    <div class="wrap">
      <h2 style="margin-bottom: 30px;"><?php echo __('Remove data process', 'mycasa'); ?></h2>
      <div class="odoo-remove-data">
        <div id="odoo-remove-data-tabs" style="margin-bottom: 7px;">
          <ul>
            <li><a href="#tabs-remove-project"><?php echo esc_html__('Remove Project', 'mycasa'); ?></a></li>
            <li><a href="#tabs-remove-property"><?php echo esc_html__('Remove Propert (Stock)', 'mycasa'); ?></a></li>
            <li><a href="#tabs-remove-other"><?php echo esc_html__('Remove Other data', 'mycasa'); ?></a></li>
          </ul>
          <div id="tabs-remove-project">
            <!-- <h4 class="remove-action-heading"><?php //echo esc_html__('Remove actions', 'mycasa'); ?></h4>
            <div class="odoo-remove-data-actions">
              <button class="btn-remove-data button button-secondary" data-value="project"><?php //echo esc_html__('Remove Projects Data', 'mycasa') ?></button>
              <br>
              <strong><i style="color: red;"><?php //echo esc_html__('If you click the buttons, will be remove all data corresponding on website', 'mycasa'); ?></i></strong>
            </div> -->
            <h4 class="remove-action-heading"><?php echo esc_html__('Clean actions', 'mycasa'); ?></h4>
            <div class="odoo-clean-data-actions">
              <button class="btn-clean-data button button-primary" data-value="project" data-module="real.estate.project"><?php echo esc_html__('Clean Projects Data', 'mycasa') ?></button>
              <br>
              <strong><i style="color: red;"><?php echo esc_html__('If you click "Clean Projects Data" button, will be remove all Projects on website but haven\'t on Odoo server', 'mycasa'); ?></i></strong>
            </div>
          </div>
          <div id="tabs-remove-property">
            <h4 class="remove-action-heading"><?php echo esc_html__('Remove actions', 'mycasa'); ?></h4>
            <div class="odoo-remove-data-actions">
              <button class="btn-remove-data button button-secondary" data-value="property_tag"><?php echo __('Remove All Property Tags Data', 'mycasa') ?></button>
              <!-- <button class="btn-remove-data button button-secondary" data-value="property"><?php // echo esc_html__('Remove Properties (Stock) Data', 'mycasa') ?></button> -->
              <br>
              <strong><i style="color: red;"><?php echo esc_html__('If you click the buttons, will be remove all data corresponding on website', 'mycasa'); ?></i></strong>
            </div>  
            <h4 class="remove-action-heading"><?php echo esc_html__('Clean actions', 'mycasa'); ?></h4>
            <div class="odoo-clean-data-actions">
              <button class="btn-clean-data button button-primary" data-value="property" data-module="real.estate.unit"><?php echo esc_html__('Clean Properties (Stock) Data', 'mycasa') ?></button>
              <br>
              <strong><i style="color: red;"><?php echo esc_html__('If you click "Clean Properties (Stock) Data" button, will be remove all Properties on website but haven\'t on Odoo server', 'mycasa'); ?></i></strong>
            </div>          
          </div>
          <div id="tabs-remove-other">
            <h4 class="remove-action-heading"><?php echo esc_html__('Remove actions', 'mycasa'); ?></h4>
            <div class="odoo-remove-data-actions">
              <button class="btn-remove-data button button-secondary" data-value="odoo_document"><?php echo __('Remove All Documents Data', 'mycasa') ?></button>
              <button class="btn-remove-data button button-secondary" data-value="odoo_picture"><?php echo __('Remove All Pictures Data', 'mycasa') ?></button>
              <button class="btn-remove-data button button-secondary" data-value="property_feature"><?php echo __('Remove All Amenities Data', 'mycasa') ?></button>
              <br>
              <strong><i style="color: red;"><?php echo esc_html__('If you click the buttons, will be remove all data corresponding on website', 'mycasa'); ?></i></strong>
            </div>
          </div>
        </div>
        
        <input class="odoo-remove-data-status" type="hidden" name="connect-status" value=0>

        <div class="odoo-getting-data-log">
          <code><?php echo __('No data', 'mycasa'); ?></code>
        </div>
      </div>

      <script type="text/javascript">
        (function($) {
          $(document).ready(function(){
            $( "#odoo-remove-data-tabs" ).tabs();

            $('.odoo-remove-data-actions .btn-remove-data').on('click', function() {

              $this = $(this);
              var data_type = $(this).data('value');

              $.ajax({
                type : "post",
                dataType : "json",
                url : ajaxurl,
                data : {
                  action: "mycasa_to_odoo_remove_data",
                  data_type: data_type
                },
                beforeSend: function() {
                  $('.btn-remove-data').attr("disabled", true);

                  if ($('.odoo-remove-data-status').val() == 0) {
                    $('.odoo-getting-data-log').empty().append('<code><?php echo __('Removing', 'mycasa'); ?>' + ' ' + $this.data('value') + '...</code>');
                  }
                },
                success: function(response) {
                  if (response.remove_status == 1) {
                    $('.odoo-getting-data-log').empty().append('<code><?php echo __('Removing', 'mycasa'); ?>' + ' ' + $this.data('value') + '...</code>');
                    $('.odoo-remove-data-status').val(1);

                    // Reconnect
                    $this.trigger('click');
                  } else {
                    $('.btn-remove-data').attr({"disabled": false});
                    $('.odoo-remove-data-status').val(0);

                    // Add to log message
                    $('.odoo-getting-data-log').empty().append('<code class="log-success"><?php echo __('Removed', 'mycasa'); ?>' + ' ' + $this.data('value') + '</code>');
                  }
                  $('.odoo-getting-data-log').scrollTop(9999999);
                },
                error: function(response) {
                  console.log(response);
                  if (response.status == 500 || response.status == 504 || response.status == 404) {
                    // Add to log message
                    $('.odoo-getting-data-log').append('<code class="log-error">' + response.statusText + '!</code>');
                    setTimeout(function () {
                      $('.odoo-getting-data-log').append('<code><?php echo __('Waiting for re-connecting...', 'mycasa'); ?></code>');
                    }, 1000);

                    $('.odoo-remove-data-status').val(0);
                    setTimeout(function () {
                      $this.trigger('click');
                    }, 5000);
                  }
                  $('.odoo-getting-data-log').scrollTop(9999999);
                }
              });

              return false;
            });

            $('.odoo-clean-data-actions .btn-clean-data').on('click', function() {

              if( confirm('Are you sure you want to ' + $(this).text()) ) {
                $this = $(this);
                var data_type = $(this).data('value');
                var data_module = $(this).data('module');

                $.ajax({
                  type : "post",
                  dataType : "json",
                  url : ajaxurl,
                  data : {
                    action: "mycasa_to_odoo_clean_data",
                    data_type: data_type,
                    data_module: data_module
                  },
                  beforeSend: function() {
                    $('.btn-remove-data, .btn-clean-data').attr("disabled", true);
                    $('.odoo-getting-data-log').empty().append('<code><?php echo __('Removing', 'mycasa'); ?>' + ' ' + $this.data('value') + '...</code>');
                  },
                  success: function(response) {
                    console.log(response);
                    $.each(response.remove_status, function(index, value) {
                      $('.odoo-getting-data-log').append('<code>' + (index + 1) + '. <?php echo __('Removed', 'mycasa'); ?>' + ' ' + value + '</code>');
                    });
                    $('.odoo-getting-data-log').append('<code class="log-success"><?php echo __('Success!', 'mycasa'); ?></code>');
                    $('.odoo-getting-data-log').scrollTop(9999999);
                    $('.btn-remove-data, .btn-clean-data').attr("disabled", false);
                  },
                  error: function(response) {
                    console.log(response);
                    if (response.status == 500 || response.status == 504 || response.status == 404) {
                      // Add to log message
                      $('.odoo-getting-data-log').append('<code class="log-error">' + response.statusText + '!</code>');
                      setTimeout(function () {
                        $('.odoo-getting-data-log').append('<code><?php echo __('Waiting for re-connecting...', 'mycasa'); ?></code>');
                      }, 1000);

                      setTimeout(function () {
                        $this.trigger('click');
                      }, 5000);
                    }
                    $('.odoo-getting-data-log').scrollTop(9999999);
                  }
                });
              } else {
                return false;
              }

              return false;
            });
          });
        })(jQuery);
      </script>
    </div>
    <?php
  }

  /**
  * Option Import setting
  */
  public function create_import_page() {
    ?>
    <div class="wrap">
      <h2 style="margin-bottom: 30px;"><?php echo __('Import data process', 'mycasa'); ?></h2>
      <div class="odoo-import-data">
        <div class="odoo-import-data-actions" style="margin-bottom: 7px;">
          <!-- <button class="btn-import-data button button-secondary" data-value="odoo_document">
            <?php //echo __('Import Documents', 'mycasa') ?> - 
            <span class="odoo-import-data-total"><?php //echo __('Total', 'mycasa') ?>: <?php //echo count(mycasa_to_odoo_get_json_data('document')); ?></span>
          </button>
          <span style="font-size: 24px;">&#8594;</span>
          <button class="btn-import-data button button-secondary" data-value="odoo_picture">
            <?php //echo __('Import Pictures', 'mycasa') ?> - 
            <span class="odoo-import-data-total"><?php //echo __('Total', 'mycasa') ?>: <?php //echo count(mycasa_to_odoo_get_json_data('picture')); ?></span>
          </button>
          <span style="font-size: 24px;">&#8594;</span> -->
          <button class="btn-import-data button button-secondary" data-value="property_tag">
            <?php echo __('Import Tags', 'mycasa') ?> - 
            <span class="odoo-import-data-total"><?php echo __('Total', 'mycasa') ?>: <?php echo count(mycasa_to_odoo_get_json_data('tags')); ?></span>
          </button>
          <span style="font-size: 24px;">&#8594;</span>
          <button class="btn-import-data button button-secondary" data-value="property_feature">
            <?php echo __('Import Amenities', 'mycasa') ?> - 
            <span class="odoo-import-data-total"><?php echo __('Total', 'mycasa') ?>: <?php echo count(mycasa_to_odoo_get_json_data('amenity')); ?></span>
          </button>
          <span style="font-size: 24px;">&#8594;</span>
          <button class="btn-import-data button button-secondary" data-value="project">
            <?php echo __('Import Projects', 'mycasa') ?> - 
            <span class="odoo-import-data-total"><?php echo __('Total', 'mycasa') ?>: <?php echo count(mycasa_to_odoo_get_json_data('project')); ?></span>
          </button>
          <span style="font-size: 24px;">&#8594;</span>
          <button class="btn-import-data button button-secondary" data-value="property">
            <?php echo __('Import Properties (Stock) Data', 'mycasa') ?> - 
            <span class="odoo-import-data-total"><?php echo __('Total', 'mycasa') ?>: <?php echo count(mycasa_to_odoo_get_json_data('property')); ?></span>
          </button>

          <input class="odoo-import-data-number" type="hidden" name="connect-number" value=0>
          <input class="odoo-import-data-status" type="hidden" name="connect-status" value=0>
        </div>
        <div class="odoo-getting-data-log">
          <code><?php echo __('No data', 'mycasa'); ?></code>
        </div>
      </div>
      <script type="text/javascript">
        (function($) {
          $(document).ready(function(){
            $('.odoo-import-data-actions .btn-import-data').on('click', function() {
              $this = $(this);
              var data_type = $(this).data('value');
              var data_number = $('.odoo-import-data-number').val();

              $.ajax({
                type : "post",
                dataType : "json",
                url : ajaxurl,
                data : {
                  action: "mycasa_to_odoo_import_data",
                  data_type: data_type,
                  data_number: data_number
                },
                beforeSend: function() {
                  $('.btn-import-data').attr("disabled", true);

                  if ($('.odoo-import-data-status').val() == 0) {
                    $('.odoo-getting-data-log').empty().append('<code><?php echo __('Importing', 'mycasa'); ?>' + ' ' + $this.data('value') + '...</code>');
                  }
                },
                success: function(response) {
                  //$('.btn-import-data').attr({"disabled": false});
                  if (response.import_status == 1) {
                    var data_index = parseInt(data_number) + 1;

                    $('.odoo-getting-data-log').append('<code>' + data_index + ': <?php echo __('imported', 'mycasa'); ?>' + ' ' + response.data_resulf + '</code>');
                    $('.odoo-import-data-status').val(1);
                    $('.odoo-import-data-number').val(data_index);

                    // Reconnect
                    $this.trigger('click');
                  } else {
                    $('.btn-import-data').attr({"disabled": false});
                    $('.odoo-import-data-status').val(0);
                    $('.odoo-import-data-number').val(0);

                    // Add to log message
                    $('.odoo-getting-data-log').append('<code class="log-success"><?php echo __('Finished import the', 'mycasa'); ?>' + ' ' + $this.data('value') + '</code>');
                  }
                  $('.odoo-getting-data-log').scrollTop(9999999);
                },
                error: function(response) {
                  if (response.status == 500 || response.status == 504 || response.status == 404) {
                    // Add to log message
                    $('.odoo-getting-data-log').append('<code class="log-error">' + response.statusText + '!</code>');
                    setTimeout(function () {
                      $('.odoo-getting-data-log').append('<code><?php echo __('Waiting for re-connecting...', 'mycasa'); ?></code>');
                    }, 1000);

                    setTimeout(function () {
                      $this.trigger('click');
                    }, 5000);
                  }
                  $('.odoo-getting-data-log').scrollTop(9999999);
                }
              });

              return false;
            });
          });
        })(jQuery);
      </script>
    </div>
    <?php
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
    printf('<input type="text" size=60 id="form-id-%s" name="mycasa_connect_odoo_board_settings[%s]" value="%s" />', $name, $name, $value);
  }

  public function form_textfield_readonly($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<input type="text" size=60 id="form-id-%s" name="mycasa_connect_odoo_board_settings[%s]" value="%s" readonly />', $name, $name, $value);
  }

  public function form_select_data_month_year($name) {
    $value = isset($this->data_options[$name]) ? esc_attr($this->data_options[$name]) : '';
    ?>
    <input type="text" size=20 id="form-id-<?php echo $name; ?>" class="mycasa-form-datepicker" name="mycasa_connect_odoo_data_settings[<?php echo $name; ?>]" value="<?php echo $value; ?>" readonly />
    <button type="button" class="mycasa-form-datepicker-clear"> <?php echo __('Clear', 'mycasa'); ?></button>
    <div><i><?php echo __('For Project and Property types', 'mycasa'); ?></i></div>
    <?php
  }

  public function form_data_textfield($name) {
    $value = isset($this->data_options[$name]) ? esc_attr($this->data_options[$name]) : 500;
    printf('<input type="number" min="0" max="500" size=20 id="form-id-%s" name="mycasa_connect_odoo_data_settings[%s]" value="%s" />', $name, $name, $value);
  }

  public function form_data_number($name) {
    $value = isset($this->data_options[$name]) ? esc_attr($this->data_options[$name]) : '';
    printf('<input type="number" min="10000000" max="99999990" size=20 id="form-id-%s" name="mycasa_connect_odoo_data_settings[%s]" value="%s" />', $name, $name, $value);
  }
}
