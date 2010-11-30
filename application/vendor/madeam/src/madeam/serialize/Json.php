<?php
namespace madeam\serialize;
class Json {

	public static function encode($data) {
		$data = self::__object($data);
		return json_encode($data);
	}

	static private function __object($data){
		if (is_array($data)) {
			foreach ($data as &$d)$d=static::__object($d);
		}elseif($data instanceof \IteratorAggregate)$data = (object) $data->getIterator();
		return $data;
	}

	public static function decode($data,$array=false) {
		return json_decode($data,$array);
	}
	//
}