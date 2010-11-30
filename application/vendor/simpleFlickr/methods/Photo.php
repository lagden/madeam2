<?php
namespace simpleFlickr\methods;
class Photo{
	const SIZE_75PX = 's';
	const SIZE_100PX = 't';
	const SIZE_240PX = 'm';
	const SIZE_500PX = '-';
	const SIZE_640PX = 'z';
	const SIZE_1024PX = 'b';
	const SIZE_ORIGINAL = 'o';
	
	protected $_data=array();
	
	public function &__get($name) {
		return $this->_data[$name];
	}
	
	public function __set($name,$value) {
		$this->_data[$name]=$value;
	}
	
	public function __isset($k){
		return isset($this->_data[$k]);
	}
	
	public function __construct($api){
		$this->_api=$api;
	}
	
	public function __destruct(){
		unset($this->_data);
	}

	static public function url($userId,$photoId) {
		return "http://flickr.com/photos/{$userId}/{$photoId}/";
	}

	public function img($item,$size=self::SIZE_240PX,$primary=false){
		foreach($item as $k=>$v)$this->obj->$k=$v;
		
		$type = 'jpg';
		$sizeStr = "_{$size}";

		switch ($size){
			case self::SIZE_500PX:
			$sizeStr='';
			break;

			case self::SIZE_ORIGINAL:
			$type=$this->obj->originalformat;
			$this->_url="http://farm{$this->obj->farm}.static.flickr.com/{$this->obj->server}/{$this->obj->id}_{$this->obj->originalsecret}{$sizeStr}.{$type}";
			return $this->_url;
			break;
		}
		//
		if($primary)$this->_url="http://farm{$this->obj->farm}.static.flickr.com/{$this->obj->server}/{$this->obj->primary}_{$this->obj->secret}{$sizeStr}.{$type}";
		else $this->_url="http://farm{$this->obj->farm}.static.flickr.com/{$this->obj->server}/{$this->obj->id}_{$this->obj->secret}{$sizeStr}.{$type}";
		//
		return $this->_url;
	}
	
    public function sizes($id,$format='json'){
		$api=$this->_api;
		$ex=$api->executeMethod('flickr.photos.getSizes',array('photo_id'=>$id,'format'=>$format));
		if($format=='json')$r=$api::parseJsonToObj($ex);
		elseif($format=='php_serial')$r=unserialize($ex);
		else throw new \Exception('Must be a json or php_serial.');
		switch($format){
			case 'json':
			$r=$api::parseJsonToObj($ex);
			return isset($r->sizes)?$r->sizes:false;
			break;
			
			case 'php_serial':
			$r=unserialize($ex);
			return isset($r['sizes'])?$r['sizes']:false;
			break;
			
			default:
			throw new \Exception('Must be a json or php_serial.');
		}
	}
	
	public function save($path,$filename,$obj=false,$size=self::SIZE_240PX){
		if($obj)$url=$this->img($obj,$size);
		else $url=$this->_url;
		
		if(!is_dir($path))mkdir($path,0775,true);
		$data=static::file_get_contents_curl($url);
		$handle=fopen($path.$filename,'wb');
		if($handle){
			fwrite($handle,$data);
			fclose($handle);
		}else throw new \Exception('You do not have permission to write.');
	}
	
	static public function file_get_contents_curl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	
}
