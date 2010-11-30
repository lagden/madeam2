<?php
namespace simpleFlickr;
class Response{
	const STAT_OK = 'ok';
	const STAT_FAIL = 'fail';

	public $stat;
	public $response;

	public function __construct($result,$format=null,$extra=null){
		switch($format){
			case 'json':
			if($extra)$r=json_decode($result);
			else{
				unset($this->stat);
				$this->response=$result; //JSONP
				return true;
			}
			break;

			case 'php_serial':
			$r=unserialize($result);
			break;

			default:
			$r=simplexml_load_string($result);
			if(false===$r)throw new \Exception('Could not parse XML.');
		}
		//
		$this->stat=$this->setStat($r,$format);
		if($this->isOk()){
			unset($this->stat);
			$this->response=$r;
		}
		else throw new \Exception('Response fail');
	}
	
	public function isOk(){
		return ($this->stat == self::STAT_OK);
	}

	public function setStat($r,$format){
		if($format=='json')return $r->stat;
		else return $r['stat'];
	}

}
