<?php 

Class IndexController extends Controller{
	function actionIndex(){
		$config = array('db' => $GLOBALS['POST'], 'tab' => 'user');
		$user = M($config);
		// $this->rsts = $user->select();
		$rst = $user->execute("UPDATE user SET name = 'dlm' WHERE id = 2");
		$this->rsts = $user->query("SELECT * FROM user");
		// $user = obj('Post', '', $config);
		// $this->rsts = $user->getAll();
		// $this->rsts = $user->getOne();
		$this->display('index');
	}

	function actionMail(){
		$config = array(
			'host'	=>	'mail.yy.com',
			'username'	=>	'ssy@ssy.com',
			'password'	=>	'ssy',
			'port'	=>	25,
			'from'	=> array(
				'email'	=>	'ssy@ssy.com',
				'name'	=>	'ssy'
				),
			'to'	=>	array(
				array(
					'email'	=>	'ssy@ssy.com',
					'name'	=>	'ssy'
					),
				),
			'cc'	=>	array(
				array(
					'email'=>'ssy@ssy.com',
					'name'=>'ssy'
					)
				),
			'attachments' => array(array('filepath' => BASE_DIR.'index.php', 'filename'	=>	'abc.php'),array('filepath' => BASE_DIR.'.htaccess')),
			'subject' 	=>	'test',
			'content'	=>	'<b>aa啊</b>'
			);
		$rst = obj('Mail')->send($config);
		
	}
	

}