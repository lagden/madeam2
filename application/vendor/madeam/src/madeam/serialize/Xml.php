<?php
namespace madeam\serialize;

class Xml extends \XMLWriter{

	public static function encode($data) {
		$this->openMemory();
		$this->startDocument('1.0', 'UTF-8');
		$this->startElement('data');

		static::_array2Xml($data, $this);

		$this->endElement();

		return $this->outputMemory(false);
	}

	public static function decode($data) {
		// Code...
	}

	private static function _array2Xml($array, &$this) {
		foreach($array as $key => $value) {
			$key = str_replace(" ", '_', $key);
			if(is_array($value)){
				$this->startElement($key);
				static::_array2Xml($value, $this);
				$this->endElement();
				continue;
			}
			$this->writeElement($key, $value);
		}
	}

}