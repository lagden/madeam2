<?php
namespace lagden;
/**
*
* @author Lagden
*/
class Util{

	// DropDown
	public static function dropdown($q,$k,$v,$selecione=true){
		$down=array();
		if($selecione)$down=array(''=>'Selecione');
		foreach((array)$q as $item)$down[$item->$k]="{$item->$v}";
		return $down;
	}

	// Short text
	public static function limit($text, $words=10){
		$map='0123456789áàãâäÁÀÃÂÄªéèêëÉÈÊË&íìîïÍÌÎÏóòõôöÓÒÕÔÖºúùûüÚÙÛÜçÇñÑ<>/';
		$swc=str_word_count($text,2,$map);
		if(count($swc)>$words){
			$pos=array_keys($swc);
			$text=substr($text, 0, $pos[$words]) . '...';
		}
		return $text;
	}

	// Curl helper function
	public static function curl_get($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		$return = curl_exec($curl);
		curl_close($curl);
		return $return;
	}
	
}