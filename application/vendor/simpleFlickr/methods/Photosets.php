<?php
namespace simpleFlickr\methods;
class Photosets{

	const METHOD_GETLIST='flickr.photosets.getList';
	const METHOD_GETPHOTOS='flickr.photosets.getPhotos';
	protected $_api;
	
	public function __construct($api){
		$this->_api=$api;
	}

	public function getList($params){
		if(!isset($params['user_id']))throw new \Exception('The photoset needs a User Id.');
		return $this->_api->createRequest(self::METHOD_GETLIST,$params);
	}
	
	public function getPhotos($params){
		return $this->_api->createRequest(self::METHOD_GETPHOTOS,$params);
	}
}