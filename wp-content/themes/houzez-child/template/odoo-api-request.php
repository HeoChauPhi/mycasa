<?php
/**
 * Template Name: Odoo API Request
 * Created by Mycasa.
 * User: Mycasa
 * Date: 09/02/2021
 * Time: 0:00 AM
 */

$odoo_modules_arr = array(
  array(
    'name' => 'Projects',
    'value' => 'real.estate.project',
  ),
  array(
    'name' => 'Stocks',
    'value' => 'real.estate.unit',
  ),
  array(
    'name' => 'Images',
    'value' => 'real.estate.image',
  )
);

$odoo_data_result_arr = array(
  array(
    'name' => 'PHP Array',
    'value' => 'array',
  ),
  array(
    'name' => 'Json',
    'value' => 'json',
  )
);

$odoo_module = '';
if ($_GET['odoo_module']) {
  $odoo_module = $_GET['odoo_module'];
}

$odoo_limit = 2;
if ($_GET['odoo_limit']) {
  $odoo_limit = $_GET['odoo_limit'];
}

$odoo_data_result = 'array';
if ($_GET['odoo_data_result']) {
  $odoo_data_result = $_GET['odoo_data_result'];
}

?>

<style type="text/css">
  form#odoo-api {
    margin: 0 auto;
    padding: 20px;
    text-align: center;
    max-width: 350px;
    font-family: 'sans-serif';
  }

  .form-item {
    margin: 0 0 15px;
  }

  .form-item > label {
    display: block;
    font-weight: 700;
    margin: 0 0 7px;
    text-align: left;
  }

  .odoo_module,
  .odoo_limit,
  .odoo_data_result {
    height: 40px;
    padding: 7px 10px;
    width: 100%;
  }

  button[type="submit"] {
    cursor: pointer;
    height: 40px;
    margin: 0 auto;
    padding: 7 30px;
  }

  pre {
    border: 1px solid #000;
    padding: 20px;
    white-space: break-spaces;
    word-break: break-word;
  }
</style>

<form id="odoo-api" action="/odoo-api/">
  <div class="form-item">
    <label for="odoo_module">Odoo Module</label>
    <select name="odoo_module" class="odoo_module" id="odoo_module">
      <?php foreach ($odoo_modules_arr as $module): ?>
        <option value="<?php echo $module['value']; ?>" <?php if ($odoo_module == $module['value']){ echo 'selected="selected"'; } ?>><?php echo $module['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-item">
    <label for="odoo_limit">Limit requests</label>
    <input type="number" id="odoo_limit" class="odoo_limit" name="odoo_limit" value="<?php echo $odoo_limit ?>" min="1" max="100">
  </div>

  <div class="form-item">
    <label for="odoo_data_result">Data type</label>
    <select name="odoo_data_result" class="odoo_data_result" id="odoo_data_result">
      <?php foreach ($odoo_data_result_arr as $data): ?>
        <option value="<?php echo $data['value']; ?>" <?php if ($odoo_data_result == $data['value']){ echo 'selected="selected"'; } ?>><?php echo $data['name']; ?></option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="form-item form-action">
    <button type="submit">Get</button>
  </div>
</form>

<?php
if (!empty($odoo_module)) {
  $odoo_options = get_option('mycasa_connect_odoo_board_settings');

  $odoo_url = $odoo_options['mycasa_connect_odoo_url'];
  $odoo_db = $odoo_options['mycasa_connect_odoo_db'];
  $odoo_username = $odoo_options['mycasa_connect_odoo_username'];
  $odoo_password = $odoo_options['mycasa_connect_odoo_password'];

  $OdooClient = new MyCasa_Odoo_client($odoo_url, $odoo_db, $odoo_username, $odoo_password);

  $data_fields = array();
  if ( $odoo_module == 'real.estate.project' ) {
    $data_fields = mycasa_to_odoo_project_fields();
  } elseif ( $odoo_module == 'real.estate.unit' ) {
    $data_fields = mycasa_to_odoo_property_fields();
  }

  $odoo_data = $OdooClient->get_list_search($odoo_module, (int) $odoo_limit, null, array(), $data_fields);

  if ( $odoo_module == 'real.estate.image' ) {
    $odoo_data = $OdooClient->get_list_search('real.estate.image', 1, null, array(), array());
  }

  if ($odoo_data_result == 'json') {
    $odoo_data = json_encode($odoo_data, JSON_INVALID_UTF8_SUBSTITUTE);
  }

  echo "<pre>";
  print_r($odoo_data);
  echo "</pre>";
}
