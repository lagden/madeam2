<?php
namespace lagden;
/**
*
* @author Lagden
*/
class Cache{
	
	public static function get($path,$file){
		if(is_dir($path)){
			if(file_exists($path.$file)){
				$handle=fopen($path.$file,"r");
				$content=fread($handle,filesize($path.$file));
				fclose($handle);
				return $content;
			}
		}
		return false;
	}
	
	public static function set($path,$file,$content,$mode='w+'){
		if(!is_dir($path))mkdir($path,0775,true);	
		$handle=fopen($path.$file,$mode);
		fwrite($handle,$content);
		fclose($handle);
	}
	
	public static function clear($path,$file){
		if(is_dir($path)){
			if(file_exists($path.$file))return unlink($path.$file);
		}
		return false;
	}
	
	public static function clearAll($path,$rmdir=true){
		if(is_dir($path)){
			if($handle=opendir($path)){
			    while(false!==($file=readdir($handle))){
					if($file!="."&&$file!=".."){
						if(is_dir($path.$file))static::clearAll($path.$file.DIRECTORY_SEPARATOR);
						else{
							if(file_exists($path.$file))unlink($path.$file);
						}
					}
			    }
			    closedir($handle);
			}
			return ($rmdir)?rmdir($path):true;
		}
		return false;
	}
	
}