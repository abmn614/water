<?php 

Class IndexController extends Controller{
	function actionIndex(){
		$config = array('db' => $GLOBALS['POST'], 'tab' => 'user');
		$user = M($config);
		// $this->rsts = $user->select();
		$rst = $user->execute("update user set name = 'dlm' where id = 2");
		$this->rsts = $user->query("SELECT * from user");
		// $user = obj('Post', '', $config);
		// $this->rsts = $user->getAll();
		// $this->rsts = $user->getOne();
		$this->display('index');
	}
}