<?php 
Class Post extends Model{

	function __construct($config){
		parent::__construct($config);
	}

	function getAll(){
		return $this->select();
	}

	function getOne(){
		return $this->order('id desc')->limit(1)->select();
	}
}

