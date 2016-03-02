<?php 
Class Controller {
	private $_data = array();

	function __set($k, $v){
		$this->_data[$k] = $v;
	}

	function __get($k){
		return $this->_data[$k];
	}

	function smarty(){
		$smarty = obj('Smarty', BASE_DIR . 'Water/Lib/Smarty/Smarty.class.php');
		$smarty->template_dir = C('TEMPLATE_DIR');
		$smarty->compile_dir = C('COMPILE_DIR');
		$smarty->cache_dir = C('CACHE_DIR');
		$smarty->left_delimiter = C('LEFT_DELIMITER');
		$smarty->right_delimiter = C('RIGHT_DELIMITER');
		return $smarty;
	}

	function display($tmp_name){
		$smarty = $this->smarty();
		$tmp_suffix = C('TEMPLATE_SUFFIX');
		$smarty->assign(get_object_vars($this));
		$smarty->assign($this->_data);
		$smarty->display($tmp_name . $tmp_suffix);
	}
}