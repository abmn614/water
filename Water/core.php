<?php 
date_default_timezone_set('PRC');

$GLOBALS = require(BASE_DIR . 'Water/config.php');
require(BASE_DIR . 'Water/functions.php');

require('Controller.php');
require('Model.php');

$controller_name = 'Index';
$action_name = 'actionIndex';

if (REWRITE) {
	if (strpos($_SERVER['REQUEST_URI'], '?') === false) {
		$rules = C('REWRITE');
		$rewite_mode = C('REWRITE_MODE');
		if ($rewite_mode == 1 && isset($_SERVER['PATH_INFO'])) { // PATH_INFO
			$rule = strtolower(substr($_SERVER['PATH_INFO'], 1));
		}else{
			$rule = substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['SCRIPT_NAME'])) + 1);
		}
		foreach ($rules as $k => $v) {
			if ($k == $rule) {
				$rewrite_arr = explode('/', $v);
				$_REQUEST['r'] = $v;
				break;
			}
		}
		if (!isset($_REQUEST['r'])) {
			header('HTTP/1.1 404 NOT FOUND');
			exit("404 NOT FOUND");
		}
	}
}

if (isset($_REQUEST['r'])) {
	$route_arr = explode('/', $_REQUEST['r']);
	isset($route_arr[0]) && $controller_name = ucfirst(strtolower($route_arr[0]));
	isset($route_arr[1]) && $action_name = 'action' . ucfirst(strtolower($route_arr[1]));
}

	$obj = obj($controller_name.'Controller');
	$obj->$action_name();

/* 实例化对象 */
function obj($class_name, $file_path = '', $param = array()){
	$file_exists = false;

	if (!preg_match('/^[a-z0-9_]+$/i', $class_name))
		throw new Exception("类名只允许字母、数字、下划线");
	if (isset($obj[$class_name])) return $obj[$class_name];
	$autoload_dir = C('AUTO_LOAD_DIR');
	if (empty($file_path)) {
		if (is_array($autoload_dir)) {
			foreach ($autoload_dir as $k => $v) {
				$file = "{$v}/{$class_name}.php";
				if (file_exists($file)) {
					$file_exists = true;
					break;
				}
			}
		}	
	}else{
		if (file_exists($file_path)) {
			$file = $file_path;
			$file_exists = true;
		}
	}

	require_once($file);
	$obj[$class_name] = new $class_name($param);
	return $obj[$class_name];
}