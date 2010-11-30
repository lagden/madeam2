<?php
namespace lagden;
/**
*
* @author Lagden
*/
class Cookie{
	
	public static function get($name,$value=null){
		return isset($_COOKIE[$name])?$_COOKIE[$name]:$value;
	}
	
	public static function set($name,$value=null,$day=false,$path="/",$domain=false,$secure=false){		
		$day=($day)?time()+60*60*24*$day:0;
		setcookie($name,$value,$day,$path,$domain,$secure);
	}

	public static function manage($name,$value=null,$path='/',$reset=false){
		$cookie=static::get($name);
		if(!$cookie||$reset){
			static::set($name,$value,false,$path);
			return $value;
		}else{
			return $cookie;
		}
	}
	
}