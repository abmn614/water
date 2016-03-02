<?php 
return array(
	'AUTO_LOAD_DIR'	=>	array(
		BASE_DIR . 'Water/Lib',
		BASE_DIR . 'Water/Ext',
		BASE_DIR . 'App/Controller',
		BASE_DIR . 'App/Model',
		),
	'ERROR_LOG_PATH'	=>	BASE_DIR . 'Data/error.log',

	/** 伪静态 **/
	'REWRITE_MODE' => 1, // 1:PATH_INFO,2:NORMAL
	'REWRITE'	=>	array(
		'index'	=>	'Index/Index',
		),

	/** 模版 **/
	'TEMPLATE_DIR'	=>	BASE_DIR . 'App/View',
	'COMPILE_DIR'	=>	BASE_DIR . 'Data/tmp',
	'CACHE_DIR'	=>	BASE_DIR . 'Data/tmp',
	'LEFT_DELIMITER'	=>	'{{ ',
	'RIGHT_DELIMITER'	=>	' }}',
	'TEMPLATE_SUFFIX'	=>	'.html',

	/** 数据库 **/
	'POST' => array(
	    'type'      => 'mysql',
	    'host'      => 'localhost',
	    'port'      => 3306,
	    'dbname'    => 'water',
	    'username'  => 'root',
	    'password'  => '',
	    'names'     => 'utf8'
	    ),
	);