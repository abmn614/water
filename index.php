<?php 
define('BASE_DIR', dirname(__FILE__) . '/');
define('DEBUG', 1);
define('REWRITE', 1);

session_save_path(BASE_DIR . 'Run/session');
@session_start();

require(BASE_DIR . 'Water/core.php');

// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";