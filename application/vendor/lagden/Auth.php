<?php
namespace lagden;
if(! defined('CRYPTSET'))define('CRYPTSET','$6$rounds=5000$');
if(! defined('AUTHSALT'))define('AUTHSALT','lagden$');
class Auth{
	
	static public function db($input='auth'){
		$password=crypt($input,CRYPTSET.AUTHSALT);
		$length=strlen(CRYPTSET.AUTHSALT);
		return substr($password,$length);
	}
	
	static public function chk($input,$db){
		$password=CRYPTSET.AUTHSALT.$db;
		if(crypt($input,$password)==$password)return true;
		else return false;
	}
	
}