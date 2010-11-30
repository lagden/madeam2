<?php
namespace lagden;
class Form{
	
	public static function Field($arr=array()){
		$type=isset($arr['type'])?$arr['type']:false;
		$label=isset($arr['label'])?$arr['label']:false;
		$element=isset($arr['element'])?$arr['element']:false;
		if(!$type||!$element)return false;
		if($label)$addLabel=self::Tag('label',$label);
		else $addLabel="";
		switch($type){
			case 'button':
			case 'textarea':
				return $addLabel.self::Tag($type,$element);
				break;
			case 'text':
			case 'submit':
			case 'reset':
			case 'image':
			case 'password':
			case 'hidden':
			case 'file':
				return $addLabel.self::Input($type,$element);
				break;
			case 'radio':
			case 'checkbox':
				return $addLabel.self::RadioOrCheck($type,$element);
				break;
			case 'select':
				return $addLabel.self::Select($element);
				break;
			default:
				return false;
		}
		return false;
	}
	
	public static function openForm($arr=array()){
		return self::openTag('form',$arr);
	}
	
	public static function closeForm(){
		return self::closedTag('form');
	}
	
	public static function Tag($type,$arr=array()){
		$value=isset($arr['value'])?htmlspecialchars(stripslashes($arr['value'])):null;
		$s='<'.$type;
		foreach((array)$arr['params'] as $k=>$v)$s.=" {$k}=\"{$v}\"";
		$s.=">{$value}</{$type}>";
		return $s;
	}

	public static function Input($type,$arr=array()){
		$value=isset($arr['value'])?htmlspecialchars(stripslashes($arr['value'])):null;
		$s='<input type="'.$type.'"';
		foreach((array)$arr['params'] as $k=>$v)$s.=" {$k}=\"{$v}\"";
		$s.=($value)?' value="'.$value.'"':'';
		$s.=' />';
		return $s;
	}
	
	public static function RadioOrCheck($type,$arr=array()){
		$value=isset($arr['value'])?$arr['value']:null;
		$value=is_array($value)?$value:explode(",",$arr['value']);
		$opt=isset($arr['opt'])?$arr['opt']:false;
		$br=isset($arr['br'])?$arr['br']:false;
		if(!is_array($opt))return false;
		return self::Build($arr['params'],$arr['opt'],$type,$value,$br);
	}
	
	public static function Select($arr=array()){
		$value=isset($arr['value'])?$arr['value']:null;
		$selecione=isset($arr['selecione'])?$arr['selecione']:false;
		$multiple=isset($arr['multiple'])?$arr['multiple']:false;
		$slash=isset($arr['slash'])?$arr['slash']:false;
		$extra=isset($arr['extra'])?$arr['extra']:false;
		$opt=isset($arr['opt'])?$arr['opt']:false;
		if(!is_array($opt))return false;
		$s='<select';
		if($multiple)$s.=' multiple="multiple"';
		foreach((array)$arr['params'] as $k=>$v){
			if($k=='name'&&$multiple)$v="{$v}[]";
			$s.=" {$k}=\"{$v}\"";
		}
		$s.='>';
		if($selecione){
			$s.='<option value="">'.$selecione.'</option>';
			if($slash)$s.='<option value="">---------------</option>';
		}
		if(is_array($extra))$s.=self::Option($extra,$value);
		$s.=self::Option($opt,$value);
		$s.='</select>';
		return $s;
	}
	
	protected static function Build($arr,$opt,$type,$value,$br){
		$keys=isset($opt['key'])?$opt['key']:false;
		$values=isset($opt['value'])?$opt['value']:false;
		$checado=false;
		$s="";
		$c=0;
		$id=false;
		foreach((array)$values as $k=>$v){
			$s.=($c&&$br)?'<br />':'';
			$s.=self::openTag('label');
			$s.='<input type="'.$type.'"';
			foreach((array)$arr as $a=>$b){
				if($a=='id')$b=$id="{$b}{$c}";
				if($a=='name'&&$type=='checkbox')$b="{$b}[]";
				$s.=" {$a}=\"{$b}\"";
			}
			$s.=' value="'.htmlspecialchars(stripslashes($v)).'"';
			if(!$checado&&$value&&$type=='radio'){
				if(in_array($v,$value)){
					$s.=' checked="checked"';
					$checado=true;
				}
			}elseif($type=='checkbox')$s.=($value)?((in_array($v,$value))?' checked="checked"':''):'';
			$s.=' />';
			$s.=(is_array($keys))?$keys[$k]:$v;
			$s.=self::closedTag('label');
			$c++;
		}
		return $s;
	}
	
	protected static function Option($opt,$value){
		$keys=isset($opt['key'])?$opt['key']:false;
		$values=isset($opt['value'])?$opt['value']:false;
		$value=($value)?explode(",",$value):null;
		$s='';
		foreach((array)$values as $k=>$v){
			$s.='<option value="'.htmlspecialchars(stripslashes($v)).'"';
			$s.=($value)?((in_array($v,$value))?' selected="selected"':''):'';
			$s.='>'.htmlspecialchars(stripslashes((is_array($keys))?$keys[$k]:$v)).'</option>';
		}
		return $s;
	}
	
  protected static function openTag($tag, $params = array(), $value=null) {
    $params = self::paramsToHtml($params);
    return '<' . $tag . ' ' . $params . '>'.$value;
  }

	protected static function closedTag($tag) {
		return "</{$tag}>";
	}
	
	protected static function paramsToHtml($params=array()) {
		$html = array();
		foreach($params as $param => $value){
			if ($value===true)$html[]=$param;
			elseif($value!==false)$html[]="{$param}=\"{$value}\"";
		}
		return implode(' ', $html);
	}
	
}