<?php 
// 设定错误和异常处理
register_shutdown_function('fatalError');
set_error_handler('appError');
set_exception_handler('appException');

function appError($errno, $errstr, $errfile, $errline, $errcontext){
	$str = "[$errno][appError] [$errstr] [$errfile] ($errline) \r\n";
	if (DEBUG) {
		echo $str;
	}else{
		$error_log_file = C('ERROR_LOG_PATH');
		error_log($str, 3, $error_log_file);
	}
}

function fatalError(){
	if ($e = error_get_last()) {
		switch($e['type']){
			case E_ERROR:
			case E_PARSE:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_USER_ERROR:
				ob_end_clean();
				$str = "[{$e['type']}][fatalError] [{$e['message']}] [{$e['file']}] ({$e['line']}) \r\n";
				if (DEBUG) {
					echo $str;
				}else{
					$error_log_file = C('ERROR_LOG_PATH');
					error_log($str, 3, $error_log_file);
				}
			break;
		}
	}
}

function appException($e){
	$error['message'] = $e->getMessage();
	$error['file']  =   $e->getFile();
	$error['line']  =   $e->getLine();
	$str = "[appException] [{$error['message']}] [{$error['file']}] ({$error['line']}) \r\n";
	if (DEBUG) {
		echo $str;
	}else{
		$error_log_file = C('ERROR_LOG_PATH');
		error_log($str, 3, $error_log_file);
	}
}

/* 列出所有目录 */
function ListDir($path = './'){
    $data = array();
    $current_dir = opendir($path);
    while(($file = readdir($current_dir)) != false) {
        $sub_dir = $path. DIRECTORY_SEPARATOR . $file;
        if($file == '.' || $file == '..' || $file[0] == '.'){
            continue;
        }elseif(is_dir($sub_dir)){
            $data[] = $file;
            $data = array_merge($data, ListDir($sub_dir));
        }elseif(is_file($sub_dir)){
            $data[] =  $file;     
        }
    }
    return $data;
}


function C($key){
	return $GLOBALS[$key];
}

function M($config){
    return new Model($config);
}