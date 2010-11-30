<?php
namespace madeam\helper;
class Form extends Html{

	public static function open($action = null, $_params = array()) {
		$params = array();
		if (isset($_params['file'])) {
			$params['enctype'] = 'multipart/form-data';
			unset($_params['file']);
		}

		if (!isset($_params['method'])) {
			$_params['method'] = 'post';
		}

		$params['action'] = \madeam\Framework::url($action);
		$params = array_merge($params, $_params);

		if($_params['method']=='put' || $_params['method']=='delete') {
			$params['method'] = 'post';
			return static::openTag('form', $params) . "\n" . static::hidden('_method', $_params['method']);
		} else {
			return static::openTag('form', $params);
		}
	}

	public static function close() {
		return static::closedTag('form', array());
	}

	public static function hidden($name, $value = null, $_params = array()) {
		$params = array();
		$params['name'] = static::$name$name);
		$params['type'] = 'hidden';
		$params['value'] = static::fieldValue($name, $value);
		$params = array_merge($params, $_params);
		return static::tag('input', $params);
	}
	
	/*
	$test=array('a','b','c');
	foreach($test as $k=>$v){
		echo \madeam\helper\Form::labelOpen("Item{$k}");
		echo \madeam\helper\Form::checkbox("Item[chk][]",$v,null);
		echo \madeam\helper\Form::labelClose();
	}
	//*/
	public static function checkbox($name, $checked_value = null, $source_value = null, $_params = array()) {
		$params = array();
		$params['name'] = $name;
		$params['type'] = 'checkbox';

		$source_value = static::fieldValue($name, $source_value);
		if ($checked_value == $source_value) {
			$params['checked'] = true;
		} else {
			$params['checked'] = false;
		}
		$params['value'] = static::fieldValue($name, $checked_value);
		$params = array_merge($params, $_params);
		return static::tag('input', $params);
	}

	public static function radio($name, $checked_value = null, $source_value = null, $_params = array()) {
		$params = array();
		$params['name'] = $name;
		$params['type'] = 'radio';

		$source_value = static::fieldValue($name, $source_value);
		if ($checked_value == $source_value) {
			$params['checked'] = true;
		} else {
			$params['checked'] = false;
		}
		$params['value'] = $checked_value;
		$params = array_merge($params, $_params);
		return static::tag('input', $params);
	}

	public static function input($name, $value = null, $_params = array()) {
		$params=array();
		$params['name'] = $name;
		$params['type'] = 'text';
		$params['value'] = static::fieldValue($name, $value);
		$params = array_merge($params, $_params);
		return static::tag('input', $params);
	}

	public static function openLabel($value = null, $_params = array()) {
		return static::openTag('label', $_params, $value);
	}

	public static function closeLabel() {
		return static::closedTag('label', array());
	}

	public static function label($value = null, $_params = array()) {
		$params = array();
		$params['value'] = $value;
		$params = array_merge($params, $_params);
		return static::wrappingTag('label', $value, $params);
	}

	public static function text($name, $value = null, $params = array()) {
		return static::input($name, $value, $params);
	}

	public static function email($name, $value = null, $_params = array()){
		$params=array();
		$params['type'] = 'email';
		$params = array_merge($params, $_params);
		return static::input($name, $value, $params);
	}

	public static function url($name, $value = null, $_params = array()) {
		$params=array();
		$params['type'] = 'url';
		$params = array_merge($params, $_params);
		return static::input($name, $value, $params);
	}

	public static function password($name, $value = null, $_params = array()){
		$params=array();
		$params['type'] = 'password';
		$params = array_merge($params, $_params);
		return static::input($name, $value, $params);
	}

	public static function file($name, $value = null, $_params = array()) {
		$params=array();
		$params['type'] = 'file';
		$params = array_merge($params, $_params);
		return static::input($name, $value, $params);
	}

	public static function textarea($name, $value = null, $_params = array()) {
		$params = array();
		$params['name'] = $name;
		$params = array_merge($params, $_params);
		return static::wrappingTag('textarea', static::fieldValue($name, $value), $params);
	}

	public static function button($value=null,$_params = array()) {
		$params = array();
		$params['type'] = 'button';
		if(! isset($params['name'])){
			$params['name'] = $name;
		}
		$params = array_merge($params, $_params);
		return static::wrappingTag('button',$value,$params);
	}

	public static function submit($value='Submit',$_params = array()){
		$params=array();
		$params['type'] ='submit';
		$params = array_merge($params, $_params);
		return static::button($value, $params);
	}

	public static function reset($value='Reset', $_params = array()) {
		$params=array();
		$params['type'] ='reset';
		$params = array_merge($params, $_params);
		return static::button($value, $params);
	}

	public static function dropdown($name, $selected, $values = array(), $_params = array()) {
		$params=array();
		$params['name'] = $name;
		$contents = array();
		$selected = static::fieldValue($name, $selected);

		if (! empty($values)) {
			foreach ($values as $key => $label) {
				$o_params = array();
				if ($selected == $key) { $o_params['selected'] = true; }
				$o_params['value'] = $key;
				$contents[] = static::wrappingTag('option', $label, $o_params);
			}
		}

		$params = array_merge($params, $_params);
		return static::wrappingTag('select', implode($contents), $params);
	}
	
	/**
	* Protected functions.
	* =======================================================================
	*/
	protected static function fieldValue($fieldName, $setValue){
		$pattern='/(\w+)\[(\w+)\]?((\[\])|())/i';
		$bloco=preg_replace($pattern,'$1', $fieldName);
		$nome=preg_replace($pattern,'$2', $fieldName);
		$array=preg_replace($pattern,'$3', $fieldName);
		//
		if($bloco===$nome){
			if(isset($_POST[$bloco]))$value=$_POST[$bloco];
			else $value=null;
		}else{
			if(isset($_POST[$bloco][$nome]))$value=$_POST[$bloco][$nome];
			else $value=null;
		}
		//
		if(empty($value))$value=$setValue;
		return htmlspecialchars(stripslashes($value));
	}
	//
}