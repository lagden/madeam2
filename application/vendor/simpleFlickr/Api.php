<?php
namespace simpleFlickr;
class Api{
	
	protected $_data=array();
	
	public function &__get($name) {
		return $this->_data[$name];
	}
	
	public function __set($name, $value) {
		$this->_data[$name] = $value;
	}
	
	public function __isset($k){
		return isset($this->_data[$k]);
	}
	
	public function __construct($key, $secret, $token = null){
		$this->_endpointUrl='http://flickr.com/services/rest/';
		
	    if(isset($key))$this->_key=(string) $key;
	    else throw new \Exception('Must provide a Flickr API key.');
	
	    if(isset($secret))$this->_secret=(string) $secret;
		else throw new \Exception('Must provide a Flickr API secret.');
		
	    if(isset($token))$this->_token=(string) $token;
	}
	
    static public function createFrom($filename) {
        $contents=file_get_contents($filename);
		$config=json_decode($contents);
		if(is_object($config)){
        	$api=new \simpleFlickr\Api($config->key,$config->secret,$config->token);
			return $api;
		}else throw new \Exception('Config file error.');
    }

    public function getParamsForRequest() {
        $params['api_key']=$this->_key;
		$params['auth_token']=$this->_token;
        return $params;
    }

    public function createRequest($method,$params=null){
        return new \simpleFlickr\Request($this,$method,$params);
    }

    public function executeMethod($method,$params=null){
        return $this->createRequest($method, $params)->execute();
    }
	
}