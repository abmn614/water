<?php 

function C($key){
	return $GLOBALS[$key];
}

function M($config){
    return new Model($config);
}