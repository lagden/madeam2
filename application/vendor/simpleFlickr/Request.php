<?php
namespace simpleFlickr;
class Request{
	const TIMEOUT_CONNECTION = 20;
	const TIMEOUT_TOTAL = 50;
	//
	protected $_api = null;
	protected $_method = null;
	protected $_params = array();

	public function __construct($api,$method,$params=null){
		$this->_api=$api;
		$this->_method=(string) $method;
		if(!is_null($params))$this->_params=$params;
	}
	
	public function __isset($k){
		return isset($this->_params[$k]);
	}
	
	public function __toString(){
		return $this->buildUrl();
	}

	static function submit($url, $postParams = null, $timeout = self::TIMEOUT_TOTAL){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		if(isset($postParams))curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
		else curl_setopt($ch, CURLOPT_POSTFIELDS, "");        	
		// make sure problems are caught
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		// return the output
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// set the timeouts
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::TIMEOUT_CONNECTION);
		curl_setopt($ch, CURLOPT_TIMEOUT,$timeout);
		// set the PHP script's timeout to be greater than CURL's
		set_time_limit(self::TIMEOUT_CONNECTION + $timeout + 5);
		//
		$result = curl_exec($ch);
		// check for errors
		if(0 == curl_errno($ch)) {
			curl_close($ch);
			return $result;
		} else {
			$ex = new \Exception('Request failed. ' . curl_error($ch), curl_errno($ch), $url);
			curl_close($ch);
			throw $ex;
		}
	}

	static function signParams($secret,$params){
		$signing='';
		$values=array();
		ksort($params);
		foreach($params as $k => $v) {
			$signing.=$k . $v;
			$values[]=$k . '=' . urlencode($v);
		}
		$values[] = 'api_sig=' . md5($secret . $signing);
		return implode('&', $values);
	}

	public function url(){
		$api=$this->_api;
		$params=array_merge($api->getParamsForRequest(),$this->_params);
		$params['method']=$this->_method;
		return $api->_endpointUrl . '?' . self::signParams($api->_secret,$params);
	}

	public function execute(){
		$url=$this->url();
		$result=self::submit($url);
		//
		return new \simpleFlickr\Response($result,$this->_params['format'],$this->_params['nojsoncallback']);
	}
}
