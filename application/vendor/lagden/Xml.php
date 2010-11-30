<?php
namespace lagden;
class Xml extends \XMLWriter{
	
	public $cdata;
	public $root;

	public function __construct($root=false,$cdata=false){
		$this->cdata=$cdata;
		$this->root=$root;
		$this->openMemory();
		$this->setIndent(true);
		$this->setIndentString(' ');
		$this->startDocument('1.0', 'UTF-8');
		if($this->root)$this->startElement($this->root);
	}

	public function setElement($prm_ElementText){
		if($this->cdata)$this->startCData();
		$this->text($prm_ElementText);
		if($this->cdata)$this->endCData();
	}
	
	public function setAttributes($arr=array()){
		foreach ($arr as $k => $v)$this->writeAttribute($k, $v);
	}

	public function fromArray($prm_array){
		if(is_array($prm_array)){
			foreach ($prm_array as $index => $element){
				if(is_array($element)){
					if($index=="__node"){
						$this->fromArray($element);
					}elseif($index=="__attr"){
						$this->setAttributes($element);
					}elseif(is_int($index)){
						$this->fromArray($element);
					}else{
						$this->startElement($index);
						$this->fromArray($element);
						$this->endElement();
					}
				}elseif($index=="__text")$this->setElement($element);
			}
		}
	}
	
	public function end(){
		if($this->root)$this->endElement();
		$this->endDocument();
	}
	
	public function show(){
		header('Content-type: text/xml');
		echo $this->outputMemory();
	}

	public function output(){
		return $this->outputMemory();
	}


}