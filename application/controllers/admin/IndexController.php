<?php
namespace admin;
use \madeam\helper\Form as Form;
use \madeam\helper\Html as Html;
class IndexController extends \CrudController{

	// Before Actions
	protected $beforeAction_indexSetup;
	
	// Before Action Setup
	protected function indexSetup(){
		$this->url='admin/index/';
		$this->urlCode=\madeam\Framework::url($this->url);
	}

	// Index
	public function indexAction($r){
		//...Code
	}
	
}