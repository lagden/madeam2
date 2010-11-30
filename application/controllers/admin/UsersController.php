<?php
namespace admin;
use \madeam\helper\Form as Form;
use \madeam\helper\Html as Html;
use \models\User as User;
class UsersController extends DefaultController{

	// Before Actions
	protected $beforeAction_userSetup;
	//protected $beforeRender_userBeforeRender;
	
	// Before Action Setup
	protected function userSetup(){
		$this->url='admin/users/';
		$this->formUrl=$this->url;
		$this->urlCode=\madeam\Framework::url($this->url);
		$this->modelo='models\User';
		$this->reset=false;
		$this->limit=2;
	}

	// Private
	// Complementos
	public function plus(){
		array_push($this->_js,
			Html::js('/javascripts/app/user')
		);
	}

	// Listagem com paginação
	public function listagem($page=null){
		$this->cols=array('id'=>'Ação','name'=>'Nome','email'=>'Email','login'=>'Login');
		$this->noSearch=Array('id','senha');
		//
		$option['order']="id DESC";
		//
		$this->listAction($page,$option);
	}	
}