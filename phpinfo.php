<?php
//var_dump(get_loaded_extensions());
echo 'XMLRPC is ', extension_loaded('xmlrpc') ? 'loaded' : 'not loaded';
phpinfo();
die;
